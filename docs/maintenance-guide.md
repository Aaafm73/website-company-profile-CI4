# Maintenance Guide for Admin and Frontend Popup / Default Variable Code

## Overview

This guide documents the recent changes made to improve popup behavior and prevent undefined variable issues in the admin and frontend views.

The primary changes are:

- SweetAlert2 integration for nicer popups and confirmations.
- Safe AJAX flows with success/error handling.
- Central admin default view data via `BaseAdminController::adminDefaults()`.
- `deleteConfirm()` helper for CSRF-safe delete confirmation.
- Frontend cart interactions improved with toast notifications.

---

## Files Changed

### Admin

- `app/Views/admin/layout/footer.php`
- `app/Views/admin/contacts/detail.php`
- `app/Views/admin/orders/detail.php`
- `app/Views/admin/products/index.php`
- `app/Views/admin/orders/index.php`
- `app/Views/admin/contacts/index.php`
- `app/Controllers/Admin/BaseAdminController.php`
- `app/Controllers/Admin/Contacts.php`
- `app/Controllers/Admin/Orders.php`

### Frontend

- `app/Views/frontend/layout/header.php`
- `app/Views/frontend/layout/footer.php`
- `app/Views/frontend/product_detail.php`

---

## File Summary

This section helps future maintainers quickly understand where each feature lives.

- `app/Views/admin/layout/footer.php`: central admin JS helper file for SweetAlert2 toasts, modals, order/contact updates, and delete confirmations.
- `app/Views/frontend/layout/header.php`: frontend page header and CSRF token exposure for AJAX requests.
- `app/Views/frontend/layout/footer.php`: frontend JS helpers for cart actions plus SweetAlert2 integration.
- `app/Views/admin/contacts/index.php`: contacts listing page with status buttons, delete flow, and pagination.
- `app/Views/admin/contacts/detail.php`: single contact detail view with status update form and reply action.
- `app/Views/admin/orders/index.php`: order listing page with status filters, delete flow, and pagination.
- `app/Views/admin/orders/detail.php`: order detail page with status update and notes update via AJAX.
- `app/Controllers/Admin/BaseAdminController.php`: shared admin defaults for view variables and login guard logic.
- `app/Controllers/Admin/Contacts.php`: contact CRUD and AJAX status update endpoints.
- `app/Controllers/Admin/Orders.php`: order CRUD and AJAX update endpoints.
- `app/Views/frontend/product_detail.php`: product detail page with AJAX add-to-cart handler.

### Commenting Guidance

Each file now contains inline comments around key functions so maintainers can add new flows without guessing the purpose of the handler.

## Admin Popup and Confirmation Flow

### `app/Views/admin/layout/footer.php`

This file now includes SweetAlert2 via CDN and defines reusable helper functions:

- `showToast(type, message, timer = 2000)`
  - Shows a compact toast in the top-right corner.
  - `type` can be `success`, `error`, `warning`, or `info`.

- `showModal(title, text, icon = 'info')`
  - Shows a modal dialog with an icon.

- `updateOrderStatus(orderId)`
  - Sends a POST request to `/admin/orders/update-status/{id}`.
  - Includes CSRF token from `window.csrfName` and `window.csrfHash`.
  - Shows success toast or error modal.
  - Reloads the page after a short delay on success.

- `updateContactStatus(contactId)`
  - Sends a POST request to `/admin/contacts/update-status/{id}`.
  - Uses the same toast/modal pattern.

- `deleteConfirm(url, itemName)`
  - Opens a SweetAlert2 confirmation dialog.
  - If confirmed, submits a hidden POST form with CSRF token to the given URL.
  - This avoids GET-based deletes and keeps server routing safe.

### Where this is used

The delete action forms in admin list views now use `deleteConfirm()` instead of browser `confirm()`:

- `app/Views/admin/products/index.php`
- `app/Views/admin/orders/index.php`
- `app/Views/admin/contacts/index.php`

Example implementation:

```php
<form action="/admin/products/delete/<?= $product['id'] ?>" method="POST" style="display:inline-block; margin:0;" onsubmit="event.preventDefault(); deleteConfirm(this.action, '<?= esc($product['name']) ?>');">
```

That means the delete button is still inside a form, but SweetAlert2 intercepts the submit and posts the form only after confirmation.

> Note: I also added inline comments to these forms so maintainers can see immediately that the handler uses SweetAlert2 and CSRF-safe POST submission.

### Admin detail views

Both detail pages now use the SweetAlert2 helper functions instead of `alert()`:

- `app/Views/admin/contacts/detail.php`
- `app/Views/admin/orders/detail.php`

In `orders/detail.php`, both `updateStatus()` and `updateNotes()` now show:

- success toast on success
- error modal on failure
- network error modal if AJAX fails

In `contacts/detail.php`, the status update also uses the same pattern.

---

## Frontend Cart and Product Detail Popups

### `app/Views/frontend/layout/footer.php`

This file now loads SweetAlert2 and defines frontend helpers:

- `showToast(type, message, timer = 2000)`
- `showModal(title, text, icon = 'info')`

AJAX actions now show better notifications:

- `addToCart(productId)`
  - Sends POST to `checkout/add-to-cart`
  - Shows toast on success
  - Shows modal on failure

- `removeFromCart(productId)`
  - Shows confirmation modal before delete
  - Sends POST to `checkout/remove-from-cart`
  - Reloads after success

- `updateQuantity(productId, quantity)`
  - Sends POST to `checkout/update-cart`
  - If quantity is less than 1, it calls `removeFromCart()`

All requests now include CSRF tokens in `data`.

### `app/Views/frontend/product_detail.php`

The add-to-cart action now uses SweetAlert2 to show feedback instead of plain `alert()`.

---

## Admin Default View Data

### `app/Controllers/Admin/BaseAdminController.php`

A new helper method was added:

```php
protected function adminDefaults(string $type = 'contact', array $overrides = []): array
```

It returns default admin view variables such as:

- `statuses`
- `statusLabel`
- `statusColor`

Usage:

- `Contacts::index()` and `Contacts::detail()` merge `adminDefaults('contact')`
- `Orders::index()` and `Orders::detail()` merge `adminDefaults('order')`

This ensures views can always rely on `$statuses` existing, even if the controller does not explicitly set it.

### Why this helps

Previously, views could break with `Undefined variable: statuses` when the controller did not pass that key.

Now every admin view that uses status lists is protected by those default values.

---

## CSRF Token Handling

### `app/Views/admin/layout/header.php`

The admin header injects CSRF tokens into JavaScript globals:

```html
<script>
    window.csrfName = '<?= csrf_token() ?>';
    window.csrfHash = '<?= csrf_hash() ?>';
</script>
```

### `app/Views/frontend/layout/header.php`

The frontend header also now injects the same CSRF globals so cart/AJAX features can use them safely.

These values are reused by both admin and frontend JS to send secure POST requests.

---

## Best Practices for Maintenance

### Changing status values

- For contact statuses, update `adminDefaults('contact')` in `BaseAdminController`.
- For order statuses, update `adminDefaults('order')` in `BaseAdminController`.
- Keep the view labels in sync with the status arrays.

### Adding a new flow or popup

1. Add the new route/controller action.
2. Return JSON with `success` and `message` keys.
3. Add a JS wrapper in `admin/layout/footer.php` or `frontend/layout/footer.php`.
4. Use `showToast()` for success and `showModal()` for errors.

### Debugging AJAX issues

- Open browser DevTools Network tab.
- Check the POST request payload and response JSON.
- If a response is not JSON, the page may be returning a PHP error.
- Confirm the CSRF token is present.

### Reusing the helpers

These helpers are intentionally generic:

- `showToast(type, message)` can be used in any new AJAX flow.
- `showModal(title, text, icon)` can be reused for validation errors, confirmations, etc.

---

## Quick Reference

### Admin success popup

```js
showToast('success', 'Pesan berhasil');
```

### Admin error popup

```js
showModal('Gagal', 'Terjadi kesalahan', 'error');
```

### Confirm delete

```js
deleteConfirm('/admin/contacts/delete/1', 'Kontak John Doe');
```

### Frontend error

```js
showModal('Kesalahan', 'Tidak dapat menghubungi server', 'error');
```

### Frontend toast

```js
showToast('success', 'Produk ditambahkan ke keranjang');
```

---

## Notes

- If you want a centralized frontend defaults document, the same pattern can be extended to `app/Controllers/BaseController`.
- The SweetAlert2 CDN usage is fine for development, but for production you may want to bundle it locally.
- If you update the admin header or footer, make sure both the JS helpers and CSRF globals remain present.

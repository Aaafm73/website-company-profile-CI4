<?php
// Frontend view defaults to avoid undefined variable notices in views
$products = $products ?? [];
$categories = $categories ?? [];
$selected_category = $selected_category ?? '';
$pager = $pager ?? null;
$orders = $orders ?? [];
$recentOrders = $recentOrders ?? [];
$recentContacts = $recentContacts ?? [];
$selectedOrder = $selectedOrder ?? null;
$cart = $cart ?? [];
$total = $total ?? 0;

// Company info
$company_name = $company_name ?? getenv('APP_NAME') ?? 'Perusahaan Kami';
$company_phone = $company_phone ?? '';
$company_email = $company_email ?? '';
$company_address = $company_address ?? '';

?>

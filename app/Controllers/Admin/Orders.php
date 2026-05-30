<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;

class Orders extends BaseAdminController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel = new ProductModel();
    }

    /**
     * Show paginated orders and filter by selected status.
     */
    public function index()
    {
        $status = $this->request->getGet('status');
        $query = $this->orderModel;

        if ($status && in_array($status, ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])) {
            $query = $query->where('status', $status);
        }

        $orders = $query->orderBy('created_at', 'DESC')->paginate(10);

        $data = [
            'title' => 'Kelola Pesanan | Vegetarian Paradise',
            'orders' => $orders,
            'pager' => $this->orderModel->pager,
            'selected_status' => $status,
        ];

        // Merge with admin defaults for order views (ensures $statuses exists)
        $data = array_merge($this->adminDefaults('order'), $data);

        return view('admin/orders/index', $data);
    }

    /**
     * Show order detail, including items and status controls.
     */
    public function detail($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        $order['items'] = $this->orderItemModel->getItemsWithProductDetails($id);

        $data = [
            'title' => 'Detail Pesanan ' . $order['order_number'] . ' | Vegetarian Paradise',
            'order' => $order,
        ];

        // Merge with admin defaults for order views
        $data = array_merge($this->adminDefaults('order'), $data);

        return view('admin/orders/detail', $data);
    }

    /**
     * Handle AJAX request to update order status.
     * Returns JSON for frontend SweetAlert2 feedback.
     */
    public function updateStatus($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pesanan tidak ditemukan']);
        }

        $status = $this->request->getPost('status');
        $validStatuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Status tidak valid']);
        }

        $previousStatus = $order['status'];

        // If status transitions to confirmed, deduct product stock.
        if ($previousStatus !== 'confirmed' && $status === 'confirmed') {
            $items = $this->orderItemModel->where('order_id', $id)->findAll();
            foreach ($items as $item) {
                $product = $this->productModel->find($item['product_id']);
                if (!$product) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Produk dalam pesanan tidak ditemukan']);
                }
                if ($product['stock'] < $item['quantity']) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Stok produk tidak mencukupi untuk mengonfirmasi pesanan']);
                }
                $this->productModel->update($product['id'], ['stock' => $product['stock'] - $item['quantity']]);
            }
        }

        // If status moves away from confirmed, restore stock for confirmed orders.
        if ($previousStatus === 'confirmed' && $status !== 'confirmed') {
            $items = $this->orderItemModel->where('order_id', $id)->findAll();
            foreach ($items as $item) {
                $product = $this->productModel->find($item['product_id']);
                if (!$product) {
                    continue;
                }
                $this->productModel->update($product['id'], ['stock' => $product['stock'] + $item['quantity']]);
            }
        }

        $this->orderModel->update($id, ['status' => $status]);

        return $this->response->setJSON(['success' => true, 'message' => 'Status pesanan berhasil diperbarui']);
    }

    /**
     * Handle AJAX request to update order notes.
     * Returns JSON for frontend SweetAlert2 feedback.
     */
    public function updateNotes($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pesanan tidak ditemukan']);
        }

        $notes = $this->request->getPost('notes');
        $this->orderModel->update($id, ['notes' => $notes]);

        return $this->response->setJSON(['success' => true, 'message' => 'Catatan berhasil diperbarui']);
    }

    /**
     * Delete an order and its item rows, then redirect to the order list.
     */
    public function delete($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }

        // Delete order items first
        $this->orderItemModel->where('order_id', $id)->delete();

        // Delete order
        $this->orderModel->delete($id);

        return redirect()->to('/admin/orders')->with('message', 'Pesanan berhasil dihapus');
    }
}

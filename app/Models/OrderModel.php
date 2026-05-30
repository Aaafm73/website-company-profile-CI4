<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['order_number', 'customer_name', 'customer_email', 'customer_phone', 'customer_address', 'total_amount', 'status', 'payment_method', 'notes'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'customer_name' => 'required|string|max_length[255]',
        'customer_email' => 'required|valid_email',
        'customer_phone' => 'required|max_length[20]',
        'customer_address' => 'required|string',
        'total_amount' => 'required|numeric',
        'payment_method' => 'required|string',
    ];

    public function generateOrderNumber()
    {
        $prefix = 'ORD-' . date('Ymd') . '-';
        $lastOrder = $this->orderBy('id', 'DESC')->first();
        $number = $lastOrder ? ((int)substr($lastOrder['order_number'], -4)) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function getOrderWithItems($orderId)
    {
        $order = $this->find($orderId);
        if ($order) {
            $itemModel = new OrderItemModel();
            $order['items'] = $itemModel->getItemsWithProductDetails($orderId);
        }
        return $order;
    }
}

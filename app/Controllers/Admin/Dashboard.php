<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\OrderModel;
use App\Models\ContactModel;
use App\Models\ProductModel;

class Dashboard extends BaseAdminController
{
    protected $orderModel;
    protected $contactModel;
    protected $productModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->contactModel = new ContactModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $totalOrders = $this->orderModel->countAllResults();
        $pendingOrders = $this->orderModel->where('status', 'pending')->countAllResults();
        $newContacts = $this->contactModel->where('status', 'new')->countAllResults();
        $totalProducts = $this->productModel->countAllResults();

        $recentOrders = $this->orderModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        $recentContacts = $this->contactModel->where('status', 'new')->orderBy('created_at', 'DESC')->limit(5)->findAll();

        $data = [
            'title' => 'Admin Dashboard | Vegetarian Paradise',
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'newContacts' => $newContacts,
            'totalProducts' => $totalProducts,
            'recentOrders' => $recentOrders,
            'recentContacts' => $recentContacts,
        ];

        return view('admin/dashboard', $data);
    }
}

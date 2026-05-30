<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ContactModel;
use App\Models\SettingModel;

class Dashboard extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $contactModel;
    protected $settingModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->contactModel = new ContactModel();
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $orderId = $this->request->getGet('order_id');
        $orderNumber = $this->request->getGet('order_number');
        $customerEmail = $this->request->getGet('email');

        $orders = [];
        $selectedOrder = null;

        if ($orderId) {
            $selectedOrder = $this->orderModel->getOrderWithItems($orderId);
            if ($selectedOrder) {
                $orders[] = $selectedOrder;
            }
        } elseif ($orderNumber) {
            $selectedOrder = $this->orderModel->where('order_number', $orderNumber)->first();
            if ($selectedOrder) {
                $selectedOrder['items'] = $this->orderItemModel->getItemsWithProductDetails($selectedOrder['id']);
                $orders[] = $selectedOrder;
            }
        } elseif ($customerEmail) {
            $orders = $this->orderModel->where('customer_email', $customerEmail)->orderBy('created_at', 'DESC')->findAll();
            foreach ($orders as &$order) {
                $order['items'] = $this->orderItemModel->getItemsWithProductDetails($order['id']);
            }
        }

        $data = [
            'title' => 'Dashboard | Vegetarian Paradise',
            'orders' => $orders,
            'selectedOrder' => $selectedOrder,
            'company_name' => $this->settingModel->getSetting('company_name', 'Vegetarian Paradise'),
        ];

        return view('frontend/dashboard', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Hubungi Kami | Vegetarian Paradise',
            'company_name' => $this->settingModel->getSetting('company_name', 'Vegetarian Paradise'),
            'company_phone' => $this->settingModel->getSetting('company_phone', ''),
            'company_email' => $this->settingModel->getSetting('company_email', ''),
            'company_address' => $this->settingModel->getSetting('company_address', ''),
        ];

        return view('frontend/contact', $data);
    }

    public function sendContact()
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|valid_email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->contactModel->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
            'status' => 'new',
        ]);

        return redirect()->to('/dashboard/contact')->with('message', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
    }

    public function trackOrder()
    {
        $email = $this->request->getPost('email');
        $orderNumber = $this->request->getPost('order_number');

        // Allow searching by order_number alone if email not provided.
        if ($orderNumber && !$email) {
            $order = $this->orderModel->where('order_number', $orderNumber)->first();
        } else {
            $order = $this->orderModel->where('customer_email', $email)->where('order_number', $orderNumber)->first();
        }

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }

        // Keep tracking on the dashboard page so status updates from admin are always shown there.
        $query = '?order_number=' . urlencode($orderNumber);
        if ($email) {
            $query .= '&email=' . urlencode($email);
        }

        return redirect()->to('/dashboard' . $query);
    }
}

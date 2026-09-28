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
        $orderId = (int) $this->request->getGet('order_id');
        $authorizedOrderIds = array_map('intval', session('authorized_order_ids') ?? []);
        $selectedOrder = null;

        if ($orderId > 0 && in_array($orderId, $authorizedOrderIds, true)) {
            $selectedOrder = $this->orderModel->getOrderWithItems($orderId);
        }

        $data = [
            'title' => 'Dashboard | Vegetarian Paradise',
            'orders' => $selectedOrder ? [$selectedOrder] : [],
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
        $email = trim((string) $this->request->getPost('email'));
        $orderNumber = trim((string) $this->request->getPost('order_number'));

        if ($email === '' || $orderNumber === '') {
            return redirect()->back()->with('error', 'Masukkan email dan nomor pesanan.');
        }

        $order = $this->orderModel
            ->where('customer_email', $email)
            ->where('order_number', $orderNumber)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }

        $authorizedOrderIds = array_map('intval', session('authorized_order_ids') ?? []);
        $authorizedOrderIds[] = (int) $order['id'];
        session()->set('authorized_order_ids', array_slice(array_values(array_unique($authorizedOrderIds)), -20));

        return redirect()->to('/dashboard?order_id=' . (int) $order['id']);
    }
}

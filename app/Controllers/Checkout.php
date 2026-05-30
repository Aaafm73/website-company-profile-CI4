<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;
use App\Models\SettingModel;

class Checkout extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $productModel;
    protected $settingModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel = new ProductModel();
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $cart = session('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/products')->with('message', 'Keranjang belanja Anda kosong');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $item) {
            $product = $this->productModel->find($item['product_id']);
            if ($product) {
                $item['product_name'] = $product['name'];
                $item['product_price'] = $product['price'];
                $item['subtotal'] = $product['price'] * $item['quantity'];
                $total += $item['subtotal'];
                $cartItems[] = $item;
            }
        }

        $data = [
            'title' => 'Checkout | Vegetarian Paradise',
            'cart' => $cartItems,
            'total' => $total,
            'company_name' => $this->settingModel->getSetting('company_name', 'Vegetarian Paradise'),
        ];

        return view('frontend/checkout', $data);
    }

    public function addToCart()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?? 1;

        $product = $this->productModel->find($productId);

        if (!$product) {
            return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan']);
        }

        $cart = session('cart') ?? [];
        $found = false;

        foreach ($cart as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
        }

        session()->set('cart', $cart);

        return $this->response->setJSON(['success' => true, 'message' => 'Produk ditambahkan ke keranjang', 'cartCount' => count($cart)]);
    }

    public function removeFromCart()
    {
        $productId = $this->request->getPost('product_id');
        $cart = session('cart') ?? [];

        $cart = array_filter($cart, function ($item) use ($productId) {
            return $item['product_id'] != $productId;
        });

        session()->set('cart', array_values($cart));

        return $this->response->setJSON(['success' => true, 'message' => 'Produk dihapus dari keranjang']);
    }

    public function process()
    {
        $cart = session('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/products')->with('message', 'Keranjang belanja Anda kosong');
        }

        // Validation
        $rules = [
            'customer_name' => 'required|string',
            'customer_email' => 'required|valid_email',
            'customer_phone' => 'required|numeric',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in_list[transfer,cod]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $product = $this->productModel->find($item['product_id']);
            if ($product) {
                $total += ($product['price'] * $item['quantity']);
            }
        }

        // Create order
        $orderData = [
            'order_number' => $this->orderModel->generateOrderNumber(),
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_email' => $this->request->getPost('customer_email'),
            'customer_phone' => $this->request->getPost('customer_phone'),
            'customer_address' => $this->request->getPost('customer_address'),
            'total_amount' => $total,
            'payment_method' => $this->request->getPost('payment_method'),
            'notes' => $this->request->getPost('notes'),
            'status' => 'pending',
        ];

        $orderId = $this->orderModel->insert($orderData);

        // Create order items
        foreach ($cart as $item) {
            $product = $this->productModel->find($item['product_id']);
            if ($product) {
                $this->orderItemModel->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product['price'],
                    'subtotal' => $product['price'] * $item['quantity'],
                ]);
            }
        }

        // Clear cart
        session()->remove('cart');

        return redirect()->to('/dashboard?order_id=' . $orderId)->with('message', 'Pesanan berhasil dibuat! Silahkan cek halaman dashboard untuk detail pesanan.');
    }

    public function updateCart()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        $cart = session('cart') ?? [];

        foreach ($cart as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] = max(1, $quantity);
                break;
            }
        }

        session()->set('cart', $cart);

        return $this->response->setJSON(['success' => true, 'message' => 'Keranjang diperbarui']);
    }
}

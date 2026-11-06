<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;
use App\Models\SettingModel;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class Checkout extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $productModel;
    protected $settingModel;

    // Menyiapkan model checkout dan konfigurasi Midtrans Sandbox.
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel = new ProductModel();
        $this->settingModel = new SettingModel();

        // Pindahkan Konfigurasi Global Midtrans ke Constructor agar selalu aktif
        Config::$serverKey    = 'SB-Mid-server-rFz70H.dXtPeJMAcLuvR-OOL'; // Ganti dengan SERVER KEY Sandbox Anda asli
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    // Menampilkan isi keranjang dan total belanja untuk checkout.
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

    // Mengarahkan pengguna setelah alur pembayaran selesai.
    public function success()
    {
        return redirect()->to('/');
    }

    // Memverifikasi status pembayaran ke Midtrans lalu mengosongkan keranjang.
    public function confirmPayment()
    {
        $orderId = (int) $this->request->getPost('order_id');
        $authorizedOrderIds = array_map('intval', session('authorized_order_ids') ?? []);
        $order = $orderId > 0 ? $this->orderModel->find($orderId) : null;

        if (!$order || $order['payment_method'] !== 'transfer' || !in_array($orderId, $authorizedOrderIds, true)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan.',
            ]);
        }

        try {
            $transaction = Transaction::status($order['order_number']);
            $transactionStatus = $transaction->transaction_status ?? '';
            $isPaid = $transactionStatus === 'settlement'
                || ($transactionStatus === 'capture' && ($transaction->fraud_status ?? '') === 'accept');

            if (!$isPaid) {
                return $this->response->setJSON([
                    'status' => 'pending',
                    'message' => 'Pembayaran belum terkonfirmasi. Keranjang Anda belum dikosongkan.',
                ]);
            }

            if ($order['status'] !== 'confirmed' && !$this->orderModel->update($orderId, ['status' => 'confirmed'])) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 'error',
                    'message' => 'Pembayaran terverifikasi, tetapi pesanan gagal diperbarui.',
                ]);
            }

            session()->remove('cart');

            return $this->response->setJSON([
                'status' => 'success',
                'redirect_url' => site_url('dashboard?order_id=' . $orderId),
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Gagal memverifikasi pembayaran Midtrans untuk order {orderId}: {message}', [
                'orderId' => $orderId,
                'message' => $e->getMessage(),
            ]);

            return $this->response->setStatusCode(502)->setJSON([
                'status' => 'error',
                'message' => 'Pembayaran belum dapat diverifikasi. Silakan coba lagi.',
            ]);
        }
    }

    // Menambahkan produk ke keranjang sesi atau menambah jumlah produk yang sudah ada.
    public function addToCart()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?? 1;
        $product = $this->productModel->find($productId);
        if (!$product) { return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan']); }
        $cart = session('cart') ?? [];
        $found = false;
        foreach ($cart as &$item) { if ($item['product_id'] == $productId) { $item['quantity'] += $quantity; $found = true; break; } }
        if (!$found) { $cart[] = ['product_id' => $productId, 'quantity' => $quantity]; }
        session()->set('cart', $cart);
        return $this->response->setJSON(['success' => true, 'message' => 'Produk ditambahkan ke keranjang', 'cartCount' => count($cart)]);
    }

    // Menghapus produk tertentu dari keranjang sesi.
    public function removeFromCart()
    {
        $productId = $this->request->getPost('product_id');
        $cart = session('cart') ?? [];
        $cart = array_filter($cart, function ($item) use ($productId) { return $item['product_id'] != $productId; });
        session()->set('cart', array_values($cart));
        return $this->response->setJSON(['success' => true, 'message' => 'Produk dihapus dari keranjang']);
    }

    // Memperbarui jumlah produk di keranjang sesi dengan minimal satu item.
    public function updateCart()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');
        $cart = session('cart') ?? [];
        foreach ($cart as &$item) { if ($item['product_id'] == $productId) { $item['quantity'] = max(1, $quantity); break; } }
        session()->set('cart', $cart);
        return $this->response->setJSON(['success' => true, 'message' => 'Keranjang diperbarui']);
    }

    // Membuat pesanan dan memulai alur COD atau pembayaran Midtrans.
    public function process()
    {
        $cart = session('cart') ?? [];
        if (empty($cart)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Keranjang kosong']);
            }
            return redirect()->to('/products')->with('message', 'Keranjang belanja Anda kosong');
        }

        // 1. Validasi Input Form
        $rules = [
            'customer_name'    => 'required|string',
            'customer_email'   => 'required|valid_email',
            'customer_phone'   => 'required|numeric',
            'customer_address' => 'required|string',
            'payment_method'   => 'required|in_list[transfer,cod]',
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Validasi gagal', 'errors' => $this->validator->getErrors()]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Hitung Total Pembelian & Susun Item Details untuk Midtrans
        $total = 0;
        $itemDetails = [];
        foreach ($cart as $item) {
            $product = $this->productModel->find($item['product_id']);
            if ($product) {
                $subtotal = $product['price'] * $item['quantity'];
                $total += $subtotal;
                
                $itemDetails[] = [
                    'id'       => $item['product_id'],
                    'price'    => (int) $product['price'],
                    'quantity' => (int) $item['quantity'],
                    'name'     => substr($product['name'], 0, 50), // Batasi 50 karakter sesuai aturan Midtrans
                ];
            }
        }

        $paymentMethod = $this->request->getPost('payment_method');
        $orderNumber   = $this->orderModel->generateOrderNumber();

        // 3. Siapkan Data untuk Disimpan ke Database Orders
        $orderData = [
            'order_number'     => $orderNumber,
            'customer_name'    => $this->request->getPost('customer_name'),
            'customer_email'   => $this->request->getPost('customer_email'),
            'customer_phone'   => $this->request->getPost('customer_phone'),
            'customer_address' => $this->request->getPost('customer_address'),
            'total_amount'     => $total,
            'payment_method'   => $paymentMethod,
            'notes'            => $this->request->getPost('notes'),
            'status'           => 'pending', // Default awal selalu pending
        ];

        $orderId = $this->orderModel->insert($orderData);

        // Otorisasi Sesi Akses Dashboard Pesanan
        $authorizedOrderIds = array_map('intval', session('authorized_order_ids') ?? []);
        $authorizedOrderIds[] = (int) $orderId;
        session()->set('authorized_order_ids', array_slice(array_values(array_unique($authorizedOrderIds)), -20));

        // 4. Masukkan Data ke Database Order Items
        foreach ($cart as $item) {
            $product = $this->productModel->find($item['product_id']);
            if ($product) {
                $this->orderItemModel->insert([
                    'order_id'   => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $product['price'],
                    'subtotal'   => $product['price'] * $item['quantity'],
                ]);
            }
        }

        // ==========================================
        // SKENARIO A: JIKA USER MEMILIH METODE COD
        // ==========================================
        if ($paymentMethod === 'cod') {
            // Kosongkan keranjang belanja
            session()->remove('cart');
            
            // Redirect langsung menggunakan rute bawaan Anda
            return redirect()->to('/dashboard?order_id=' . $orderId)->with('message', 'Pesanan COD berhasil dibuat!');
        }

        // ==========================================
        // SKENARIO B: JIKA USER MEMILIH TRANSFER (MIDTRANS)
        // ==========================================
        $params = [
            'transaction_details' => [
                'order_id'     => $orderNumber, // Gunakan Order Number unik buatan sistem Anda
                'gross_amount' => (int) $total,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $this->request->getPost('customer_name'),
                'email'      => $this->request->getPost('customer_email'),
                'phone'      => $this->request->getPost('customer_phone'),
            ],
        ];

        try {
            // Ambil Token Snap secara aman dari vendor SDK Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Karena pemicunya via JavaScript Fetch, kita kembalikan respons JSON
            return $this->response->setJSON([
                'status'     => 'success',
                'snap_token' => $snapToken,
                'order_id'   => $orderId
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal terhubung ke Midtrans: ' . $e->getMessage()
            ]);
        }
    }
}
// HAPUS SEMUA BARIS KODE BAWAAN CONTOH MIDTRANS DI BAWAH INI S/D SELESAI

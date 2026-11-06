<?php echo $this->include('frontend/layout/header_katalog'); ?>
<?php echo $this->include('frontend/_defaults'); ?>

<?php $total = $total ?? 0; ?>

<!-- Main Content -->
<main>
    <!-- Page Title -->
    <section class="page-title">
        <div class="container">
            <h1><i class="fas fa-shopping-cart"></i> Checkout</h1>
            <p class="mt-2">Selesaikan pembelian Anda</p>
        </div>
    </section>

    <!-- Checkout Section -->
    <section class="container my-5">
        <?php if (empty($cart)): ?>
            <div class="alert alert-info text-center" role="alert">
                <i class="fas fa-info-circle"></i> Keranjang belanja Anda kosong.
                <a href="/products" class="alert-link">Kembali ke katalog produk</a>
            </div>
        <?php else: ?>
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8 mb-4">
                    <div class="card card-elevated">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="table-row-light">
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cart as $item): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= $item['product_name'] ?></strong>
                                                </td>
                                                <td>Rp <?= number_format($item['product_price'], 0, ',', '.') ?></td>
                                                <td>
                                                    <div class="input-group quantity-control--compact">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="decreaseQty(<?= $item['product_id'] ?>)">-</button>
                                                        <input type="number" value="<?= $item['quantity'] ?>" min="1" class="form-control text-center form-control--small-text" onchange="updateQuantity(<?= $item['product_id'] ?>, this.value)">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="increaseQty(<?= $item['product_id'] ?>)">+</button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></strong>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeFromCart(<?= $item['product_id'] ?>)">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Form -->
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card mb-4 card-elevated">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0"><i class="fas fa-receipt"></i> Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkir:</span>
                                <span>Rp 0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong class="order-total">Rp <?= number_format($total, 0, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <div class="card card-elevated">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0"><i class="fas fa-user"></i> Data Pemesan</h5>
                        </div>
                        <div class="card-body">
                            <form id="checkout-form" action="<?= site_url('checkout/process') ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" id="name" name="customer_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="customer_email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon *</label>
                                    <input type="tel" class="form-control" id="phone" name="customer_phone" required>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat Pengiriman *</label>
                                    <textarea class="form-control" id="address" name="customer_address" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="payment" class="form-label">Metode Pembayaran *</label>
                                    <select class="form-select" id="payment" name="payment_method" required>
                                        <option value="">Pilih Metode Pembayaran</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="cod">Bayar di Tempat (COD)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan (Opsional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Catatan tambahan untuk pesanan Anda"></textarea>
                                </div>

                                <button type="button"  id="btn-prosess" class="btn btn-add-cart w-100 btn-lg">
                                    <i class="fas fa-check-circle"></i> Checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>

<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-ygj8z-MEbfC3qftL1EFbAhrS"></script>
<script>
    // --- SCRIPT ATAS (Fungsi Pengatur Keranjang Belanja Anda) ---
    // Mengurangi jumlah item dan menyimpan perubahan ke keranjang server.
    function decreaseQty(productId) {
        let input = event.target.parentElement.querySelector('input');
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
            updateQuantity(productId, input.value);
        }
    }

    // Menambah jumlah item lalu menyinkronkannya dengan keranjang server.
    function increaseQty(productId) {
        let input = event.target.parentElement.querySelector('input');
        input.value = parseInt(input.value) + 1;
        updateQuantity(productId, input.value);
    }

    // Mengirim jumlah item terbaru ke endpoint keranjang.
    function updateQuantity(productId, quantity) {
        fetch('<?= site_url('checkout/update-cart') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'product_id=' + encodeURIComponent(productId) + '&quantity=' + encodeURIComponent(quantity) + '&' + encodeURIComponent(window.csrfName) + '=' + encodeURIComponent(window.csrfHash)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    // --- SCRIPT BAWAH (Logika Pengirim Checkout COD / Transfer) ---
    // Menangani checkout setelah tombol siap dan memvalidasi formulir sebelum mengirimnya.
    window.addEventListener('DOMContentLoaded', (event) => {
        const payButton = document.getElementById('btn-prosess');

        if (payButton) {
            payButton.addEventListener('click', function(e) {
                const form = document.getElementById('checkout-form');
                const paymentMethod = document.getElementById('payment').value;

                // Validasi HTML5 bawaan browser (memastikan data nama, email, alamat terisi)
                if (!form.reportValidity()) {
                    return;
                }

                if (paymentMethod === 'cod') {
                    // Jika COD, langsung kirim form biasa secara normal ke controller
                    form.submit();
                } else if (paymentMethod === 'transfer') {
                    const formData = new FormData(form);

                    // Diubah ke URL controller pemroses utama kita
                    fetch('<?= site_url('checkout/process') ?>', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Munculkan pop-up Midtrans Snap
                            snap.pay(data.snap_token, {
                                onSuccess: async function(result) {
                                    const confirmationData = new FormData();
                                    confirmationData.append('order_id', data.order_id);

                                    try {
                                        const response = await fetch('<?= site_url('checkout/confirm-payment') ?>', {
                                            method: 'POST',
                                            body: confirmationData,
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest'
                                            }
                                        });
                                        const confirmation = await response.json();

                                        if (!response.ok || confirmation.status !== 'success') {
                                            alert(confirmation.message || 'Pembayaran belum dapat dikonfirmasi.');
                                            return;
                                        }

                                        window.location.href = confirmation.redirect_url;
                                    } catch (error) {
                                        console.error('Error:', error);
                                        alert('Pembayaran berhasil, tetapi konfirmasi ke server gagal. Silakan coba lagi.');
                                    }
                                },
                                onPending: function(result) {
                                    window.location.href = '<?= site_url("checkout/pending?order_id=") ?>' + data.order_id;
                                },
                                onError: function(result) {
                                    alert("Pembayaran gagal!");
                                },
                                onClose: function() {
                                    alert('Anda menutup pop-up sebelum menyelesaikan pembayaran.');
                                }
                            });
                        } else {
                            alert('Gagal mengambil token pembayaran: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan sistem saat meminta token.');
                    });
                }
            });
        }
    });
</script>

<?php echo $this->include('frontend/layout/footer_katalog'); ?>

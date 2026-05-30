<?php echo $this->include('frontend/layout/header'); ?>
<?php echo $this->include('frontend/_defaults'); ?>

<!-- Main Content -->
<main>
    <!-- Page Title -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 40px 0;">
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
                    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="card-header" style="background-color: var(--primary-color); color: white;">
                            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="background-color: var(--light-bg);">
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
                                                    <div class="input-group" style="max-width: 100px;">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="decreaseQty(<?= $item['product_id'] ?>)">-</button>
                                                        <input type="number" value="<?= $item['quantity'] ?>" min="1" class="form-control text-center" style="font-size: 14px;" onchange="updateQuantity(<?= $item['product_id'] ?>, this.value)">
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
                    <div class="card mb-4" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="card-header" style="background-color: var(--primary-color); color: white;">
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
                                <strong style="font-size: 20px; color: var(--primary-color);">Rp <?= number_format($total, 0, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="card-header" style="background-color: var(--primary-color); color: white;">
                            <h5 class="mb-0"><i class="fas fa-user"></i> Data Pemesan</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('checkout/process') ?>" method="POST">
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
                                        <option value="transfer">Transfer Bank</option>
                                        <option value="cod">Bayar di Tempat (COD)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan (Opsional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Catatan tambahan untuk pesanan Anda"></textarea>
                                </div>

                                <button type="submit" class="btn btn-add-cart w-100 btn-lg">
                                    <i class="fas fa-check-circle"></i> Proses Pesanan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>

<script>
    function decreaseQty(productId) {
        let input = event.target.parentElement.querySelector('input');
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
            updateQuantity(productId, input.value);
        }
    }

    function increaseQty(productId) {
        let input = event.target.parentElement.querySelector('input');
        input.value = parseInt(input.value) + 1;
        updateQuantity(productId, input.value);
    }

    function updateQuantity(productId, quantity) {
        fetch('<?= site_url('checkout/update-cart') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'product_id=' + productId + '&quantity=' + quantity
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>

<?php echo $this->include('frontend/layout/footer'); ?>

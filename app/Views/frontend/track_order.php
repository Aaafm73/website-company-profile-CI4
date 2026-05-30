<?php echo $this->include('frontend/layout/header'); ?>

<!-- Main Content -->
<main>
    <!-- Page Title -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 40px 0;">
        <div class="container">
            <h1><i class="fas fa-search"></i> Hasil Pelacakan Pesanan</h1>
        </div>
    </section>

    <!-- Track Result -->
    <section class="container my-5">
        <?php if (!isset($order)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle"></i> Pesanan tidak ditemukan. Silahkan periksa kembali email dan nomor pesanan Anda.
            </div>
        <?php else: ?>
            <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-box"></i> Pesanan #<?= $order['order_number'] ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Nama Pemesan:</strong> <?= $order['customer_name'] ?></p>
                            <p><strong>Email:</strong> <?= $order['customer_email'] ?></p>
                            <p><strong>Telepon:</strong> <?= $order['customer_phone'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Alamat Pengiriman:</strong> <?= nl2br($order['customer_address']) ?></p>
                            <p><strong>Metode Pembayaran:</strong> <?= ucfirst($order['payment_method']) ?></p>
                            <p><strong>Tanggal Pesanan:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                    </div>

                    <hr>

                    <!-- Status Timeline -->
                    <h6 class="mb-3"><i class="fas fa-tasks"></i> Status Pesanan</h6>
                    <div class="row">
                        <div class="col-12">
                            <?php
                            $statusList = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                            $statusLabel = [
                                'pending' => 'Menunggu Konfirmasi',
                                'confirmed' => 'Dikonfirmasi',
                                'processing' => 'Sedang Diproses',
                                'shipped' => 'Telah Dikirim',
                                'delivered' => 'Sampai Tujuan',
                                'cancelled' => 'Dibatalkan'
                            ];
                            $currentStatusIndex = array_search($order['status'], $statusList);
                            ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <?php foreach ($statusList as $idx => $status): ?>
                                    <div class="text-center flex-grow-1">
                                        <div style="<?= $idx <= $currentStatusIndex ? 'background-color: var(--primary-color);' : 'background-color: #ccc;' ?> color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; margin-bottom: 10px; font-weight: bold;">
                                            <?php if ($idx < $currentStatusIndex): ?>
                                                <i class="fas fa-check"></i>
                                            <?php elseif ($idx == $currentStatusIndex): ?>
                                                <i class="fas fa-circle-notch" style="animation: spin 1s linear infinite;"></i>
                                            <?php else: ?>
                                                <?= $idx + 1 ?>
                                            <?php endif; ?>
                                        </div>
                                        <small><?= str_replace(' ', '<br>', $statusLabel[$status]) ?></small>
                                    </div>
                                    <?php if ($idx < count($statusList) - 1): ?>
                                        <div style="flex-grow: 1; height: 3px; background-color: <?= $idx < $currentStatusIndex ? 'var(--primary-color)' : '#ccc' ?>; margin-bottom: 25px;"></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Order Items -->
                    <h6 class="mb-3"><i class="fas fa-list"></i> Detail Produk</h6>
                    <div class="table-responsive mb-3">
                        <table class="table table-sm">
                            <thead style="background-color: var(--light-bg);">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td><?= $item['product_name'] ?></td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr style="background-color: var(--light-bg);">
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($order['notes']): ?>
                        <div class="alert alert-info">
                            <strong>Catatan Pesanan:</strong><br>
                            <?= $order['notes'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="/dashboard/contact" class="btn btn-primary">
                <i class="fas fa-envelope"></i> Hubungi Kami
            </a>
            <a href="/products" class="btn btn-outline-primary">
                <i class="fas fa-shopping-bag"></i> Lanjut Belanja
            </a>
        </div>
    </section>
</main>

<style>
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>

<?php echo $this->include('frontend/layout/footer'); ?>

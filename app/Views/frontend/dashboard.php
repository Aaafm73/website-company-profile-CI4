<?php echo $this->include('frontend/layout/header'); ?>
<?php echo $this->include('frontend/_defaults'); ?>

<!-- Main Content -->
<main>
    <!-- Page Title -->
    <section class="page-title">
        <div class="container">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard Pelanggan</h1>
            <p class="mt-2">Kelola pesanan dan lacak pengiriman Anda</p>
        </div>
    </section>

    <!-- Dashboard Section -->
    <section class="container my-5">
        <div class="mb-4">
            <form method="POST" action="<?= site_url('dashboard/track-order') ?>" class="row g-2">
                <?= csrf_field() ?>
                <div class="col-md-5">
                    <input type="text" name="order_number" class="form-control" placeholder="Masukkan Nomor Pesanan (contoh: ORD-20240101-0001)" value="<?= esc(service('request')->getPost('order_number') ?? '') ?>" required>
                </div>
                <div class="col-md-5">
                    <input type="email" name="email" class="form-control" placeholder="Email saat pemesanan" required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>
        </div>

        <div class="card card-elevated">
            <div class="card-header card-header-primary">
                <h5 class="mb-0"><i class="fas fa-search"></i> Lacak Pesanan</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">Masukkan nomor pesanan dan email yang digunakan saat memesan untuk melihat status terbaru.</p>

                <?php if (isset($selectedOrder) && $selectedOrder): ?>
                    <?php
                        $statusColor = [
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'processing' => 'primary',
                            'shipped' => 'success',
                            'delivered' => 'success',
                            'cancelled' => 'danger'
                        ];
                        $statusLabel = [
                            'pending' => 'Menunggu Konfirmasi',
                            'confirmed' => 'Dikonfirmasi',
                            'processing' => 'Sedang Diproses',
                            'shipped' => 'Telah Dikirim',
                            'delivered' => 'Sampai Tujuan',
                            'cancelled' => 'Dibatalkan'
                        ];
                        $currentStatusIndex = array_search($selectedOrder['status'], array_keys($statusLabel));
                        $statusSteps = array_keys($statusLabel);
                    ?>
                    <div class="mb-3">
                        <h6>Hasil Pelacakan — Pesanan #<?= esc($selectedOrder['order_number']) ?></h6>
                        <p><strong>Status Saat Ini:</strong> <span class="badge bg-<?= $statusColor[$selectedOrder['status']] ?>"><?= $statusLabel[$selectedOrder['status']] ?></span></p>
                        <p><strong>Total:</strong> Rp <?= number_format($selectedOrder['total_amount'], 0, ',', '.') ?></p>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyOrderId('<?= $selectedOrder['order_number'] ?>')"><i class="fas fa-copy"></i> Salin ID</button>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center dashboard-progress-row">
                            <?php foreach ($statusSteps as $idx => $step): ?>
                                <div class="text-center flex-fill dashboard-progress-step">
                                    <div class="dashboard-progress-circle <?= $idx <= $currentStatusIndex ? 'is-complete' : '' ?>">
                                        <?= $idx + 1 ?>
                                    </div>
                                    <div class="dashboard-progress-label"><?= $statusLabel[$step] ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-head-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($selectedOrder['items'] as $item): ?>
                                    <tr>
                                        <td><?= esc($item['product_name']) ?></td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <td><?= esc($item['quantity']) ?></td>
                                        <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php elseif (service('request')->getGet('order_id')): ?>
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-circle"></i> Pesanan dengan nomor tersebut tidak ditemukan.
                    </div>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> Gunakan kotak pencarian di atas untuk melacak pesanan Anda.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<script>
    function copyOrderId(orderNumber) {
        navigator.clipboard.writeText(orderNumber).then(function() {
            // Use the global toast helper defined in footer.php
            if (typeof showToast === 'function') {
                showToast('success', 'ID pesanan disalin');
            } else {
                // Fallback
                alert('ID pesanan disalin: ' + orderNumber);
            }
        }).catch(function() {
            if (typeof showToast === 'function') {
                showToast('error', 'Gagal menyalin ID pesanan');
            } else {
                alert('Gagal menyalin ID pesanan. Silakan salin secara manual.');
            }
        });
    }
</script>

<?php echo $this->include('frontend/layout/footer'); ?>

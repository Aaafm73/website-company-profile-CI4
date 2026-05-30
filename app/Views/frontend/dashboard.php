<?php echo $this->include('frontend/layout/header'); ?>
<?php echo $this->include('frontend/_defaults'); ?>

<!-- Main Content -->
<main>
    <!-- Page Title -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 40px 0;">
        <div class="container">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard Pelanggan</h1>
            <p class="mt-2">Kelola pesanan dan lacak pengiriman Anda</p>
        </div>
    </section>

    <!-- Dashboard Section -->
    <section class="container my-5">
        <div class="mb-4">
            <form method="GET" action="<?= site_url('dashboard') ?>" class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="order_number" class="form-control" placeholder="Masukkan Nomor Pesanan (contoh: ORD-20240101-0001)" value="<?= esc(service('request')->getGet('order_number')) ?>">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100"><i class="fas fa-search"></i> Cari dengan ID</button>
                </div>
            </form>
        </div>

        <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div class="card-header" style="background-color: var(--primary-color); color: white;">
                <h5 class="mb-0"><i class="fas fa-search"></i> Lacak Pesanan</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">Masukkan nomor pesanan pada pencarian di atas untuk melihat status terbaru yang diupdate oleh admin.</p>

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
                        <div class="d-flex justify-content-between align-items-center" style="gap: 8px; flex-wrap: wrap;">
                            <?php foreach ($statusSteps as $idx => $step): ?>
                                <div class="text-center flex-fill" style="min-width: 100px;">
                                    <div style="background-color: <?= $idx <= $currentStatusIndex ? 'var(--primary-color)' : '#ccc' ?>; color: white; width: 42px; height: 42px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 8px; font-weight: bold;">
                                        <?= $idx + 1 ?>
                                    </div>
                                    <div style="font-size: 13px;"><?= $statusLabel[$step] ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="table-responsive">
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
                <?php elseif (service('request')->getGet('order_number')): ?>
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

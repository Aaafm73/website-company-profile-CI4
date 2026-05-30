<?php echo $this->include('admin/layout/header'); ?>
<?php echo $this->include('admin/_defaults'); ?>

<!-- Dashboard Content -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="number"><?= $totalOrders ?? 0 ?></div>
            <div class="label">Total Pesanan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="number" style="color: #ffc107;"><?= $pendingOrders ?? 0 ?></div>
            <div class="label">Pesanan Menunggu</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="number" style="color: #dc3545;"><?= $newContacts ?? 0 ?></div>
            <div class="label">Kontak Baru</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="number"><?= $totalProducts ?? 0 ?></div>
            <div class="label">Total Produk</div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-recent"></i> Pesanan Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead style="background-color: var(--light-bg);">
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders ?? [] as $order): ?>
                                <tr>
                                    <td><strong><?= $order['order_number'] ?></strong></td>
                                    <td><?= $order['customer_name'] ?></td>
                                    <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php
                                        $statusBadge = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'processing' => 'primary',
                                            'shipped' => 'success',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        ?>
                                        <span class="badge bg-<?= $statusBadge[$order['status']] ?>">
                                            <?= ucfirst($order['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/admin/orders/detail/<?= $order['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a href="/admin/orders" class="btn btn-primary mt-2">
                    <i class="fas fa-arrow-right"></i> Lihat Semua Pesanan
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Contacts -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-envelope"></i> Kontak Baru</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recentContacts)): ?>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <?php foreach ($recentContacts as $contact): ?>
                            <div class="mb-3 pb-3 border-bottom">
                                <h6 class="mb-1">
                                    <strong><?= $contact['name'] ?></strong>
                                </h6>
                                <p class="mb-1" style="font-size: 14px; color: #666;">
                                    <i class="fas fa-envelope"></i> <?= $contact['email'] ?>
                                </p>
                                <p class="mb-2" style="font-size: 13px;">
                                    <?= substr($contact['message'], 0, 60) ?>...
                                </p>
                                <small class="text-muted">
                                    <?= date('d M Y, H:i', strtotime($contact['created_at'])) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="/admin/contacts" class="btn btn-primary btn-sm w-100 mt-3">
                        <i class="fas fa-arrow-right"></i> Lihat Semua Kontak
                    </a>
                <?php else: ?>
                    <p class="text-center text-muted">Tidak ada kontak baru</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-lightning-bolt"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <a href="/admin/products/create" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>
                <a href="/admin/orders" class="btn btn-outline-primary me-2">
                    <i class="fas fa-box"></i> Kelola Pesanan
                </a>
                <a href="/admin/contacts" class="btn btn-outline-primary me-2">
                    <i class="fas fa-envelope"></i> Kelola Kontak
                </a>
                <a href="/admin/settings" class="btn btn-outline-primary">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('admin/layout/footer'); ?>

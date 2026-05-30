<?php echo $this->include('admin/layout/header'); ?>
<?php echo $this->include('admin/_defaults'); ?>

<!-- Orders List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-box"></i> Daftar Pesanan</h5>
        <div>
            <!-- Status filter buttons are populated from shared admin view defaults. -->
            <?php foreach ($statuses as $status): ?>
                <a href="/admin/orders?status=<?= $status ?>" class="btn btn-sm btn-outline-primary">
                    <?= ucfirst($status) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead style="background-color: var(--light-bg);">
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong><?= $order['order_number'] ?></strong></td>
                            <td><?= $order['customer_name'] ?></td>
                            <td><?= $order['customer_email'] ?></td>
                            <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                            <td>
                                <?php
                                $statusColor = [
                                    'pending' => 'warning',
                                    'confirmed' => 'info',
                                    'processing' => 'primary',
                                    'shipped' => 'success',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger'
                                ];
                                ?>
                                <span class="badge bg-<?= $statusColor[$order['status']] ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                            <td>
                                <a href="/admin/orders/detail/<?= $order['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- Use SweetAlert2 confirmation, then submit POST with CSRF token -->
                                <form action="/admin/orders/delete/<?= $order['id'] ?>" method="POST" style="display:inline-block; margin:0;" onsubmit="event.preventDefault(); deleteConfirm(this.action, 'pesanan <?= $order['order_number'] ?>');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <?= $pager ? $pager->links() : '' ?>
        </nav>
    </div>
</div>

<?php echo $this->include('admin/layout/footer'); ?>

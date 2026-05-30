<?php echo $this->include('admin/layout/header'); ?>
<?php echo $this->include('admin/_defaults'); ?>

<!-- Order Detail -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-box"></i> Pesanan #<?= $order['order_number'] ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Nama Pelanggan:</strong> <?= $order['customer_name'] ?></p>
                        <p><strong>Email:</strong> <?= $order['customer_email'] ?></p>
                        <p><strong>Telepon:</strong> <?= $order['customer_phone'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Alamat:</strong> <?= nl2br($order['customer_address']) ?></p>
                        <p><strong>Metode Pembayaran:</strong> <?= ucfirst($order['payment_method']) ?></p>
                        <p><strong>Tanggal Pesanan:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                    </div>
                </div>

                <hr>

                <h6 class="mb-3"><i class="fas fa-list"></i> Detail Produk</h6>
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

                <hr>

                <h6 class="mb-3"><i class="fas fa-sticky-note"></i> Catatan</h6>
                <div class="alert alert-info">
                    <?= $order['notes'] ?? 'Tidak ada catatan' ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Status Update -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Update Status</h5>
            </div>
            <div class="card-body">
                <form onsubmit="return updateStatus();">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pesanan</label>
                        <select class="form-select" id="status" name="status" required>
                            <?php
                            $statusLabel = [
                                'pending' => 'Menunggu Konfirmasi',
                                'confirmed' => 'Dikonfirmasi',
                                'processing' => 'Sedang Diproses',
                                'shipped' => 'Telah Dikirim',
                                'delivered' => 'Sampai Tujuan',
                                'cancelled' => 'Dibatalkan'
                            ];
                            ?>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= $status ?>" <?= $order['status'] === $status ? 'selected' : '' ?>>
                                    <?= $statusLabel[$status] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-check"></i> Perbarui Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Notes Update -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Catatan</h5>
            </div>
            <div class="card-body">
                <form onsubmit="return updateNotes();">
                    <div class="mb-3">
                        <textarea class="form-control" id="notes" name="notes" rows="4"><?= $order['notes'] ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Simpan Catatan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<a href="<?= site_url('admin/orders') ?>" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<script>
    const updateStatusUrl = '<?= site_url('admin/orders/update-status/' . $order['id']) ?>';
    const updateNotesUrl = '<?= site_url('admin/orders/update-notes/' . $order['id']) ?>';

    /**
     * Submit the order status update via AJAX and handle the result.
     */
    function updateStatus() {
        let status = document.getElementById('status').value;
        
        fetch(updateStatusUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'status=' + encodeURIComponent(status) + '&' + encodeURIComponent(window.csrfName) + '=' + encodeURIComponent(window.csrfHash)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message || 'Status pesanan berhasil diperbarui');
                setTimeout(() => location.reload(), 900);
            } else {
                showModal('Gagal', data.message || 'Terjadi kesalahan saat memperbarui status pesanan.', 'error');
            }
        })
        .catch(() => showModal('Kesalahan', 'Tidak dapat menghubungi server. Silakan coba lagi.', 'error'));
    }

    /**
     * Submit the order notes update via AJAX and display the response.
     */
    function updateNotes() {
        let notes = document.getElementById('notes').value;
        
        fetch(updateNotesUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'notes=' + encodeURIComponent(notes) + '&' + encodeURIComponent(window.csrfName) + '=' + encodeURIComponent(window.csrfHash)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message || 'Catatan berhasil diperbarui');
            } else {
                showModal('Gagal', data.message || 'Terjadi kesalahan saat memperbarui catatan pesanan.', 'error');
            }
        })
        .catch(() => showModal('Kesalahan', 'Tidak dapat menghubungi server. Silakan coba lagi.', 'error'));
    }
</script>

<?php echo $this->include('admin/layout/footer'); ?>

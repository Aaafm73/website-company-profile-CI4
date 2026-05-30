<?php echo $this->include('admin/layout/header'); ?>
<?php echo $this->include('admin/_defaults'); ?>

<!-- Contact Detail -->
<?php if (empty($contact) || !is_array($contact)): ?>
    <div class="alert alert-warning">Kontak tidak tersedia. <a href="/admin/contacts">Kembali ke daftar kontak</a></div>
<?php else: ?>
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-envelope"></i> Kontak dari <?= $contact['name'] ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Nama:</strong> <?= $contact['name'] ?></p>
                        <p><strong>Email:</strong> <a href="mailto:<?= $contact['email'] ?>"><?= $contact['email'] ?></a></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Telepon:</strong> <?= $contact['phone'] ?? '-' ?></p>
                        <p><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></p>
                    </div>
                </div>

                <hr>

                <h6 class="mb-3"><strong>Subjek:</strong> <?= $contact['subject'] ?></h6>

                <div class="alert alert-light border">
                    <p><?= nl2br($contact['message']) ?></p>
                </div>

                <hr>

                <div class="d-grid gap-2">
                    <a href="mailto:<?= $contact['email'] ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-reply"></i> Balas Email
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Status Update -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Status</h5>
            </div>
            <div class="card-body">
                <form onsubmit="updateStatus(<?= $contact['id'] ?>); return false;">
                    <div class="mb-3">
                        <label for="status" class="form-label">Ubah Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <?php
                            $statusLabel = ['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas'];
                            if (!isset($statuses) || !is_array($statuses)) {
                                $statuses = array_keys($statusLabel);
                            }
                            ?>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= $status ?>" <?= $contact['status'] === $status ? 'selected' : '' ?>>
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
    </div>
</div>

<a href="/admin/contacts" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<script>
    /**
     * Submit the contact status update and show SweetAlert2 feedback.
     * @param {number|string} contactId
     */
    function updateStatus(contactId) {
        let status = document.getElementById('status').value;
        
        fetch('/admin/contacts/update-status/' + contactId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'status=' + encodeURIComponent(status) + '&' + encodeURIComponent(window.csrfName) + '=' + encodeURIComponent(window.csrfHash)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message || 'Status kontak berhasil diperbarui');
                setTimeout(() => location.reload(), 900);
            } else {
                showModal('Gagal', data.message || 'Tidak dapat memperbarui status', 'error');
            }
        })
        .catch(() => showModal('Kesalahan', 'Tidak dapat menghubungi server', 'error'));
    }
</script>
<?php endif; ?>

<?php echo $this->include('admin/layout/footer'); ?>

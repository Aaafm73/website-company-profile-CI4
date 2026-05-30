<?php echo $this->include('admin/layout/header'); ?>

<!-- Settings Form -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cog"></i> Pengaturan Perusahaan</h5>
            </div>
            <div class="card-body">
                <form action="/admin/settings/update" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Nama Perusahaan *</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" value="<?= $settings['company_name'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="company_tagline" class="form-label">Tagline Perusahaan *</label>
                        <input type="text" class="form-control" id="company_tagline" name="company_tagline" value="<?= $settings['company_tagline'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="company_description" class="form-label">Deskripsi Perusahaan *</label>
                        <textarea class="form-control" id="company_description" name="company_description" rows="5" required><?= $settings['company_description'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="company_phone" class="form-label">Nomor Telepon *</label>
                        <input type="tel" class="form-control" id="company_phone" name="company_phone" value="<?= $settings['company_phone'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="company_email" class="form-label">Email Perusahaan *</label>
                        <input type="email" class="form-control" id="company_email" name="company_email" value="<?= $settings['company_email'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="company_address" class="form-label">Alamat Perusahaan *</label>
                        <textarea class="form-control" id="company_address" name="company_address" rows="4" required><?= $settings['company_address'] ?? '' ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Penting</h5>
            </div>
            <div class="card-body">
                <p><strong>Tips Pengaturan:</strong></p>
                <ul style="font-size: 14px;">
                    <li>Pastikan informasi perusahaan selalu update</li>
                    <li>Gunakan nomor telepon yang aktif</li>
                    <li>Email harus dapat menerima notifikasi</li>
                    <li>Deskripsi akan ditampilkan di halaman depan</li>
                    <li>Alamat harus lengkap dan akurat</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-link"></i> Link Penting</h5>
            </div>
            <div class="card-body" style="font-size: 14px;">
                <p>
                    <a href="/" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-globe"></i> Lihat Website
                    </a>
                </p>
                <p>
                    <a href="/admin/dashboard" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-dashboard"></i> Dashboard
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('admin/layout/footer'); ?>

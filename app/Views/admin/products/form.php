<?php echo $this->include('admin/layout/header'); ?>
<?php echo $this->include('admin/_defaults'); ?>

<!-- Product Form -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-<?= isset($product) ? 'edit' : 'plus' ?>"></i>
                    <?= isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' ?>
                </h5>
            </div>
            <div class="card-body">
                <form action="<?= isset($product) ? '/admin/products/update/' . $product['id'] : '/admin/products/store' ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi *</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required><?= $product['description'] ?? '' ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga (Rp) *</label>
                            <input type="number" class="form-control" id="price" name="price" value="<?= $product['price'] ?? '' ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stok *</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?= $product['stock'] ?? 0 ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori *</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat ?>" <?= isset($product) && $product['category'] === $cat ? 'selected' : '' ?>>
                                    <?= $cat ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        <?php if (isset($product) && $product['image']): ?>
                            <div class="mb-2">
                                <img src="<?= base_url($product['image']) ?>" alt="<?= $product['name'] ?>" style="max-height: 150px; border-radius: 5px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG. Ukuran maksimal: 2MB</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> <?= isset($product) ? 'Perbarui' : 'Tambah' ?> Produk
                        </button>
                        <a href="/admin/products" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi</h5>
            </div>
            <div class="card-body">
                <h6>Panduan Pengisian:</h6>
                <ul style="font-size: 14px;">
                    <li>Nama produk harus unik dan deskriptif</li>
                    <li>Deskripsi harus menjelaskan manfaat produk</li>
                    <li>Harga dalam Rupiah tanpa tanda khusus</li>
                    <li>Masukkan stok yang tersedia saat ini</li>
                    <li>Pilih kategori yang sesuai dengan produk</li>
                    <li>Gambar baiknya beresolusi tinggi</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('admin/layout/footer'); ?>

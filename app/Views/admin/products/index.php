<?php echo $this->include('admin/layout/header'); ?>
<?php echo $this->include('admin/_defaults'); ?>

<!-- Products List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-store"></i> Daftar Produk</h5>
        <a href="/admin/products/create" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="mb-3">
            <form method="GET" class="d-flex gap-2">
                <select name="category" class="form-select" style="max-width: 200px;">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>" <?= $selected_category === $cat ? 'selected' : '' ?>>
                            <?= $cat ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Filter
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead style="background-color: var(--light-bg);">
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if ($product['image']): ?>
                                    <img src="<?= base_url($product['image']) ?>" alt="<?= $product['name'] ?>" style="max-height: 50px; max-width: 50px; border-radius: 5px;">
                                <?php else: ?>
                                    <i class="fas fa-image" style="color: #ccc;"></i>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= $product['name'] ?></strong></td>
                            <td><?= $product['category'] ?></td>
                            <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge bg-success"><?= $product['stock'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($product['created_at'])) ?></td>
                            <td>
                                <a href="/admin/products/edit/<?= $product['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Use SweetAlert2 confirmation, then submit POST with CSRF token -->
                                <form action="/admin/products/delete/<?= $product['id'] ?>" method="POST" style="display:inline-block; margin:0;" onsubmit="event.preventDefault(); deleteConfirm(this.action, '<?= esc($product['name']) ?>');">
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

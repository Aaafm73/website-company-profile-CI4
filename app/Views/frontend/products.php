<?php echo $this->include('frontend/layout/header'); ?>
<?php echo $this->include('frontend/_defaults'); ?>

<!-- Main Content -->
<main>
    <!-- Page Title -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 40px 0;">
        <div class="container">
            <h1><i class="fas fa-store"></i> Katalog Produk</h1>
            <p class="mt-2">Temukan produk vegetarian pilihan Anda</p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="container my-5">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-md-3 mb-4">
                <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-filter"></i> Filter Kategori
                        </h5>
                        <div class="list-group list-group-flush">
                            <a href="/products?category=semua" class="list-group-item list-group-item-action <?= ($selected_category == 'semua' || !$selected_category) ? 'active' : '' ?>" style="<?= ($selected_category == 'semua' || !$selected_category) ? 'background-color: var(--primary-color); color: white;' : '' ?>">
                                Semua Produk
                            </a>
                            <?php foreach ($categories as $cat): ?>
                                <a href="/products?category=<?= urlencode($cat) ?>" class="list-group-item list-group-item-action <?= ($selected_category == $cat) ? 'active' : '' ?>" style="<?= ($selected_category == $cat) ? 'background-color: var(--primary-color); color: white;' : '' ?>">
                                    <?= $cat ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-md-9">
                <div class="row">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-sm-6 col-lg-4 mb-4">
                                <div class="card product-card">
                                    <div class="card-img-top" style="background-color: var(--light-bg); display: flex; align-items: center; justify-content: center; position: relative;">
                                        <?php if ($product['image']): ?>
                                            <img src="<?= base_url($product['image']) ?>" alt="<?= $product['name'] ?>" class="img-fluid" style="max-height: 250px; object-fit: cover;">
                                        <?php else: ?>
                                            <i class="fas fa-image fa-4x" style="color: #ccc;"></i>
                                        <?php endif; ?>
                                        <span class="badge bg-info" style="position: absolute; top: 10px; right: 10px;">
                                            <?= $product['category'] ?>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $product['name'] ?></h5>
                                        <p class="card-text text-muted" style="height: 60px; overflow: hidden; font-size: 14px;">
                                            <?= substr($product['description'], 0, 80) ?>...
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="product-price">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                            <span class="product-stock" style="font-size: 12px;">
                                                <?php if ($product['stock'] > 0): ?>
                                                    <span class="badge bg-success">Tersedia</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Habis</span>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <a href="/products/detail/<?= $product['id'] ?>" class="btn btn-sm btn-outline-primary mb-2">
                                                <i class="fas fa-eye"></i> Lihat Detail
                                            </a>
                                            <button type="button" class="btn btn-sm btn-add-cart" onclick="addToCart(<?= $product['id'] ?>)" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center" role="alert">
                                <i class="fas fa-info-circle"></i> Tidak ada produk ditemukan dalam kategori ini.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo $this->include('frontend/layout/footer'); ?>

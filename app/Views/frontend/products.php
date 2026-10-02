<?php echo $this->include('frontend/layout/header'); ?>
<?php echo $this->include('frontend/_defaults'); ?>

<?php
$categories = $categories ?? [];
$products = $products ?? [];
$selected_category = $selected_category ?? '';
?>

<!-- Main Content -->
<main>
    <!-- Page Title -->
    <section class="page-title">
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
                <div class="card card-elevated">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-filter"></i> Filter Kategori
                        </h5>
                        <div class="list-group list-group-flush">
                            <a href="/products?category=semua" class="list-group-item list-group-item-action category-filter <?= ($selected_category == 'semua' || !$selected_category) ? 'active' : '' ?>">
                                Semua Produk
                            </a>
                            <?php foreach ($categories as $cat): ?>
                                <a href="/products?category=<?= $cat['id'] ?>" class="list-group-item list-group-item-action category-filter <?= ((string) $selected_category === (string) $cat['id']) ? 'active' : '' ?>">
                                    <?= esc($cat['name']) ?>
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
                                    <div class="card-img-top image-placeholder image-placeholder--relative">
                                        <?php if ($product['image']): ?>
                                            <img src="<?= base_url($product['image']) ?>" alt="<?= $product['name'] ?>" class="img-fluid product-image">
                                        <?php else: ?>
                                            <i class="fas fa-image fa-4x icon-placeholder"></i>
                                        <?php endif; ?>
                                        <span class="badge bg-info category-badge">
                                            <?= $product['category'] ?>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $product['name'] ?></h5>
                                        <p class="card-text text-muted product-description-clamp product-description-clamp--small">
                                            <?= substr($product['description'], 0, 80) ?>...
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="product-price">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                            <span class="product-stock product-stock--small">
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

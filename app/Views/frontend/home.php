<?php echo $this->include('frontend/layout/header'); ?>

<!-- Main Content -->
<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1><?= $company_tagline ?? 'Hidup Sehat Dimulai dari Pilihan Makanan yang Tepat' ?></h1>
            <p><?= $company_description ?? '' ?></p>
            <a href="/products" class="btn btn-light btn-lg">
                <i class="fas fa-shopping-bag"></i> Jelajahi Katalog
            </a>
        </div>
    </section>

    <!-- 4C Marketing Framework Section -->
    <section class="container">
        <h2 class="section-title">Mengapa Memilih <span class="highlight"><?= $company_name ?? 'Kami' ?></span></h2>
        
        <div class="row">
            <!-- Context -->
            <div class="col-md-6 mb-4">
                <div class="card product-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-globe fa-3x" style="color: var(--primary-color); margin-bottom: 20px;"></i>
                        <h5 class="card-title">Konteks Global, Lokal untuk Anda</h5>
                        <p class="card-text">
                            Kami memahami tren kesehatan global dan menghadirkannya dengan sentuhan lokal yang disesuaikan dengan kebutuhan Indonesia.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Challenge -->
            <div class="col-md-6 mb-4">
                <div class="card product-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-heartbeat fa-3x" style="color: var(--primary-color); margin-bottom: 20px;"></i>
                        <h5 class="card-title">Solusi Tantangan Kesehatan</h5>
                        <p class="card-text">
                            Tantangan kesehatan modern membutuhkan solusi inovatif. Kami menyediakan produk vegetarian berkualitas untuk gaya hidup sehat Anda.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Competency -->
            <div class="col-md-6 mb-4">
                <div class="card product-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-star fa-3x" style="color: var(--primary-color); margin-bottom: 20px;"></i>
                        <h5 class="card-title">Kompetensi & Pengalaman</h5>
                        <p class="card-text">
                            Dengan pengalaman bertahun-tahun dalam industri vegetarian, kami menjamin kualitas terbaik untuk setiap produk.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cause -->
            <div class="col-md-6 mb-4">
                <div class="card product-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-leaf fa-3x" style="color: var(--primary-color); margin-bottom: 20px;"></i>
                        <h5 class="card-title">Penyebab: Planet & Kesehatan</h5>
                        <p class="card-text">
                            Kami berkomitmen untuk planet yang lebih hijau dan masyarakat yang lebih sehat melalui pilihan makanan vegetarian.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section style="background-color: var(--light-bg);">
        <div class="container">
            <h2 class="section-title">Produk <span class="highlight">Pilihan</span></h2>
            
            <div class="row">
                <?php if (!empty($featured_products)): ?>
                    <?php foreach ($featured_products as $product): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card product-card">
                                <div class="card-img-top" style="background-color: var(--light-bg); display: flex; align-items: center; justify-content: center;">
                                    <?php if ($product['image']): ?>
                                        <img src="<?= base_url($product['image']) ?>" alt="<?= $product['name'] ?>" class="img-fluid" style="max-height: 250px; object-fit: cover;">
                                    <?php else: ?>
                                        <i class="fas fa-image fa-4x" style="color: #ccc;"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $product['name'] ?></h5>
                                    <p class="card-text text-muted" style="height: 60px; overflow: hidden;">
                                        <?= substr($product['description'], 0, 100) ?>...
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="product-price">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                        <span class="product-stock">
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
                                        <button type="button" class="btn btn-sm btn-add-cart" onclick="addToCart(<?= $product['id'] ?>)">
                                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="text-center">
                <a href="/products" class="btn btn-primary btn-lg">
                    <i class="fas fa-store"></i> Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h3 style="color: var(--primary-color); margin-bottom: 15px;">
                        <i class="fas fa-comments"></i> Pertanyaan Anda?
                    </h3>
                    <p>Tim kami siap membantu Anda 24/7 untuk menjawab semua pertanyaan tentang produk kami.</p>
                    <a href="/dashboard/contact" class="btn btn-primary">Hubungi Kami Sekarang</a>
                </div>
                <div class="col-md-6">
                    <h3 style="color: var(--primary-color); margin-bottom: 15px;">
                        <i class="fas fa-shipping-fast"></i> Pengiriman Cepat & Aman
                    </h3>
                    <p>Kami menggaransi produk sampai dalam kondisi terbaik dengan pengiriman ke seluruh Indonesia.</p>
                    <a href="/products" class="btn btn-primary">Mulai Belanja</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo $this->include('frontend/layout/footer'); ?>

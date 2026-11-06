<?php echo $this->include('frontend/layout/header'); ?>

<!-- Main Content -->
<main>
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <h1><?= $company_tagline ?? 'Hidup Sehat Dimulai dari Pilihan Makanan yang Tepat' ?></h1>
            <p><?= $company_description ?? '' ?></p>
            <a href="/products" class="btn btn-light btn-lg">
                <i class="fas fa-shopping-bag"></i> Jelajahi Katalog
            </a>
        </div>
    </section>

    <!-- 4C Marketing Framework Section -->
    <section id="about" class="container">
        <h2 class="section-title">Tentang <span class="highlight"><?= $company_name ?? 'Kami' ?></span></h2>

        <div class="row justify-content-center pb-5" >
            <img class="col-lg-6 about-img" src="<?=base_url('assets/vendor/img/about.jpeg')?>" alt="about">
            <div class="col-lg-6 about-text">
                <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus magnam, porro doloremque molestiae nobis aliquid hic? Illum, eligendi? Pariatur debitis minima numquam sit doloribus modi mollitia tenetur consectetur est ullam.</p>
                <p >Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat suscipit ducimus reiciendis amet mollitia maiores accusantium temporibus magni illum, sequi libero assumenda voluptate velit quaerat pariatur dolorem ex similique ipsum.</p>
                <p >Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime quia exercitationem velit perspiciatis sit possimus ullam et obcaecati earum quisquam, fugit quam minima quos iusto beatae explicabo dolorem. Fugit, earum.</p>
            </div>
        </div>
        <div class="row">
            <!-- Context -->
            <div class="col-md-6 mb-4">
                <div class="card product-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-globe fa-3x icon-primary icon-primary--large-gap"></i>
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
                        <i class="fas fa-heartbeat fa-3x icon-primary icon-primary--large-gap"></i>
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
                        <i class="fas fa-star fa-3x icon-primary icon-primary--large-gap"></i>
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
                        <i class="fas fa-leaf fa-3x icon-primary icon-primary--large-gap"></i>
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
    <section id="product" class="section-muted">
        <div class="container">
            <h2 class="section-title">Produk <span class="highlight">Pilihan</span></h2>
            
            <div class="row">
                <?php if (!empty($featured_products)): ?>
                    <?php foreach ($featured_products as $product): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card product-card">
                                <div class="card-img-top image-placeholder">
                                    <?php if ($product['image']): ?>
                                        <img src="<?= base_url($product['image']) ?>" alt="<?= $product['name'] ?>" class="img-fluid product-image">
                                    <?php else: ?>
                                        <i class="fas fa-image fa-4x icon-placeholder"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $product['name'] ?></h5>
                                    <p class="card-text text-muted product-description-clamp">
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

    <!-- Contact -->
    <section id="contact" class="container my-5">
        <h2 class="section-title">Kontak <span class="highlight"><?= $company_name ?? 'Kami' ?></span></h2>
        <div class="row contact-row">
            <!-- Contact Info -->
            <div class="col-lg-4 mb-4">
                <div class="contact-column">
                    <div class="card mb-4 contact-card">
                        <div class="card-body text-center">
                            <i class="fas fa-phone fa-3x icon-primary"></i>
                            <h5 class="card-title">Telepon</h5>
                                <p class="card-text"><?= isset($company_phone) && $company_phone ? esc($company_phone) : '+62 XXX XXXX' ?></p>
                        </div>
                    </div>

                    <div class="card mb-4 contact-card">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope fa-3x icon-primary"></i>
                            <h5 class="card-title">Email</h5>
                                <p class="card-text"><?= isset($company_email) && $company_email ? esc($company_email) : 'info@example.com' ?></p>
                        </div>
                    </div>

                    <div class="card contact-card">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-3x icon-primary"></i>
                            <h5 class="card-title">Alamat</h5>
                                <p class="card-text"><?php if (isset($company_address) && $company_address): ?>
                                    <?= nl2br(esc($company_address)) ?>
                                <?php else: ?>
                                    Alamat belum diset. Periksa pengaturan.
                                <?php endif; ?></p>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7579.182025528702!2d111.4827035!3d-2.2075051!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e0619fec490dc8b%3A0x9849289a9d35a5d4!2sPoliteknik%20Lamandau!5e1!3m2!1sen!2sid!4v1792472814872!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card card-elevated">
                    <div class="card-header card-header-primary">
                        <h5 class="mb-0"><i class="fas fa-pen-fancy"></i> Kirim Pesan</h5>
                    </div>
                    <div class="card-body">
                        <form action="/dashboard/send-contact" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon (Opsional)</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subjek *</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan *</label>
                                <textarea class="form-control" id="message" name="message" rows="6" required placeholder="Tuliskan pesan Anda di sini..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-add-cart btn-lg">
                                <i class="fas fa-paper-plane"></i> Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="alert alert-info mt-4" role="alert">
                    <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Kami akan merespon pesan Anda dalam waktu maksimal 24 jam pada hari kerja.
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h3 class="about-heading">
                        <i class="fas fa-comments"></i> Pertanyaan Anda?
                    </h3>
                    <p>Tim kami siap membantu Anda 24/7 untuk menjawab semua pertanyaan tentang produk kami.</p>
                    <a href="/dashboard/contact" class="btn btn-primary">Hubungi Kami Sekarang</a>
                </div>
                <div class="col-md-6">
                    <h3 class="about-heading">
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

<?php echo $this->include('frontend/layout/header'); ?>
<?php echo $this->include('frontend/_defaults'); ?>

<!-- Main Content -->
<main>
    <!-- Page Title -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 40px 0;">
        <div class="container">
            <h1><i class="fas fa-info-circle"></i> Tentang Kami</h1>
            <p class="mt-2">Kenali lebih jauh tentang <?= $company_name ?></p>
        </div>
    </section>

    <!-- Company Info -->
    <section class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <div style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border-radius: 10px; padding: 40px; color: white; text-align: center;">
                    <i class="fas fa-leaf fa-5x mb-3"></i>
                    <h3><?= $company_name ?></h3>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <h3 style="color: var(--primary-color); margin-bottom: 15px;">Visi & Misi Kami</h3>
                <p><?= $company_description ?></p>
                <h5 style="color: var(--primary-color); margin-top: 30px; margin-bottom: 15px;">Visi</h5>
                <p>Menjadi perusahaan vegetarian terdepan di Indonesia yang menyediakan produk berkualitas tinggi untuk mendukung gaya hidup sehat dan berkelanjutan.</p>
                
                <h5 style="color: var(--primary-color); margin-top: 20px; margin-bottom: 15px;">Misi</h5>
                <ul>
                    <li>Menyediakan produk vegetarian berkualitas premium</li>
                    <li>Mendukung perubahan gaya hidup menuju kesehatan yang lebih baik</li>
                    <li>Menjaga kelestarian lingkungan melalui pilihan produk organik</li>
                    <li>Memberikan layanan terbaik kepada pelanggan</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section style="background-color: var(--light-bg); padding: 60px 0;">
        <div class="container">
            <h2 class="section-title">Nilai-Nilai <span class="highlight">Kami</span></h2>
            
            <div class="row">
                <div class="col-md-3 mb-4 text-center">
                    <div class="card product-card h-100" style="border-radius: 10px;">
                        <div class="card-body">
                            <i class="fas fa-check-circle fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                            <h5>Kualitas</h5>
                            <p>Komitmen kami adalah memberikan produk terbaik dengan standar kualitas internasional.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4 text-center">
                    <div class="card product-card h-100" style="border-radius: 10px;">
                        <div class="card-body">
                            <i class="fas fa-handshake fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                            <h5>Kepercayaan</h5>
                            <p>Kami membangun hubungan jangka panjang dengan pelanggan melalui kejujuran dan transparansi.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4 text-center">
                    <div class="card product-card h-100" style="border-radius: 10px;">
                        <div class="card-body">
                            <i class="fas fa-globe fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                            <h5>Keberlanjutan</h5>
                            <p>Kami peduli terhadap lingkungan dan menggunakan bahan-bahan ramah lingkungan.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4 text-center">
                    <div class="card product-card h-100" style="border-radius: 10px;">
                        <div class="card-body">
                            <i class="fas fa-star fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                            <h5>Inovasi</h5>
                            <p>Kami terus berinovasi untuk menghadirkan produk-produk baru yang sesuai dengan kebutuhan pasar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info -->
    <section class="container my-5">
        <h2 class="section-title">Hubungi <span class="highlight">Kami</span></h2>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card product-card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-phone fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                        <h5>Telepon</h5>
                        <p><?= $company_phone ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card product-card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-envelope fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                        <h5>Email</h5>
                        <p><?= $company_email ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card product-card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-map-marker-alt fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                        <h5>Alamat</h5>
                        <p><?= $company_address ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 60px 0; text-align: center;">
        <div class="container">
            <h3 class="mb-4">Siap untuk Hidup Lebih Sehat?</h3>
            <p class="mb-4" style="font-size: 18px;">Jelajahi koleksi produk vegetarian kami dan mulai perjalanan menuju gaya hidup yang lebih sehat.</p>
            <a href="/products" class="btn btn-light btn-lg">
                <i class="fas fa-shopping-bag"></i> Lihat Katalog Lengkap
            </a>
        </div>
    </section>
</main>

<?php echo $this->include('frontend/layout/footer'); ?>

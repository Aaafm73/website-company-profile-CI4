<?php echo $this->include('frontend/layout/header'); ?>
<?php echo $this->include('frontend/_defaults'); ?>

<!-- Main Content -->
<main>
    <!-- Page Title -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 40px 0;">
        <div class="container">
            <h1><i class="fas fa-envelope"></i> Hubungi Kami</h1>
            <p class="mt-2">Kami siap membantu Anda</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="container my-5">
        <div class="row contact-row">
            <!-- Contact Info -->
            <div class="col-lg-4 mb-4">
                <div class="contact-column">
                    <div class="card mb-4 contact-card">
                        <div class="card-body text-center">
                            <i class="fas fa-phone fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                            <h5 class="card-title">Telepon</h5>
                                <p class="card-text"><?= isset($company_phone) && $company_phone ? esc($company_phone) : '+62 XXX XXXX' ?></p>
                        </div>
                    </div>

                    <div class="card mb-4 contact-card">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                            <h5 class="card-title">Email</h5>
                                <p class="card-text"><?= isset($company_email) && $company_email ? esc($company_email) : 'info@example.com' ?></p>
                        </div>
                    </div>

                    <div class="card contact-card">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-3x" style="color: var(--primary-color); margin-bottom: 15px;"></i>
                            <h5 class="card-title">Alamat</h5>
                                <p class="card-text"><?php if (isset($company_address) && $company_address): ?>
                                    <?= nl2br(esc($company_address)) ?>
                                <?php else: ?>
                                    Alamat belum diset. Periksa pengaturan.
                                <?php endif; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0"><i class="fas fa-pen-fancy"></i> Kirim Pesan</h5>
                    </div>
                    <div class="card-body">
                        <form action="/dashboard/send-contact" method="POST">
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

    <!-- FAQ Section -->
    <section style="background-color: var(--light-bg); padding: 60px 0;">
        <div class="container">
            <h2 class="section-title">Pertanyaan yang Sering <span class="highlight">Ditanyakan</span></h2>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h5 class="card-title" style="color: var(--primary-color);">
                                <i class="fas fa-question-circle"></i> Berapa lama pengiriman?
                            </h5>
                            <p class="card-text">Pengiriman biasanya memakan waktu 2-5 hari kerja tergantung lokasi Anda. Kami bekerja sama dengan jasa pengiriman terpercaya.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h5 class="card-title" style="color: var(--primary-color);">
                                <i class="fas fa-question-circle"></i> Apakah produk organik?
                            </h5>
                            <p class="card-text">Mayoritas produk kami adalah organik atau minimal menggunakan bahan-bahan berkualitas tinggi tanpa pengawet berbahaya.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h5 class="card-title" style="color: var(--primary-color);">
                                <i class="fas fa-question-circle"></i> Bagaimana dengan pengembalian barang?
                            </h5>
                            <p class="card-text">Jika ada kesalahan atau barang rusak, kami menerima pengembalian dalam 7 hari dengan syarat dan ketentuan berlaku.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h5 class="card-title" style="color: var(--primary-color);">
                                <i class="fas fa-question-circle"></i> Metode pembayaran apa saja?
                            </h5>
                            <p class="card-text">Kami menerima transfer bank dan bayar di tempat (COD). Proses verifikasi pembayaran biasanya 1-2 jam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo $this->include('frontend/layout/footer'); ?>

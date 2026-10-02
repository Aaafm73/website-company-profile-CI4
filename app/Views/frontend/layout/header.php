<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Vegetarian Paradise' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/frontend.css') ?>">
</head>
<body>
    <script>
        // CSRF tokens for frontend AJAX requests.
        // These are required by the SweetAlert2-based cart endpoints.
        window.csrfName = '<?= csrf_token() ?>';
        window.csrfHash = '<?= csrf_hash() ?>';
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!document.querySelector('.hero')) return;

            const header = document.querySelector('header');
            const updateHeader = function () {
                header.classList.toggle('is-scrolled', window.scrollY > 20);
            };

            updateHeader();
            window.addEventListener('scroll', updateHeader, { passive: true });
        });
    </script>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= site_url('/') ?>">
                    <i class="fas fa-leaf"></i> <?= $company_name ?? 'Vegetarian Paradise' ?>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/') ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('about') ?>">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('products') ?>">Katalog Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('dashboard') ?>">Dashboard Pelanggan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('dashboard/contact') ?>">Hubungi Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('checkout') ?>">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Alert Messages -->
    <div class="container">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-custom" role="alert">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-custom" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors)): ?>
            <div class="alert alert-danger alert-custom" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <!-- Main Content -->

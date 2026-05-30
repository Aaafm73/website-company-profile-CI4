<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Vegetarian Paradise' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --text-color: #333;
            --light-bg: #f5f5f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background-color: #fff;
        }

        /* Header & Navigation */
        header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white !important;
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            color: white !important;
        }

        .navbar-toggler {
            border-color: rgba(255,255,255,0.5);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        /* Card Styles */
        .product-card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .product-card .card-img-top {
            height: 250px;
            object-fit: cover;
            background-color: var(--light-bg);
        }

        .product-card .card-body {
            padding: 20px;
        }

        .product-price {
            font-size: 24px;
            color: var(--primary-color);
            font-weight: bold;
        }

        .product-stock {
            font-size: 14px;
            color: #666;
        }

        /* Button Styles */
        .btn-add-cart {
            background-color: var(--primary-color);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-add-cart:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        /* Section Styles */
        section {
            padding: 60px 0;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 50px;
            color: var(--text-color);
        }

        .section-title .highlight {
            color: var(--primary-color);
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0;
            margin-top: 80px;
        }

        /* Contact card tweaks */
        .contact-card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .contact-card .card-body {
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            word-break: break-word;
            overflow-wrap: anywhere;
            white-space: normal;
        }

        @media (max-width: 768px) {
            .contact-card .card-body {
                min-height: auto;
            }
        }
        /* Column wrapper for contact cards */
        .contact-column {
            display: grid;
            gap: 1.5rem;
            width: 100%;
            grid-auto-rows: minmax(0, auto);
        }

        /* Ensure contact cards do not overflow and columns align at the top */
        .contact-card {
            width: 100%;
        }

        /* Use a dedicated row helper for contact pages to avoid changing global row behavior */
        .contact-row {
            align-items: flex-start;
        }

        footer h5 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        footer a {
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        footer a:hover {
            color: var(--primary-color);
        }

        .footer-divider {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 30px;
            padding-top: 30px;
        }

        /* Alert Messages */
        .alert-custom {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 16px;
            }

            .section-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <script>
        // CSRF tokens for frontend AJAX requests.
        // These are required by the SweetAlert2-based cart endpoints.
        window.csrfName = '<?= csrf_token() ?>';
        window.csrfHash = '<?= csrf_hash() ?>';
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
                                <i class="fas fa-shopping-cart"></i> Keranjang
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Alert Messages -->
    <div class="container mt-3">
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

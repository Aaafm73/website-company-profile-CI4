<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin | Vegetarian Paradise' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/admin.css') ?>">
</head>
<body class="admin-layout">
    <script>
        // CSRF tokens for AJAX requests
        window.csrfName = '<?= csrf_token() ?>';
        window.csrfHash = '<?= csrf_hash() ?>';
    </script>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <h4><i class="fas fa-leaf"></i> Vegetarian Paradise</h4>
            <small>Admin Panel</small>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link" href="/admin/dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a class="nav-link" href="/admin/orders">
                <i class="fas fa-box"></i> Pesanan
            </a>
            <a class="nav-link" href="/admin/contacts">
                <i class="fas fa-envelope"></i> Kontak
            </a>
            <a class="nav-link" href="/admin/products">
                <i class="fas fa-store"></i> Produk
            </a>
            <a class="nav-link" href="/admin/settings">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
            <hr class="sidebar-divider">
            <form action="<?= site_url('admin/logout') ?>" method="POST" class="px-3">
                <?= csrf_field() ?>
                <button type="submit" class="nav-link btn btn-link text-start text-decoration-none p-0">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h2>Vegetarian Paradise</h2>
            <div class="user-info">
                <p class="mb-0">Selamat datang, <span class="username"><?= session('admin_user')['full_name'] ?? 'Admin' ?></span></p>
                <small class="text-muted"><?= date('d M Y, H:i') ?></small>
            </div>
        </div>

        <!-- Alert Messages -->
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

        <!-- Page Content -->

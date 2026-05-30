<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin | Vegetarian Paradise' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --text-color: #333;
            --light-bg: #f5f5f5;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background-color: var(--light-bg);
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .sidebar .brand {
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar .brand h4 {
            margin: 0;
            font-weight: bold;
        }

        .sidebar .nav {
            padding: 20px 0;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Top Bar */
        .topbar {
            background: white;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .topbar .user-info {
            text-align: right;
        }

        .topbar .user-info .username {
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 8px 8px 0 0;
            border: none;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        /* Stats */
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 20px;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stat-card .label {
            color: #666;
            margin-top: 10px;
        }

        /* Status Badges */
        .status-pending {
            background-color: #ffc107;
        }

        .status-confirmed {
            background-color: #17a2b8;
        }

        .status-processing {
            background-color: #007bff;
        }

        .status-shipped {
            background-color: #28a745;
        }

        .status-delivered {
            background-color: #20c997;
        }

        .status-cancelled {
            background-color: #dc3545;
        }

        /* Alert */
        .alert-custom {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
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
            <hr style="border-color: rgba(255,255,255,0.2); margin: 20px 0;">
            <a class="nav-link" href="/admin/logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
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

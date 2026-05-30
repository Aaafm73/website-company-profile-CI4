<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Login | Vegetarian Paradise' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            border: none;
            border-radius: 10px;
        }

        .login-card .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            text-align: center;
            padding: 30px 0;
            border-radius: 10px 10px 0 0;
        }

        .login-card .card-header h1 {
            font-size: 28px;
            margin: 0;
            font-weight: bold;
        }

        .login-card .card-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .login-card .card-body {
            padding: 40px;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 10px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .btn-login:hover {
            background: var(--secondary-color);
            color: white;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25);
        }

        .alert {
            border-radius: 8px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card login-card">
            <div class="card-header">
                <h1><i class="fas fa-leaf"></i> Vegetarian Paradise</h1>
                <p>Admin Panel</p>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('admin/login') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-login w-100 text-white">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>

                <hr>

                <!-- <p class="text-center text-muted" style="font-size: 14px;">
                    Demo Credentials:<br>
                    Username: <strong>admin</strong><br>
                    Password: <strong>admin123</strong>
                </p> -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

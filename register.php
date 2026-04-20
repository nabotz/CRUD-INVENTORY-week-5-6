<?php
session_start();
include 'koneksi.php';
include_once 'includes/csrf.php';

$error = '';
$success = '';

if (isset($_SESSION['register_error'])) {
    $error = $_SESSION['register_error'];
    unset($_SESSION['register_error']);
}
if (isset($_SESSION['register_success'])) {
    $success = $_SESSION['register_success'];
    unset($_SESSION['register_success']);
}

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 36px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        }
        .logo { text-align: center; font-size: 28px; margin-bottom: 6px; }
        h1 { text-align: center; font-size: 20px; font-weight: 600; color: #111; margin-bottom: 4px; }
        .subtitle { text-align: center; font-size: 13px; color: #888; margin-bottom: 28px; }
        .alert {
            padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 18px;
        }
        .alert-danger  { background: #fef2f2; color: #c0392b; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        label {
            display: block; font-size: 12px; font-weight: 600; color: #444;
            margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.4px;
        }
        input[type="text"],
        input[type="password"],
        input[type="file"] {
            width: 100%; padding: 10px 14px; border: 1px solid #ddd;
            border-radius: 8px; font-size: 14px; font-family: inherit;
            background: #fafafa; margin-bottom: 16px; transition: border-color .15s;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none; border-color: #555; background: #fff;
        }
        input[type="file"] { cursor: pointer; border-style: dashed; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .row .col label { margin-top: 0; }
        button[type="submit"] {
            width: 100%; padding: 12px; background: #111; color: #fff;
            border: none; border-radius: 8px; font-size: 14px; font-weight: 600;
            font-family: inherit; cursor: pointer; transition: background .15s; margin-top: 4px;
        }
        button[type="submit"]:hover { background: #333; }
        .link { text-align: center; margin-top: 20px; font-size: 13px; color: #888; }
        .link a { color: #111; font-weight: 600; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
        @media (max-width: 480px) { .row { grid-template-columns: 1fr; } .card { padding: 28px 20px; } }
    </style>
</head>
<body>
    <div class="card">
        <h1>Buat Akun</h1>
        <p class="subtitle">Sistem Inventori Toko Komputer</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="SimpanRegister.php" method="POST" enctype="multipart/form-data" id="formRegister">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

            <label>Foto Profil *</label>
            <input type="file" name="foto" accept="image/*" required>

            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Nama lengkap" minlength="3" required>

            <label>Username</label>
            <input type="text" name="username" placeholder="4–20 karakter (a-z, 0-9)" pattern="[a-zA-Z0-9]{4,20}" required>

            <div class="row">
                <div class="col">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Min. 6 karakter" minlength="6" required>
                </div>
                <div class="col">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Ulangi password" minlength="6" required>
                </div>
            </div>

            <button type="submit">Daftar</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="index.php">Masuk disini</a>
        </div>
    </div>

    <script>
        document.getElementById('formRegister').addEventListener('submit', function(e) {
            if (document.getElementById('password').value !== document.getElementById('confirm_password').value) {
                alert('Password dan Konfirmasi Password harus sama!');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
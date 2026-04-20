<?php
session_start();
include 'koneksi.php';
include_once 'includes/csrf.php';

// Cek jika sudah login
if (isset($_SESSION['username'])) {
    header("location:menu.php");
    exit;
}

// Proses login (harus sebelum output HTML)
$error = '';
if (isset($_POST['login'])) {
    csrf_check();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['foto'] = $user['foto'];

            // Remember Me: set cookie jika di-centang
            if (isset($_POST['remember'])) {
                $token = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $token);
                $stmt = $koneksi->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                $stmt->execute([$tokenHash, $user['id']]);
                $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
                setcookie("remember_token", $token, ['expires' => time() + (86400 * 30), 'path' => '/', 'httponly' => true, 'secure' => $isSecure, 'samesite' => 'Strict']);
                setcookie("remember_user", $user['id'], ['expires' => time() + (86400 * 30), 'path' => '/', 'httponly' => true, 'secure' => $isSecure, 'samesite' => 'Strict']);
            }

            header("location:menu.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Sistem Inventori</title>
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
        }
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 36px 40px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        }
        .logo {
            text-align: center;
            font-size: 28px;
            margin-bottom: 6px;
        }
        h1 {
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            color: #111;
            margin-bottom: 4px;
        }
        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #888;
            margin-bottom: 28px;
        }
        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
            background: #fef2f2;
            color: #c0392b;
            border: 1px solid #fecaca;
        }
        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #fafafa;
            margin-bottom: 16px;
            transition: border-color .15s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #555;
            background: #fff;
        }
        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #555;
            margin-bottom: 20px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background .15s;
        }
        button[type="submit"]:hover { background: #333; }
        .link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #888;
        }
        .link a { color: #111; font-weight: 600; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Masuk</h1>
        <p class="subtitle">Sistem Inventori Toko Komputer</p>

        <?php if ($error): ?>
            <div class="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required autofocus>
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
            <div class="remember">
                <input type="checkbox" name="remember" value="1" id="remember">
                <label for="remember" style="margin:0;text-transform:none;font-weight:500;">Ingat Saya</label>
            </div>
            <button type="submit" name="login">Masuk</button>
        </form>

        <div class="link">
            Belum punya akun? <a href="register.php">Daftar disini</a>
        </div>
    </div>
</body>
</html>
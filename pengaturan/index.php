<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'pengaturan';

$total_user = $koneksi->query("SELECT COUNT(*) FROM users")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pengaturan - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .settings-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:20px; }
        .settings-card { background:#fff; border:1px solid #e5e7eb; border-radius:14px; padding:24px; display:flex; flex-direction:column; gap:12px; }
        .settings-card-title { font-size:16px; font-weight:700; color:#0a0a0a; }
        .settings-card-desc { font-size:13px; color:#6b7280; line-height:1.5; }
        .settings-card-count { font-size:28px; font-weight:800; color:#0a0a0a; }
    </style>
</head>
<body>
<div class="dashboard">
    <?php include '../includes/sidebar.php'; ?>
    <main class="main">
        <header class="header">
            <h1 class="page-title">Pengaturan</h1>
        </header>
        <div class="content">
            <div class="settings-grid">
                <!-- User management -->
                <div class="settings-card">
                    <div class="settings-card-count"><?= $total_user ?></div>
                    <div class="settings-card-title">Manajemen User</div>
                    <div class="settings-card-desc">Kelola akun pengguna, tambah user baru, atau ubah data user yang ada.</div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px;">
                        <a href="../user/TampilUser.php" class="btn btn-primary btn-sm">Kelola User</a>
                        <a href="../user/TambahUser.php" class="btn btn-secondary btn-sm">+ Tambah User</a>
                    </div>
                </div>

                <!-- Profil -->
                <div class="settings-card">
                    <div style="font-size:32px;">&#128100;</div>
                    <div class="settings-card-title">Profil Saya</div>
                    <div class="settings-card-desc">Ubah nama, foto profil, atau password akun Anda sendiri.</div>
                    <div style="margin-top:4px;">
                        <a href="../user/KoreksiUser.php?id=<?= $_SESSION['user_id'] ?>" class="btn btn-secondary btn-sm">Edit Profil</a>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="settings-card">
                    <div style="font-size:32px;">&#128193;</div>
                    <div class="settings-card-title">Kategori &amp; Merk</div>
                    <div class="settings-card-desc">Kelola kategori dan merk produk yang tersedia di sistem.</div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px;">
                        <a href="../kategori/TampilKategori.php" class="btn btn-secondary btn-sm">Kategori</a>
                        <a href="../merk/TampilMerk.php" class="btn btn-secondary btn-sm">Merk</a>
                    </div>
                </div>

                <!-- Supplier -->
                <div class="settings-card">
                    <div style="font-size:32px;">&#128666;</div>
                    <div class="settings-card-title">Supplier</div>
                    <div class="settings-card-desc">Kelola data supplier yang memasok barang ke inventori.</div>
                    <div style="margin-top:4px;">
                        <a href="../supplier/TampilSupplier.php" class="btn btn-secondary btn-sm">Kelola Supplier</a>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top:24px;">
                <div class="card-header">
                    <h3 class="card-title">Informasi Sistem</h3>
                </div>
                <table class="table" style="max-width:480px;">
                    <tbody>
                        <tr><td style="font-weight:600;width:160px;">Nama Sistem</td><td>Sistem Manajemen Inventori</td></tr>
                        <tr><td style="font-weight:600;">Login Sebagai</td><td><?= htmlspecialchars($_SESSION['nama']) ?></td></tr>
                        <tr><td style="font-weight:600;">Username</td><td><?= htmlspecialchars($_SESSION['username'] ?? '-') ?></td></tr>
                        <tr><td style="font-weight:600;">Tanggal</td><td><?= date('d F Y') ?></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>

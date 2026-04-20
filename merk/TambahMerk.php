<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'kategori_merk';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Merk - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
<div class="dashboard">
    <?php include '../includes/sidebar.php'; ?>
    <main class="main">
        <header class="header">
            <div>
                <div class="breadcrumb"><a href="TampilMerk.php">Merk</a> <span>→</span> <span>Tambah Baru</span></div>
                <h1 class="page-title">Tambah Merk</h1>
            </div>
        </header>
        <div class="content">
            <div class="card" style="max-width:480px;">
                <form action="SimpanMerk.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="form-label">Nama Merk *</label>
                        <input type="text" name="nama_merk" class="form-control" required maxlength="100" placeholder="Contoh: Samsung, Panasonic">
                    </div>
                    <div style="display:flex;gap:12px;margin-top:8px;">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="TampilMerk.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>

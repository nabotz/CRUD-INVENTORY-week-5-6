<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'kategori_merk';

$id   = (int)($_GET['id'] ?? 0);
$stmt = $koneksi->prepare("SELECT * FROM merk WHERE id_merk = ?");
$stmt->execute([$id]);
$row  = $stmt->fetch();
if (!$row) { header('Location: TampilMerk.php'); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Merk - Sistem Inventori</title>
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
                <div class="breadcrumb"><a href="TampilMerk.php">Merk</a> <span>→</span> <span>Edit</span></div>
                <h1 class="page-title">Edit Merk</h1>
            </div>
        </header>
        <div class="content">
            <div class="card" style="max-width:480px;">
                <form action="SimpanKoreksiMerk.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="id" value="<?= $row['id_merk'] ?>">
                    <div class="form-group">
                        <label class="form-label">Nama Merk *</label>
                        <input type="text" name="nama_merk" class="form-control" required maxlength="100"
                            value="<?= htmlspecialchars($row['nama_merk']) ?>">
                    </div>
                    <div style="display:flex;gap:12px;margin-top:8px;">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="TampilMerk.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>

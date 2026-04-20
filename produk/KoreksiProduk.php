<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'barang';

$kode = $_GET['id'] ?? '';
$stmt = $koneksi->prepare("SELECT * FROM produk WHERE kode_produk = ?");
$stmt->execute([$kode]);
$row = $stmt->fetch();
if (!$row) { header('Location: TampilProduk.php'); exit; }

$kategori  = $koneksi->query("SELECT * FROM kategori ORDER BY nama_kategori")->fetchAll();
$merk_list = $koneksi->query("SELECT * FROM merk ORDER BY nama_merk")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Barang - Sistem Inventori</title>
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
                <div class="breadcrumb"><a href="TampilProduk.php">Barang</a> <span>→</span> <span>Edit</span></div>
                <h1 class="page-title">Edit Data Barang</h1>
            </div>
        </header>
        <div class="content">
            <div class="card" style="max-width:680px;">
                <form action="SimpanKoreksiProduk.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['kode_produk']) ?>">

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="form-group">
                            <label class="form-label">Kode Produk</label>
                            <input type="text" class="form-control" readonly
                                value="<?= htmlspecialchars($row['kode_produk']) ?>"
                                style="background:#f1f5f9;cursor:not-allowed;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control" maxlength="50"
                                value="<?= htmlspecialchars($row['sku'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Barang *</label>
                        <input type="text" name="nama_produk" class="form-control" required maxlength="100"
                            value="<?= htmlspecialchars($row['nama_produk']) ?>">
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="form-group">
                            <label class="form-label">Harga Beli (Rp) *</label>
                            <input type="number" name="harga_beli" class="form-control" required min="0" step="0.01"
                                value="<?= $row['harga_beli'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga Jual (Rp) *</label>
                            <input type="number" name="harga_jual" class="form-control" required min="0" step="0.01"
                                value="<?= $row['harga_jual'] ?>">
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="form-group">
                            <label class="form-label">Kategori *</label>
                            <select name="id_kategori" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['id_kategori'] ?>" <?= $k['id_kategori'] == $row['id_kategori'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($k['nama_kategori']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Merk</label>
                            <select name="id_merk" class="form-control">
                                <option value="">-- Pilih Merk --</option>
                                <?php foreach ($merk_list as $m): ?>
                                    <option value="<?= $m['id_merk'] ?>" <?= $m['id_merk'] == $row['id_merk'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($m['nama_merk']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" maxlength="20"
                            value="<?= htmlspecialchars($row['lokasi']) ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"><?= htmlspecialchars($row['keterangan'] ?? '') ?></textarea>
                    </div>

                    <div style="display:flex;gap:12px;margin-top:8px;">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="TampilProduk.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>

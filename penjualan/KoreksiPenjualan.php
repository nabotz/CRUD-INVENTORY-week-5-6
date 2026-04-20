<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'penjualan';

$id   = (int)($_GET['id'] ?? 0);
$stmt = $koneksi->prepare("SELECT * FROM penjualan WHERE id_penjualan = ?");
$stmt->execute([$id]);
$row  = $stmt->fetch();
if (!$row) { header('Location: TampilPenjualan.php'); exit; }

$produk = $koneksi->query("SELECT kode_produk, nama_produk, sku FROM produk ORDER BY nama_produk")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Penjualan - Sistem Inventori</title>
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
                <div class="breadcrumb"><a href="TampilPenjualan.php">Penjualan</a> <span>→</span> <span>Edit</span></div>
                <h1 class="page-title">Edit Penjualan</h1>
            </div>
        </header>
        <div class="content">
            <div class="card" style="max-width:600px;">
                <form action="SimpanKoreksiPenjualan.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="id" value="<?= $row['id_penjualan'] ?>">

                    <div class="form-group">
                        <label class="form-label">Barang *</label>
                        <select name="kode_produk" class="form-control" required>
                            <?php foreach ($produk as $p): ?>
                                <option value="<?= htmlspecialchars($p['kode_produk']) ?>" <?= $p['kode_produk'] == $row['kode_produk'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars(($p['sku'] ?: $p['kode_produk']) . ' - ' . $p['nama_produk']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Penjualan *</label>
                        <input type="date" name="tgl_penjualan" class="form-control" required value="<?= $row['tgl_penjualan'] ?>">
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="form-group">
                            <label class="form-label">Jumlah *</label>
                            <input type="number" name="jumlah" class="form-control" required min="1" value="<?= $row['jumlah'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga Jual / Unit (Rp) *</label>
                            <input type="number" name="harga_jual" class="form-control" required min="0" step="0.01" value="<?= $row['harga_jual'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Total Nilai (Rp) *</label>
                        <input type="number" name="total_nilai" class="form-control" required min="0" step="0.01" value="<?= $row['total_nilai'] ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($row['keterangan'] ?? '') ?>">
                    </div>

                    <div style="display:flex;gap:12px;margin-top:8px;">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="TampilPenjualan.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>

<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'barang';

$kategori = $koneksi->query("SELECT * FROM kategori ORDER BY nama_kategori")->fetchAll();
$merk_list = $koneksi->query("SELECT * FROM merk ORDER BY nama_merk")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Barang - Sistem Inventori</title>
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
                    <div class="breadcrumb"><a href="TampilProduk.php">Barang</a> <span>→</span> <span>Tambah
                            Baru</span></div>
                    <h1 class="page-title">Tambah Barang Baru</h1>
                </div>
            </header>
            <div class="content">
                <div class="card" style="max-width:680px;">
                    <form action="SimpanProduk.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                            <div class="form-group">
                                <label class="form-label">Kode Produk *</label>
                                <input type="text" name="kode_produk" class="form-control" required
                                    pattern="[A-Za-z0-9]{1,10}" placeholder="Contoh: P011">
                            </div>
                            <div class="form-group">
                                <label class="form-label">SKU</label>
                                <input type="text" name="sku" class="form-control" maxlength="50"
                                    placeholder="Contoh: SKU-001">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nama Barang *</label>
                            <input type="text" name="nama_produk" class="form-control" required maxlength="100"
                                placeholder="Nama lengkap barang">
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                            <div class="form-group">
                                <label class="form-label">Harga Beli (Rp) *</label>
                                <input type="number" name="harga_beli" class="form-control" required min="0" step="0.01"
                                    placeholder="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga Jual (Rp) *</label>
                                <input type="number" name="harga_jual" class="form-control" required min="0" step="0.01"
                                    placeholder="0">
                            </div>
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                            <div class="form-group">
                                <label class="form-label">Kategori *</label>
                                <select name="id_kategori" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($kategori as $k): ?>
                                        <option value="<?= $k['id_kategori'] ?>">
                                            <?= htmlspecialchars($k['nama_kategori']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Merk</label>
                                <select name="id_merk" class="form-control">
                                    <option value="">-- Pilih Merk --</option>
                                    <?php foreach ($merk_list as $m): ?>
                                        <option value="<?= $m['id_merk'] ?>"><?= htmlspecialchars($m['nama_merk']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" maxlength="20"
                                placeholder="Contoh: Rak A-1">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3"
                                placeholder="Deskripsi barang (opsional)"></textarea>
                        </div>

                        <div style="display:flex;gap:12px;margin-top:8px;">
                            <button type="submit" class="btn btn-primary">Simpan Barang</button>
                            <a href="TampilProduk.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
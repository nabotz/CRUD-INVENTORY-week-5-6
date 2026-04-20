<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'penjualan';

$produk = $koneksi->query("SELECT kode_produk, nama_produk, sku, harga_jual FROM produk ORDER BY nama_produk")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Penjualan - Sistem Inventori</title>
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
                <div class="breadcrumb"><a href="TampilPenjualan.php">Penjualan</a> <span>→</span> <span>Tambah Baru</span></div>
                <h1 class="page-title">Tambah Penjualan</h1>
            </div>
        </header>
        <div class="content">
            <div class="card" style="max-width:600px;">
                <form action="SimpanPenjualan.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                    <div class="form-group">
                        <label class="form-label">Barang *</label>
                        <select name="kode_produk" class="form-control" required onchange="isiHargaJual(this)">
                            <option value="">-- Pilih Barang --</option>
                            <?php foreach ($produk as $p): ?>
                                <option value="<?= htmlspecialchars($p['kode_produk']) ?>"
                                    data-harga="<?= $p['harga_jual'] ?>">
                                    <?= htmlspecialchars(($p['sku'] ?: $p['kode_produk']) . ' - ' . $p['nama_produk']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Penjualan *</label>
                        <input type="date" name="tgl_penjualan" class="form-control" required value="<?= date('Y-m-d') ?>">
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="form-group">
                            <label class="form-label">Jumlah *</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" required min="1"
                                onchange="hitungTotal()" oninput="hitungTotal()">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga Jual / Unit (Rp) *</label>
                            <input type="number" name="harga_jual" id="harga_jual" class="form-control" required min="0" step="0.01"
                                onchange="hitungTotal()" oninput="hitungTotal()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Total Nilai (Rp)</label>
                        <input type="number" name="total_nilai" id="total_nilai" class="form-control" readonly
                            style="background:#f1f5f9;" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" maxlength="255" placeholder="Opsional">
                    </div>

                    <div style="display:flex;gap:12px;margin-top:8px;">
                        <button type="submit" class="btn btn-primary">Simpan Penjualan</button>
                        <a href="TampilPenjualan.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<script>
function isiHargaJual(sel) {
    var opt = sel.options[sel.selectedIndex];
    document.getElementById('harga_jual').value = opt.dataset.harga || '';
    hitungTotal();
}
function hitungTotal() {
    var j = parseFloat(document.getElementById('jumlah').value) || 0;
    var h = parseFloat(document.getElementById('harga_jual').value) || 0;
    document.getElementById('total_nilai').value = (j * h).toFixed(2);
}
</script>
</body>
</html>

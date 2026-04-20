<?php
require_once 'auth.php';
include 'koneksi.php';

$total_user     = $koneksi->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_supplier = $koneksi->query("SELECT COUNT(*) FROM supplier")->fetchColumn();
$total_kategori = $koneksi->query("SELECT COUNT(*) FROM kategori")->fetchColumn();
$total_barang   = $koneksi->query("SELECT COUNT(*) FROM produk")->fetchColumn();

$transaksi_terbaru = $koneksi->query(
    "SELECT ts.*, s.nama as nama_supplier, p.nama_produk
     FROM transaksi_stok ts
     JOIN supplier s ON ts.id_supplier = s.id_supplier
     JOIN produk p ON ts.kode_produk = p.kode_produk
     ORDER BY ts.id_transaksi DESC LIMIT 5"
)->fetchAll();

$penjualan_terbaru = $koneksi->query(
    "SELECT pj.*, p.nama_produk
     FROM penjualan pj
     JOIN produk p ON pj.kode_produk = p.kode_produk
     ORDER BY pj.id_penjualan DESC LIMIT 5"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/menu.css">
    <style>
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat-box { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 22px 24px; }
        .stat-box-value { font-size: 32px; font-weight: 800; color: #0a0a0a; line-height: 1; margin-bottom: 6px; }
        .stat-box-label { font-size: 13px; color: #6b7280; font-weight: 500; }
        .stat-box.accent { background: #0a0a0a; }
        .stat-box.accent .stat-box-value, .stat-box.accent .stat-box-label { color: #fff; }
        .stat-box.green { background: #f0fdf4; border-color: #bbf7d0; }
        .stat-box.green .stat-box-value { color: #166534; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        @media (max-width: 900px) { .stat-grid { grid-template-columns: repeat(2,1fr); } .two-col { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="logo"><span class="logo-text">Inventori</span></div>
        <ul class="nav-menu">
            <li><a href="menu.php" class="active">Dashboard</a></li>
            <li><a href="produk/TampilProduk.php">Barang</a></li>
            <li><a href="pembelian/TampilPembelian.php">Pembelian</a></li>
            <li><a href="penjualan/TampilPenjualan.php">Penjualan</a></li>
            <li><a href="stok/TampilStok.php">Stok</a></li>
            <li><a href="laporan/TampilLaporan.php">Laporan</a></li>
            <li><a href="supplier/TampilSupplier.php">Supplier</a></li>
            <li><a href="kategori/TampilKategori.php">Kategori &amp; Merk</a></li>
            <li><a href="pengaturan/index.php">Pengaturan</a></li>
        </ul>
        <div class="sidebar-footer">
            <div class="sidebar-brand">Sistem Inventori</div>
            <div class="user-card">
                <div class="user-avatar">
                    <?php if (!empty($_SESSION['foto'])): ?>
                        <img src="user/uploads/<?= htmlspecialchars($_SESSION['foto']) ?>" alt="Avatar"
                            style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                    <?php else: ?>
                        <span style="color:#6b7280;">&#128100;</span>
                    <?php endif; ?>
                </div>
                <div class="user-info">
                    <div class="user-name"><?= htmlspecialchars($_SESSION['nama']) ?></div>
                    <div class="user-role">Admin</div>
                </div>
                <a href="logout.php" class="logout-link" title="Logout">&#x2192;</a>
            </div>
        </div>
    </aside>

    <main class="main">
        <header class="header">
            <div class="header-top"><h1 class="page-title">Dashboard</h1></div>
        </header>

        <div class="content">
            <!-- 4 Stat cards -->
            <div class="stat-grid">
                <div class="stat-box accent">
                    <div class="stat-box-value"><?= $total_user ?></div>
                    <div class="stat-box-label">Total User</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-value"><?= $total_supplier ?></div>
                    <div class="stat-box-label">Total Supplier</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-value"><?= $total_kategori ?></div>
                    <div class="stat-box-label">Total Kategori</div>
                </div>
                <div class="stat-box green">
                    <div class="stat-box-value"><?= $total_barang ?></div>
                    <div class="stat-box-label">Total Barang</div>
                </div>
            </div>

            <div class="two-col">
                <!-- Pembelian terbaru -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pembelian Terbaru</h3>
                        <a href="pembelian/TampilPembelian.php" style="font-size:13px;color:#6b7280;text-decoration:none;">Lihat Semua</a>
                    </div>
                    <?php if ($transaksi_terbaru): ?>
                        <table class="data-table">
                            <thead><tr><th>Barang</th><th>Jumlah</th><th>Nilai</th></tr></thead>
                            <tbody>
                                <?php foreach ($transaksi_terbaru as $t): ?>
                                <tr>
                                    <td><?= htmlspecialchars($t['nama_produk'] ?: $t['kode_produk']) ?></td>
                                    <td><?= $t['jumlah'] ?></td>
                                    <td>Rp <?= number_format($t['total_nilai'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div style="color:#9ca3af;padding:16px 0;font-size:14px;">Belum ada data pembelian</div>
                    <?php endif; ?>
                </div>

                <!-- Penjualan terbaru -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Penjualan Terbaru</h3>
                        <a href="penjualan/TampilPenjualan.php" style="font-size:13px;color:#6b7280;text-decoration:none;">Lihat Semua</a>
                    </div>
                    <?php if ($penjualan_terbaru): ?>
                        <table class="data-table">
                            <thead><tr><th>Barang</th><th>Jumlah</th><th>Nilai</th></tr></thead>
                            <tbody>
                                <?php foreach ($penjualan_terbaru as $p): ?>
                                <tr>
                                    <td><?= htmlspecialchars($p['nama_produk'] ?: $p['kode_produk']) ?></td>
                                    <td><?= $p['jumlah'] ?></td>
                                    <td>Rp <?= number_format($p['total_nilai'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div style="color:#9ca3af;padding:16px 0;font-size:14px;">Belum ada data penjualan</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>

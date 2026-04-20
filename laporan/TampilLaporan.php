<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'laporan';

// Summary stats
$total_pembelian = $koneksi->query("SELECT COALESCE(SUM(total_nilai),0) FROM transaksi_stok")->fetchColumn();
$total_penjualan = $koneksi->query("SELECT COALESCE(SUM(total_nilai),0) FROM penjualan")->fetchColumn();
$laba = $total_penjualan - $total_pembelian;

// Month/year lists for filter
$bulan_nama = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$bulan_list = $koneksi->query("SELECT DISTINCT MONTH(tgl_transaksi) as b FROM transaksi_stok ORDER BY b")->fetchAll();
$tahun_list = $koneksi->query("SELECT DISTINCT YEAR(tgl_transaksi) as t FROM transaksi_stok ORDER BY t DESC")->fetchAll();

// Recent riwayat
$riwayat = $koneksi->query(
    "SELECT 'Pembelian' as jenis, ts.tgl_transaksi as tgl, p.nama_produk, ts.jumlah, ts.total_nilai
     FROM transaksi_stok ts JOIN produk p ON ts.kode_produk = p.kode_produk
     UNION ALL
     SELECT 'Penjualan', pj.tgl_penjualan, p.nama_produk, pj.jumlah, pj.total_nilai
     FROM penjualan pj JOIN produk p ON pj.kode_produk = p.kode_produk
     ORDER BY tgl DESC LIMIT 20"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .summary-cards { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:28px; }
        .summary-card { background:#fff; border:1px solid #e5e7eb; border-radius:14px; padding:20px 24px; }
        .summary-card-value { font-size:22px; font-weight:800; margin-bottom:4px; }
        .summary-card-label { font-size:13px; color:#6b7280; }
        .badge-beli { background:#eff6ff; color:#1d4ed8; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
        .badge-jual { background:#f0fdf4; color:#166534; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
        @media(max-width:700px){.summary-cards{grid-template-columns:1fr;}}
    </style>
</head>
<body>
<div class="dashboard">
    <?php include '../includes/sidebar.php'; ?>
    <main class="main">
        <header class="header">
            <h1 class="page-title">Laporan</h1>
            <div class="header-right" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <form action="../riwayat_stok/CetakRiwayatStokPdf.php" method="GET" target="_blank" style="display:flex;gap:8px;align-items:center;">
                    <select name="bulan" class="form-control" style="width:auto;padding:8px 12px;">
                        <option value="">-- Semua Bulan --</option>
                        <?php foreach ($bulan_list as $b): ?>
                            <option value="<?= $b['b'] ?>"><?= $bulan_nama[$b['b']] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="tahun" class="form-control" style="width:auto;padding:8px 12px;">
                        <?php foreach ($tahun_list as $t): ?>
                            <option value="<?= $t['t'] ?>"><?= $t['t'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-secondary">Cetak Pembelian PDF</button>
                </form>
            </div>
        </header>
        <div class="content">
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-card-value" style="color:#1d4ed8;">Rp <?= number_format($total_pembelian, 0, ',', '.') ?></div>
                    <div class="summary-card-label">Total Pembelian</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-value" style="color:#166534;">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></div>
                    <div class="summary-card-label">Total Penjualan</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-value" style="color:<?= $laba >= 0 ? '#166534' : '#991b1b' ?>;">
                        Rp <?= number_format(abs($laba), 0, ',', '.') ?>
                    </div>
                    <div class="summary-card-label"><?= $laba >= 0 ? 'Estimasi Laba' : 'Estimasi Rugi' ?></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Transaksi (20 Terbaru)</h3>
                    <a href="../pembelian/TampilPembelian.php" style="font-size:13px;color:#6b7280;text-decoration:none;">Lihat Semua Pembelian</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td>
                                    <span class="<?= $r['jenis'] === 'Pembelian' ? 'badge-beli' : 'badge-jual' ?>">
                                        <?= $r['jenis'] ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($r['tgl'])) ?></td>
                                <td><?= htmlspecialchars($r['nama_produk']) ?></td>
                                <td><?= $r['jumlah'] ?> unit</td>
                                <td>Rp <?= number_format($r['total_nilai'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>

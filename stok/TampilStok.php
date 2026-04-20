<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'stok';

$result = $koneksi->query(
    "SELECT
        p.kode_produk,
        p.sku,
        p.nama_produk,
        k.nama_kategori,
        COALESCE((SELECT SUM(jumlah) FROM transaksi_stok WHERE kode_produk = p.kode_produk), 0) AS stok_masuk,
        COALESCE((SELECT SUM(jumlah) FROM penjualan WHERE kode_produk = p.kode_produk), 0) AS stok_keluar
     FROM produk p
     LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
     ORDER BY p.nama_produk"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Stok - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
        .badge-ok { background:#f0fdf4; color:#166534; }
        .badge-low { background:#fef9c3; color:#854d0e; }
        .badge-empty { background:#fef2f2; color:#991b1b; }
    </style>
</head>
<body>
<div class="dashboard">
    <?php include '../includes/sidebar.php'; ?>
    <main class="main">
        <header class="header">
            <h1 class="page-title">Stok Barang</h1>
        </header>
        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ringkasan Stok</h3>
                    <span style="color:var(--text-gray);font-size:14px;">Total: <?= count($result) ?> barang</span>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SKU</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok Masuk</th>
                                <th>Stok Keluar</th>
                                <th>Total Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($result as $row):
                                $total = $row['stok_masuk'] - $row['stok_keluar'];
                                if ($total <= 0) $badge = ['badge-empty', 'Habis'];
                                elseif ($total <= 5) $badge = ['badge-low', 'Menipis'];
                                else $badge = ['badge-ok', 'Tersedia'];
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['sku'] ?: $row['kode_produk']) ?></strong></td>
                                <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                <td><?= htmlspecialchars($row['nama_kategori'] ?? '-') ?></td>
                                <td><?= $row['stok_masuk'] ?></td>
                                <td><?= $row['stok_keluar'] ?></td>
                                <td><strong><?= $total ?></strong></td>
                                <td><span class="badge <?= $badge[0] ?>"><?= $badge[1] ?></span></td>
                                <td class="actions">
                                    <a href="../pembelian/TambahPembelian.php" class="btn btn-sm btn-primary">+ Beli</a>
                                    <a href="../penjualan/TambahPenjualan.php" class="btn btn-sm btn-secondary">+ Jual</a>
                                </td>
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

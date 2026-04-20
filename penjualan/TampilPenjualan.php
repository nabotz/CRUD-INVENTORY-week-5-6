<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'penjualan';

$result = $koneksi->query(
    "SELECT pj.*, p.nama_produk, p.sku
     FROM penjualan pj
     JOIN produk p ON pj.kode_produk = p.kode_produk
     ORDER BY pj.id_penjualan DESC"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Penjualan - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
<div class="dashboard">
    <?php include '../includes/sidebar.php'; ?>
    <main class="main">
        <header class="header">
            <h1 class="page-title">Menu Penjualan</h1>
            <div class="header-right">
                <a href="TambahPenjualan.php" class="btn btn-primary">+ Tambah Penjualan</a>
            </div>
        </header>
        <div class="content">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Data penjualan berhasil disimpan.</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Terjadi kesalahan, silakan coba lagi.</div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Penjualan</h3>
                    <span style="color:var(--text-gray);font-size:14px;">Total: <?= count($result) ?> transaksi</span>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SKU / Kode</th>
                                <th>Nama Barang</th>
                                <th>Tgl Penjualan</th>
                                <th>Jumlah</th>
                                <th>Harga Jual</th>
                                <th>Total Nilai</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($result as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['sku'] ?: $row['kode_produk']) ?></td>
                                <td><strong><?= htmlspecialchars($row['nama_produk']) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($row['tgl_penjualan'])) ?></td>
                                <td><?= $row['jumlah'] ?> unit</td>
                                <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                                <td><strong>Rp <?= number_format($row['total_nilai'], 0, ',', '.') ?></strong></td>
                                <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
                                <td class="actions">
                                    <a href="KoreksiPenjualan.php?id=<?= $row['id_penjualan'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                                    <form method="POST" action="HapusPenjualan.php" style="display:inline;" onsubmit="return confirm('Hapus data penjualan ini?')">
                                        <input type="hidden" name="id" value="<?= $row['id_penjualan'] ?>">
                                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
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

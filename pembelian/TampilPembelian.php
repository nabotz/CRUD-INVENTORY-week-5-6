<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'pembelian';

$result = $koneksi->query(
    "SELECT ts.*, s.nama as nama_supplier, p.nama_produk, p.sku
     FROM transaksi_stok ts
     JOIN supplier s ON ts.id_supplier = s.id_supplier
     JOIN produk p ON ts.kode_produk = p.kode_produk
     ORDER BY ts.id_transaksi DESC"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pembelian - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
<div class="dashboard">
    <?php include '../includes/sidebar.php'; ?>
    <main class="main">
        <header class="header">
            <h1 class="page-title">Menu Pembelian</h1>
            <div class="header-right">
                <a href="TambahPembelian.php" class="btn btn-primary">+ Tambah Pembelian</a>
            </div>
        </header>
        <div class="content">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Data pembelian berhasil disimpan.</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Terjadi kesalahan, silakan coba lagi.</div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pembelian</h3>
                    <span style="color:var(--text-gray);font-size:14px;">Total: <?= count($result) ?> transaksi</span>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Supplier</th>
                                <th>SKU / Kode</th>
                                <th>Nama Barang</th>
                                <th>Tgl Pembelian</th>
                                <th>Jumlah</th>
                                <th>Total Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($result as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['nama_supplier']) ?></strong></td>
                                <td><?= htmlspecialchars($row['sku'] ?: $row['kode_produk']) ?></td>
                                <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tgl_transaksi'])) ?></td>
                                <td><?= $row['jumlah'] ?> unit</td>
                                <td><strong>Rp <?= number_format($row['total_nilai'], 0, ',', '.') ?></strong></td>
                                <td class="actions">
                                    <a href="KoreksiPembelian.php?id=<?= $row['id_transaksi'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                                    <form method="POST" action="HapusPembelian.php" style="display:inline;" onsubmit="return confirm('Hapus data pembelian ini?')">
                                        <input type="hidden" name="id" value="<?= $row['id_transaksi'] ?>">
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

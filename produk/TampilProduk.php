<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'barang';

$result = $koneksi->query(
    "SELECT p.*, k.nama_kategori, m.nama_merk
     FROM produk p
     LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
     LEFT JOIN merk m ON p.id_merk = m.id_merk
     ORDER BY p.kode_produk"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Barang - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="dashboard">
        <?php include '../includes/sidebar.php'; ?>
        <main class="main">
            <header class="header">
                <h1 class="page-title">Data Barang</h1>
                <div class="header-right">
                    <a href="TambahProduk.php" class="btn btn-primary">+ Tambah Barang</a>
                </div>
            </header>
            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Barang</h3>
                        <span style="color:var(--text-gray);font-size:14px;">Total: <?= count($result) ?> barang</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SKU</th>
                                    <th>Nama</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Kategori</th>
                                    <th>Merk</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($result as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($row['sku'] ?: $row['kode_produk']) ?></strong>
                                        </td>
                                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                        <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($row['nama_kategori'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['nama_merk'] ?? '-') ?></td>
                                        <td
                                            style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            <?= htmlspecialchars($row['keterangan'] ?? '-') ?>
                                        </td>
                                        <td class="actions">
                                            <a href="KoreksiProduk.php?id=<?= urlencode($row['kode_produk']) ?>"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                            <form method="POST" action="HapusProduk.php" style="display:inline;"
                                                onsubmit="return confirm('Hapus barang ini?')">
                                                <input type="hidden" name="id"
                                                    value="<?= htmlspecialchars($row['kode_produk']) ?>">
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
<?php
require_once '../auth.php';
include '../koneksi.php';

$base_url = '../';
$current_page = 'kategori_merk';

$result = $koneksi->query("SELECT m.*, COUNT(p.kode_produk) as jumlah_produk FROM merk m LEFT JOIN produk p ON m.id_merk = p.id_merk GROUP BY m.id_merk ORDER BY m.nama_merk")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Merk - Sistem Inventori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
<div class="dashboard">
    <?php include '../includes/sidebar.php'; ?>
    <main class="main">
        <header class="header">
            <h1 class="page-title">Data Merk</h1>
            <div class="header-right">
                <a href="../kategori/TampilKategori.php" class="btn btn-secondary">Kelola Kategori</a>
                <a href="TambahMerk.php" class="btn btn-primary">+ Tambah Merk</a>
            </div>
        </header>
        <div class="content">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Data merk berhasil disimpan.</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Terjadi kesalahan. Pastikan tidak ada barang yang menggunakan merk ini sebelum menghapus.</div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Merk</h3>
                    <span style="color:var(--text-gray);font-size:14px;">Total: <?= count($result) ?> merk</span>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>No</th><th>Nama Merk</th><th>Jumlah Barang</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($result as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['nama_merk']) ?></strong></td>
                                <td><?= $row['jumlah_produk'] ?> barang</td>
                                <td class="actions">
                                    <a href="KoreksiMerk.php?id=<?= $row['id_merk'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                                    <form method="POST" action="HapusMerk.php" style="display:inline;" onsubmit="return confirm('Hapus merk ini?')">
                                        <input type="hidden" name="id" value="<?= $row['id_merk'] ?>">
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

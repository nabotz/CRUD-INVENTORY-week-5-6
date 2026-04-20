<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

function bersih($data) { return htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); }

$kode_produk = bersih($_POST['kode_produk'] ?? '');
$sku         = bersih($_POST['sku'] ?? '');
$nama_produk = bersih($_POST['nama_produk'] ?? '');
$id_kategori = (int)($_POST['id_kategori'] ?? 0);
$id_merk     = !empty($_POST['id_merk']) ? (int)$_POST['id_merk'] : null;
$lokasi      = bersih($_POST['lokasi'] ?? '');
$harga_beli  = (float)($_POST['harga_beli'] ?? 0);
$harga_jual  = (float)($_POST['harga_jual'] ?? 0);
$keterangan  = bersih($_POST['keterangan'] ?? '');

$sql = "INSERT INTO produk (kode_produk, nama_produk, sku, id_kategori, id_merk, lokasi, harga_beli, harga_jual, keterangan)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $koneksi->prepare($sql);

try {
    $stmt->execute([$kode_produk, $nama_produk, $sku ?: null, $id_kategori, $id_merk, $lokasi, $harga_beli, $harga_jual, $keterangan ?: null]);
    header('Location: TampilProduk.php');
} catch (\PDOException $e) {
    error_log("Error insert produk: " . $e->getMessage());
    header('Location: TampilProduk.php?error=1');
}
exit;

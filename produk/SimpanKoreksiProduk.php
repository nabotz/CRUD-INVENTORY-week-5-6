<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

function bersih($data) { return htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); }

$id          = bersih($_POST['id'] ?? '');
$sku         = bersih($_POST['sku'] ?? '');
$nama_produk = bersih($_POST['nama_produk'] ?? '');
$id_kategori = (int)($_POST['id_kategori'] ?? 0);
$id_merk     = !empty($_POST['id_merk']) ? (int)$_POST['id_merk'] : null;
$lokasi      = bersih($_POST['lokasi'] ?? '');
$harga_beli  = (float)($_POST['harga_beli'] ?? 0);
$harga_jual  = (float)($_POST['harga_jual'] ?? 0);
$keterangan  = bersih($_POST['keterangan'] ?? '');

$sql = "UPDATE produk SET nama_produk=?, sku=?, id_kategori=?, id_merk=?, lokasi=?, harga_beli=?, harga_jual=?, keterangan=? WHERE kode_produk=?";
$stmt = $koneksi->prepare($sql);

try {
    $stmt->execute([$nama_produk, $sku ?: null, $id_kategori, $id_merk, $lokasi, $harga_beli, $harga_jual, $keterangan ?: null, $id]);
    header('Location: TampilProduk.php');
} catch (\PDOException $e) {
    error_log("Error update produk: " . $e->getMessage());
    header('Location: TampilProduk.php?error=1');
}
exit;

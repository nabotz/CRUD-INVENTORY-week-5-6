<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

function bersih($d) { return htmlspecialchars($d, ENT_QUOTES, 'UTF-8'); }

$id            = (int)($_POST['id'] ?? 0);
$kode_produk   = bersih($_POST['kode_produk'] ?? '');
$tgl_penjualan = bersih($_POST['tgl_penjualan'] ?? '');
$jumlah        = (int)($_POST['jumlah'] ?? 0);
$harga_jual    = (float)($_POST['harga_jual'] ?? 0);
$total_nilai   = (float)($_POST['total_nilai'] ?? 0);
$keterangan    = bersih($_POST['keterangan'] ?? '');

$sql = "UPDATE penjualan SET kode_produk=?, tgl_penjualan=?, jumlah=?, harga_jual=?, total_nilai=?, keterangan=? WHERE id_penjualan=?";
$stmt = $koneksi->prepare($sql);

try {
    $stmt->execute([$kode_produk, $tgl_penjualan, $jumlah, $harga_jual, $total_nilai, $keterangan ?: null, $id]);
    header('Location: TampilPenjualan.php?success=1');
} catch (\PDOException $e) {
    error_log("Error update penjualan: " . $e->getMessage());
    header('Location: TampilPenjualan.php?error=1');
}
exit;

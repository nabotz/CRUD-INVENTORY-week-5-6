<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

function bersih($d) { return htmlspecialchars($d, ENT_QUOTES, 'UTF-8'); }

$id             = (int)($_POST['id'] ?? 0);
$id_supplier    = (int)($_POST['id_supplier'] ?? 0);
$kode_produk    = bersih($_POST['kode_produk'] ?? '');
$tgl_transaksi  = bersih($_POST['tgl_transaksi'] ?? '');
$tgl_kadaluarsa = !empty($_POST['tgl_kadaluarsa']) ? bersih($_POST['tgl_kadaluarsa']) : null;
$jumlah         = (int)($_POST['jumlah'] ?? 0);
$total_nilai    = (float)($_POST['total_nilai'] ?? 0);

$sql = "UPDATE transaksi_stok SET id_supplier=?, kode_produk=?, tgl_transaksi=?, tgl_kadaluarsa=?, jumlah=?, total_nilai=? WHERE id_transaksi=?";
$stmt = $koneksi->prepare($sql);

try {
    $stmt->execute([$id_supplier, $kode_produk, $tgl_transaksi, $tgl_kadaluarsa, $jumlah, $total_nilai, $id]);
    header('Location: TampilPembelian.php?success=1');
} catch (\PDOException $e) {
    error_log("Error update pembelian: " . $e->getMessage());
    header('Location: TampilPembelian.php?error=1');
}
exit;

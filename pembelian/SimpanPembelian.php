<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

function bersih($d) { return htmlspecialchars($d, ENT_QUOTES, 'UTF-8'); }

$id_supplier    = (int)($_POST['id_supplier'] ?? 0);
$kode_produk    = bersih($_POST['kode_produk'] ?? '');
$tgl_transaksi  = bersih($_POST['tgl_transaksi'] ?? '');
$tgl_kadaluarsa = !empty($_POST['tgl_kadaluarsa']) ? bersih($_POST['tgl_kadaluarsa']) : null;
$jumlah         = (int)($_POST['jumlah'] ?? 0);
$total_nilai    = (float)($_POST['total_nilai'] ?? 0);

$sql = "INSERT INTO transaksi_stok (id_supplier, kode_produk, tgl_transaksi, tgl_kadaluarsa, jumlah, total_nilai)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $koneksi->prepare($sql);

try {
    $stmt->execute([$id_supplier, $kode_produk, $tgl_transaksi, $tgl_kadaluarsa, $jumlah, $total_nilai]);
    header('Location: TampilPembelian.php?success=1');
} catch (\PDOException $e) {
    error_log("Error insert pembelian: " . $e->getMessage());
    header('Location: TampilPembelian.php?error=1');
}
exit;

<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

$id   = (int)($_POST['id'] ?? 0);
$stmt = $koneksi->prepare("DELETE FROM transaksi_stok WHERE id_transaksi = ?");

try {
    $stmt->execute([$id]);
    header('Location: TampilPembelian.php?success=1');
} catch (\PDOException $e) {
    error_log("Error hapus pembelian: " . $e->getMessage());
    header('Location: TampilPembelian.php?error=1');
}
exit;

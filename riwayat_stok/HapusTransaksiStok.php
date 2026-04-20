<?php
require_once '../auth.php';
csrf_check();
include "../koneksi.php";

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: TampilRiwayatStok.php');
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM transaksi_stok WHERE id_transaksi = ?");

try {
    $stmt->execute([$id]);
    header('Location: TampilRiwayatStok.php');
} catch (\PDOException $e) {
    error_log("Error hapus transaksi stok: " . $e->getMessage());
    header('Location: TampilRiwayatStok.php?error=1');
}

$stmt = null;
exit;
?>

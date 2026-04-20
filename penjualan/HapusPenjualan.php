<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

$id   = (int)($_POST['id'] ?? 0);
$stmt = $koneksi->prepare("DELETE FROM penjualan WHERE id_penjualan = ?");

try {
    $stmt->execute([$id]);
    header('Location: TampilPenjualan.php?success=1');
} catch (\PDOException $e) {
    error_log("Error hapus penjualan: " . $e->getMessage());
    header('Location: TampilPenjualan.php?error=1');
}
exit;

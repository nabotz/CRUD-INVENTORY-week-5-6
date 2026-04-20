<?php
require_once '../auth.php';
csrf_check();
include "../koneksi.php";

$id = $_POST['id'] ?? '';

if (empty($id)) {
    header('Location: TampilProduk.php');
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM produk WHERE kode_produk = ?");

try {
    $stmt->execute([$id]);
    header('Location: TampilProduk.php');
} catch (\PDOException $e) {
    error_log("Error hapus produk: " . $e->getMessage());
    header('Location: TampilProduk.php?error=1');
}

$stmt = null;
exit;
?>

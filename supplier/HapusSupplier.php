<?php
require_once '../auth.php';
csrf_check();
include "../koneksi.php";

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: TampilSupplier.php');
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM supplier WHERE id_supplier = ?");

try {
    $stmt->execute([$id]);
    header('Location: TampilSupplier.php');
} catch (\PDOException $e) {
    error_log("Error hapus supplier: " . $e->getMessage());
    header('Location: TampilSupplier.php?error=1');
}

$stmt = null;
exit;
?>

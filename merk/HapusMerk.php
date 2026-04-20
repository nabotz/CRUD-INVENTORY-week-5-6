<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

$id   = (int)($_POST['id'] ?? 0);
$stmt = $koneksi->prepare("DELETE FROM merk WHERE id_merk = ?");
try {
    $stmt->execute([$id]);
    header('Location: TampilMerk.php?success=1');
} catch (\PDOException $e) {
    error_log("Error hapus merk: " . $e->getMessage());
    header('Location: TampilMerk.php?error=1');
}
exit;

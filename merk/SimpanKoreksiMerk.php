<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

$id        = (int)($_POST['id'] ?? 0);
$nama_merk = htmlspecialchars($_POST['nama_merk'] ?? '', ENT_QUOTES, 'UTF-8');

$stmt = $koneksi->prepare("UPDATE merk SET nama_merk = ? WHERE id_merk = ?");
try {
    $stmt->execute([$nama_merk, $id]);
    header('Location: TampilMerk.php?success=1');
} catch (\PDOException $e) {
    error_log("Error update merk: " . $e->getMessage());
    header('Location: TampilMerk.php?error=1');
}
exit;

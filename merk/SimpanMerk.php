<?php
require_once '../auth.php';
csrf_check();
include '../koneksi.php';

$nama_merk = htmlspecialchars($_POST['nama_merk'] ?? '', ENT_QUOTES, 'UTF-8');

$stmt = $koneksi->prepare("INSERT INTO merk (nama_merk) VALUES (?)");
try {
    $stmt->execute([$nama_merk]);
    header('Location: TampilMerk.php?success=1');
} catch (\PDOException $e) {
    error_log("Error insert merk: " . $e->getMessage());
    header('Location: TampilMerk.php?error=1');
}
exit;

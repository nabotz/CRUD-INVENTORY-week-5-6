<?php
require_once '../auth.php';
csrf_check();
include "../koneksi.php";
include_once '../includes/image_helper.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: TampilKategori.php');
    exit;
}

$stmt_foto = $koneksi->prepare("SELECT foto FROM kategori WHERE id_kategori = ?");
$stmt_foto->execute([$id]);
$data = $stmt_foto->fetch();

if (!empty($data['foto'])) {
    hapus_gambar($data['foto'], 'uploads/');
}

$stmt = $koneksi->prepare("DELETE FROM kategori WHERE id_kategori = ?");

try {
    $stmt->execute([$id]);
    header('Location: TampilKategori.php');
} catch (\PDOException $e) {
    error_log("Error hapus kategori: " . $e->getMessage());
    header('Location: TampilKategori.php?error=1');
}

$stmt = null;
$koneksi = null;
exit;
?>

<?php
require_once '../auth.php';
csrf_check();
include "../koneksi.php";
include_once '../includes/image_helper.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: TampilUser.php');
    exit;
}

$stmt_foto = $koneksi->prepare("SELECT foto FROM users WHERE id = ?");
$stmt_foto->execute([$id]);
$data = $stmt_foto->fetch();

if (!empty($data['foto'])) {
    hapus_gambar($data['foto'], 'uploads/');
}

$stmt = $koneksi->prepare("DELETE FROM users WHERE id = ?");

try {
    $stmt->execute([$id]);
    header('Location: TampilUser.php');
} catch (\PDOException $e) {
    error_log("Error hapus user: " . $e->getMessage());
    header('Location: TampilUser.php?error=1');
}

$stmt = null;
exit;
?>

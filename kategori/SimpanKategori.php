<?php
require_once '../auth.php';
csrf_check();
include "../koneksi.php";
include_once '../includes/image_helper.php';

function bersih($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

$nama_kategori = bersih($_POST['nama_kategori'] ?? '');
$harga_satuan = (int) ($_POST['harga_satuan'] ?? 0);
$stok_minimum = (int) ($_POST['stok_minimum'] ?? 0);

$namaFotoBaru = null;

if (isset($_FILES['foto_kamar']) && $_FILES['foto_kamar']['error'] == 0) {
    $tmpFile = $_FILES['foto_kamar']['tmp_name'];
    $ext = strtolower(pathinfo($_FILES['foto_kamar']['name'], PATHINFO_EXTENSION));

    if ($_FILES['foto_kamar']['size'] > 2 * 1024 * 1024) {
        header('Location: TambahKategori.php?error=ukuran');
        exit;
    }

    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        header('Location: TambahKategori.php?error=format');
        exit;
    }

    $mime = mime_content_type($tmpFile);
    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif']) || !getimagesize($tmpFile)) {
        header('Location: TambahKategori.php?error=format');
        exit;
    }

    $namaFotoBaru = proses_gambar($_FILES['foto_kamar'], 'uploads/');
    if (!$namaFotoBaru) {
        header('Location: TambahKategori.php?error=upload');
        exit;
    }
    // Simpan metadata gambar ke tabel gambar
    try {
        $stmtG = $koneksi->prepare("INSERT INTO gambar (nama_file, filepath, thumbpath, width, height, filesize) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtG->execute([$namaFotoBaru['nama'], 'kategori/uploads/' . $namaFotoBaru['nama'], $namaFotoBaru['thumb_path'], $namaFotoBaru['width'], $namaFotoBaru['height'], $namaFotoBaru['filesize']]);
    } catch (\PDOException $e) { error_log('gambar log: ' . $e->getMessage()); }
}

$sql = "INSERT INTO kategori (nama_kategori, harga_satuan, stok_minimum, foto) VALUES (?, ?, ?, ?)";
$stmt = $koneksi->prepare($sql);

try {
    $stmt->execute([$nama_kategori, $harga_satuan, $stok_minimum, $namaFotoBaru['nama']]);
    header('Location: TampilKategori.php');
} catch (\PDOException $e) {
    error_log("Error insert kategori: " . $e->getMessage());
    header('Location: TampilKategori.php?error=1');
}

$stmt = null;
$koneksi = null;
exit;
?>

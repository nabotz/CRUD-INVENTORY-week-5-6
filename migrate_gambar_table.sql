-- ============================================================
-- MIGRASI: Tambah tabel gambar untuk menyimpan metadata upload
-- Sesuai materi referensi: ref/materi pelengkap file upload.md
-- Jalankan file ini SEKALI di phpMyAdmin →  inventori_db
-- ============================================================

CREATE TABLE IF NOT EXISTS `gambar` (
    `id`         INT(11)        NOT NULL AUTO_INCREMENT,
    `nama_file`  VARCHAR(255)   NOT NULL COMMENT 'Nama file yang tersimpan',
    `filepath`   VARCHAR(255)   NOT NULL COMMENT 'Path file asli',
    `thumbpath`  VARCHAR(255)   NOT NULL COMMENT 'Path thumbnail (thumbs/)',
    `width`      INT(11)        DEFAULT NULL COMMENT 'Lebar gambar (px)',
    `height`     INT(11)        DEFAULT NULL COMMENT 'Tinggi gambar (px)',
    `filesize`   INT(11)        DEFAULT NULL COMMENT 'Ukuran file (bytes)',
    `uploaded_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
  COMMENT='Log metadata setiap gambar yang diupload';

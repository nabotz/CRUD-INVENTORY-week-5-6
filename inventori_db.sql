-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2026 at 04:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventori_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `gambar`
--

CREATE TABLE `gambar` (
  `id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL COMMENT 'Nama file yang tersimpan',
  `filepath` varchar(255) NOT NULL COMMENT 'Path file asli',
  `thumbpath` varchar(255) NOT NULL COMMENT 'Path thumbnail (thumbs/)',
  `width` int(11) DEFAULT NULL COMMENT 'Lebar gambar (px)',
  `height` int(11) DEFAULT NULL COMMENT 'Tinggi gambar (px)',
  `filesize` int(11) DEFAULT NULL COMMENT 'Ukuran file (bytes)',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Log metadata setiap gambar yang diupload';

--
-- Dumping data for table `gambar`
--

INSERT INTO `gambar` (`id`, `nama_file`, `filepath`, `thumbpath`, `width`, `height`, `filesize`, `uploaded_at`) VALUES
(1, 'foto_69e631155c5f7.jpg', 'kategori/uploads/foto_69e631155c5f7.jpg', 'uploads/thumbs/foto_69e631155c5f7.jpg', 231, 218, 16011, '2026-04-20 13:58:45'),
(2, 'foto_69e6313c60f58.jpg', 'kategori/uploads/foto_69e6313c60f58.jpg', 'uploads/thumbs/foto_69e6313c60f58.jpg', 500, 500, 16764, '2026-04-20 13:59:24'),
(3, 'foto_69e6315524535.jpg', 'kategori/uploads/foto_69e6315524535.jpg', 'uploads/thumbs/foto_69e6315524535.jpg', 774, 436, 58802, '2026-04-20 13:59:49');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `stok_minimum` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `harga_satuan`, `stok_minimum`, `foto`) VALUES
(1, 'Laptop & Notebook', 8000000.00, 3, NULL),
(2, 'PC Desktop & AIO', 5000000.00, 2, NULL),
(3, 'Monitor', 2500000.00, 3, NULL),
(4, 'Komponen PC', 1200000.00, 5, 'foto_69e6315524535.jpg'),
(5, 'Periferal', 350000.00, 10, NULL),
(6, 'Jaringan &amp; Networking', 400000.00, 5, 'foto_69e6313c60f58.jpg'),
(7, 'Printer & Scanner', 1800000.00, 2, NULL),
(8, 'Penyimpanan', 600000.00, 8, NULL),
(9, 'Aksesoris Komputer', 150000.00, 15, 'foto_69e631155c5f7.jpg'),
(10, 'UPS & Power Supply', 750000.00, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merk`
--

CREATE TABLE `merk` (
  `id_merk` int(11) NOT NULL,
  `nama_merk` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merk`
--

INSERT INTO `merk` (`id_merk`, `nama_merk`) VALUES
(1, 'Samsung'),
(2, 'Lenovo'),
(3, 'Epson'),
(4, 'Panasonic'),
(5, 'Xiaomi'),
(6, 'Canon'),
(7, 'HP'),
(8, 'Asus'),
(9, 'Pilot'),
(10, 'Faber-Castell'),
(11, 'Asus'),
(12, 'Lenovo'),
(13, 'HP'),
(14, 'Acer'),
(15, 'MSI'),
(16, 'Kingston'),
(17, 'Western Digital'),
(18, 'Logitech'),
(19, 'TP-Link'),
(20, 'Epson');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `kode_produk` varchar(10) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_nilai` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `kode_produk`, `tgl_penjualan`, `jumlah`, `harga_jual`, `total_nilai`, `keterangan`) VALUES
(1, 'P001', '2026-04-01', 2, 4200000.00, 8400000.00, 'Pelanggan toko'),
(2, 'P002', '2026-04-02', 1, 14500000.00, 14500000.00, 'Pembelian korporat'),
(3, 'P003', '2026-04-03', 3, 2200000.00, 6600000.00, NULL),
(4, 'P004', '2026-04-05', 2, 1100000.00, 2200000.00, 'Renovasi kantor'),
(5, 'P005', '2026-04-05', 1, 1500000.00, 1500000.00, 'Renovasi kantor'),
(6, 'P006', '2026-04-07', 50, 5000.00, 250000.00, 'Pembelian alat tulis kantor'),
(7, 'P007', '2026-04-09', 1, 9000000.00, 9000000.00, 'Fotografer freelance'),
(8, 'P008', '2026-04-10', 2, 3900000.00, 7800000.00, NULL),
(9, 'P009', '2026-04-12', 5, 600000.00, 3000000.00, 'Pembelian online'),
(10, 'P010', '2026-04-14', 8, 380000.00, 3040000.00, 'Klinik pratama'),
(11, 'LP001', '2026-04-03', 1, 9800000.00, 9800000.00, 'Pelanggan walk-in'),
(12, 'LP002', '2026-04-04', 2, 7200000.00, 14400000.00, 'Pembelian paket pelajar'),
(13, 'MN002', '2026-04-06', 3, 2350000.00, 7050000.00, 'Pembelian korporat'),
(14, 'KP001', '2026-04-08', 10, 820000.00, 8200000.00, 'Upgrade RAM pelanggan'),
(15, 'KP002', '2026-04-08', 5, 950000.00, 4750000.00, 'Upgrade storage pelanggan'),
(16, 'PF001', '2026-04-10', 2, 830000.00, 1660000.00, NULL),
(17, 'LP003', '2026-04-11', 1, 8200000.00, 8200000.00, 'Pelanggan online (Tokopedia)'),
(18, 'JR001', '2026-04-12', 4, 680000.00, 2720000.00, 'UMKM paket WiFi'),
(19, 'PR001', '2026-04-13', 2, 2050000.00, 4100000.00, 'Kantor kelurahan'),
(20, 'MN001', '2026-04-14', 1, 5700000.00, 5700000.00, 'Desainer grafis freelance');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `kode_produk` varchar(10) NOT NULL,
  `nama_produk` varchar(100) NOT NULL DEFAULT '',
  `sku` varchar(50) DEFAULT NULL,
  `id_kategori` int(11) NOT NULL,
  `lokasi` varchar(20) NOT NULL,
  `harga_beli` decimal(15,2) NOT NULL DEFAULT 0.00,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `id_merk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`kode_produk`, `nama_produk`, `sku`, `id_kategori`, `lokasi`, `harga_beli`, `harga_jual`, `keterangan`, `id_merk`) VALUES
('JR001', 'Router TP-Link Archer AX23 WiFi 6', 'JR-TPL-AX23', 6, 'Rak E-1', 520000.00, 680000.00, 'AX1800 Dual Band, 4 antena', 9),
('KP001', 'RAM Kingston FURY 16GB DDR4 3200', 'KP-KNG-16D4', 4, 'Rak C-1', 650000.00, 820000.00, 'PC4-25600, CL16, for Desktop', 6),
('KP002', 'SSD WD Green 1TB SATA 2.5\"', 'KP-WD-G1TB', 8, 'Rak C-2', 750000.00, 950000.00, 'Kecepatan baca 545MB/s', 7),
('LP001', 'Laptop Asus VivoBook 15 i5-1235U', 'LP-ASS-VB15', 1, 'Rak A-1', 8500000.00, 9800000.00, 'RAM 8GB DDR4, SSD 512GB, Layar 15.6\" FHD', 1),
('LP002', 'Laptop Lenovo IdeaPad Slim 3 i3', 'LP-LEN-IP3', 1, 'Rak A-2', 6200000.00, 7200000.00, 'RAM 8GB, SSD 256GB, Layar 14\" FHD', 2),
('LP003', 'Laptop Acer Aspire 5 Ryzen 5', 'LP-ACR-A5R', 1, 'Rak A-3', 7000000.00, 8200000.00, 'RAM 8GB DDR5, SSD 512GB, Layar 15.6\"', 4),
('MN001', 'Monitor Asus ProArt 27\" IPS 4K', 'MN-ASS-PA27', 3, 'Rak B-1', 4800000.00, 5700000.00, 'Resolusi 3840x2160, 60Hz, USB-C', 1),
('MN002', 'Monitor HP V24i FHD 24\"', 'MN-HP-V24', 3, 'Rak B-2', 1900000.00, 2350000.00, 'Resolusi 1920x1080, 75Hz, IPS', 3),
('PF001', 'Mouse Logitech MX Master 3S', 'PF-LGT-MX3S', 5, 'Rak D-1', 650000.00, 830000.00, 'Wireless Bluetooth, 8000 DPI, Silent Click', 8),
('PR001', 'Printer Epson L3250 WiFi', 'PR-EPS-L325', 7, 'Rak F-1', 1650000.00, 2050000.00, 'Print, Scan, Copy, WiFi, Ink Tank', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `no_npwp` varchar(20) DEFAULT NULL,
  `jenis_supplier` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama`, `alamat`, `no_telp`, `no_npwp`, `jenis_supplier`) VALUES
(1, 'PT Synnex Metrodata', 'Jl. Jend. Sudirman Kav. 10, Jakarta', '021-57968000', '01.234.567.8-001.000', 'Distributor'),
(2, 'PT Erajaya Swasembada', 'Jl. Hayam Wuruk No. 8, Jakarta Barat', '021-38900100', '02.345.678.9-002.000', 'Distributor'),
(3, 'CV Komputindo Jaya', 'Jl. Glogor Carik No. 7, Denpasar', '0361-234567', '03.456.789.0-003.000', 'Agen'),
(4, 'PT Datascrip', 'Jl. Hayam Wuruk No. 3, Jakarta Pusat', '021-6001234', '04.567.890.1-004.000', 'Distributor'),
(5, 'UD Sukses Komputer', 'Ruko ITC Mangga Dua Blok C No. 12', '021-62313456', '05.678.901.2-005.000', 'Agen'),
(6, 'PT Global Teknindo', 'Jl. Wahid Hasyim No. 25, Jakarta', '021-31900500', '06.789.012.3-006.000', 'Distributor'),
(7, 'CV Digital Network', 'Jl. Asia Afrika No. 44, Bandung', '022-4232100', '07.890.123.4-007.000', 'Agen'),
(8, 'PT Multikreasi Datacom', 'Jl. Boulevard Barat Kelapa Gading', '021-45870000', '08.901.234.5-008.000', 'Distributor'),
(9, 'CV Infotama Teknologi', 'Jl. Pahlawan No. 18, Surabaya', '031-5012345', '09.012.345.6-009.000', 'Agen'),
(10, 'PT Acer Indonesia', 'Jl. TB Simatupang Kav. 88, Jakarta', '021-78847777', '10.123.456.7-010.000', 'Produsen');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_stok`
--

CREATE TABLE `transaksi_stok` (
  `id_transaksi` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `kode_produk` varchar(10) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `tgl_kadaluarsa` date DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `total_nilai` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_stok`
--

INSERT INTO `transaksi_stok` (`id_transaksi`, `id_supplier`, `kode_produk`, `tgl_transaksi`, `tgl_kadaluarsa`, `jumlah`, `total_nilai`) VALUES
(1, 1, 'LP001', '2026-04-01', NULL, 5, 42500000.00),
(2, 2, 'LP002', '2026-04-02', NULL, 8, 49600000.00),
(3, 10, 'LP003', '2026-04-02', NULL, 6, 42000000.00),
(4, 6, 'MN001', '2026-04-04', NULL, 4, 19200000.00),
(5, 8, 'MN002', '2026-04-05', NULL, 10, 19000000.00),
(6, 1, 'KP001', '2026-04-07', NULL, 30, 19500000.00),
(7, 4, 'KP002', '2026-04-07', NULL, 20, 15000000.00),
(8, 5, 'PF001', '2026-04-09', NULL, 15, 9750000.00),
(9, 7, 'JR001', '2026-04-10', NULL, 12, 6240000.00),
(10, 3, 'PR001', '2026-04-11', NULL, 6, 9900000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL,
  `remember_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `email`, `created_at`, `foto`, `remember_token`) VALUES
(3, 'nabil', '$2y$10$jKEdkAhK4kcQHUw9Qjij8evKcubN5Zlts7ucElGN.FskTtmPooWbO', 'NABIL LABQINO', 'nabil@example.com', '2026-01-16 18:14:56', 'foto_696a80203f7cb.jpg', NULL),
(4, 'tyler', '$2y$10$In6Me7lWJIpNwMelgvm4ke8BEuqUYx/8lWq8uYSsB3KXVMYMrdujK', 'Ratno Anung', 'tyler@example.com', '2026-01-17 07:40:14', 'foto_696b3cde04a6f.jpg', NULL),
(5, 'carti', '$2y$10$oGGc/SUzMQh9NnBlam8JlOi.4N5wwYe2bYKzhmyNv1XPVl8b4y3zW', 'jordan teler', 'carti@example.com', '2026-01-17 12:38:53', 'foto_696b82ddb7ce1.jpg', NULL),
(7, 'ryantukam', '$2y$10$o3LN3bRxdJKP.mL9aBsnlOwQh2buD2ho1Eqa4rIYKlF9GnTxRktLW', 'Ryan Tukam', '', '2026-04-20 13:50:19', 'foto_69e62f1b8e215.jpg', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`id_merk`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kode_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `transaksi_stok`
--
ALTER TABLE `transaksi_stok`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `kode_produk` (`kode_produk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gambar`
--
ALTER TABLE `gambar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `merk`
--
ALTER TABLE `merk`
  MODIFY `id_merk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi_stok`
--
ALTER TABLE `transaksi_stok`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi_stok`
--
ALTER TABLE `transaksi_stok`
  ADD CONSTRAINT `transaksi_stok_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`),
  ADD CONSTRAINT `transaksi_stok_ibfk_2` FOREIGN KEY (`kode_produk`) REFERENCES `produk` (`kode_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

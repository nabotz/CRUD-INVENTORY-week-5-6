-- ============================================================
-- DUMMY DATA — Inventori Toko Komputer
-- Urutan insert mengikuti FK dependency
-- Jalankan reset_data.sql terlebih dahulu jika perlu
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- 1. KATEGORI (10 data — kategori produk toko komputer)
-- ============================================================
INSERT INTO `kategori` (`nama_kategori`, `harga_satuan`, `stok_minimum`, `foto`) VALUES
('Laptop & Notebook',   8000000.00,  3, NULL),
('PC Desktop & AIO',    5000000.00,  2, NULL),
('Monitor',             2500000.00,  3, NULL),
('Komponen PC',         1200000.00,  5, NULL),
('Periferal',            350000.00, 10, NULL),
('Jaringan & Networking',400000.00,  5, NULL),
('Printer & Scanner',   1800000.00,  2, NULL),
('Penyimpanan',          600000.00,  8, NULL),
('Aksesoris Komputer',   150000.00, 15, NULL),
('UPS & Power Supply',   750000.00,  3, NULL);

-- ============================================================
-- 2. MERK (10 data — brand populer produk komputer)
-- ============================================================
INSERT INTO `merk` (`nama_merk`) VALUES
('Asus'),
('Lenovo'),
('HP'),
('Acer'),
('MSI'),
('Kingston'),
('Western Digital'),
('Logitech'),
('TP-Link'),
('Epson');

-- ============================================================
-- 3. SUPPLIER (10 data — distributor IT)
-- ============================================================
INSERT INTO `supplier` (`nama`, `alamat`, `no_telp`, `no_npwp`, `jenis_supplier`) VALUES
('PT Synnex Metrodata',      'Jl. Jend. Sudirman Kav. 10, Jakarta',    '021-57968000', '01.234.567.8-001.000', 'Distributor'),
('PT Erajaya Swasembada',    'Jl. Hayam Wuruk No. 8, Jakarta Barat',   '021-38900100', '02.345.678.9-002.000', 'Distributor'),
('CV Komputindo Jaya',        'Jl. Glogor Carik No. 7, Denpasar',      '0361-234567',  '03.456.789.0-003.000', 'Agen'),
('PT Datascrip',              'Jl. Hayam Wuruk No. 3, Jakarta Pusat',   '021-6001234',  '04.567.890.1-004.000', 'Distributor'),
('UD Sukses Komputer',        'Ruko ITC Mangga Dua Blok C No. 12',     '021-62313456', '05.678.901.2-005.000', 'Agen'),
('PT Global Teknindo',        'Jl. Wahid Hasyim No. 25, Jakarta',      '021-31900500', '06.789.012.3-006.000', 'Distributor'),
('CV Digital Network',        'Jl. Asia Afrika No. 44, Bandung',       '022-4232100',  '07.890.123.4-007.000', 'Agen'),
('PT Multikreasi Datacom',    'Jl. Boulevard Barat Kelapa Gading',     '021-45870000', '08.901.234.5-008.000', 'Distributor'),
('CV Infotama Teknologi',     'Jl. Pahlawan No. 18, Surabaya',         '031-5012345',  '09.012.345.6-009.000', 'Agen'),
('PT Acer Indonesia',         'Jl. TB Simatupang Kav. 88, Jakarta',    '021-78847777', '10.123.456.7-010.000', 'Produsen');

-- ============================================================
-- 4. PRODUK (10 data — barang toko komputer)
--    id_kategori: 1=Laptop, 3=Monitor, 4=Komponen, 5=Periferal
--              6=Jaringan, 7=Printer, 8=Penyimpanan, 9=Aksesoris
--    id_merk: 1=Asus, 2=Lenovo, 3=HP, 4=Acer, 5=MSI,
--             6=Kingston, 7=WD, 8=Logitech, 9=TP-Link, 10=Epson
-- ============================================================
INSERT INTO `produk` (`kode_produk`, `nama_produk`, `sku`, `id_kategori`, `id_merk`, `lokasi`, `harga_beli`, `harga_jual`, `keterangan`) VALUES
('LP001', 'Laptop Asus VivoBook 15 i5-1235U',  'LP-ASS-VB15', 1, 1, 'Rak A-1', 8500000.00,  9800000.00, 'RAM 8GB DDR4, SSD 512GB, Layar 15.6" FHD'),
('LP002', 'Laptop Lenovo IdeaPad Slim 3 i3',   'LP-LEN-IP3',  1, 2, 'Rak A-2', 6200000.00,  7200000.00, 'RAM 8GB, SSD 256GB, Layar 14" FHD'),
('LP003', 'Laptop Acer Aspire 5 Ryzen 5',      'LP-ACR-A5R',  1, 4, 'Rak A-3', 7000000.00,  8200000.00, 'RAM 8GB DDR5, SSD 512GB, Layar 15.6"'),
('MN001', 'Monitor Asus ProArt 27" IPS 4K',    'MN-ASS-PA27', 3, 1, 'Rak B-1', 4800000.00,  5700000.00, 'Resolusi 3840x2160, 60Hz, USB-C'),
('MN002', 'Monitor HP V24i FHD 24"',           'MN-HP-V24',   3, 3, 'Rak B-2', 1900000.00,  2350000.00, 'Resolusi 1920x1080, 75Hz, IPS'),
('KP001', 'RAM Kingston FURY 16GB DDR4 3200',  'KP-KNG-16D4', 4, 6, 'Rak C-1',  650000.00,   820000.00, 'PC4-25600, CL16, for Desktop'),
('KP002', 'SSD WD Green 1TB SATA 2.5"',        'KP-WD-G1TB',  8, 7, 'Rak C-2',  750000.00,   950000.00, 'Kecepatan baca 545MB/s'),
('PF001', 'Mouse Logitech MX Master 3S',       'PF-LGT-MX3S', 5, 8, 'Rak D-1',  650000.00,   830000.00, 'Wireless Bluetooth, 8000 DPI, Silent Click'),
('JR001', 'Router TP-Link Archer AX23 WiFi 6', 'JR-TPL-AX23', 6, 9, 'Rak E-1',  520000.00,   680000.00, 'AX1800 Dual Band, 4 antena'),
('PR001', 'Printer Epson L3250 WiFi',          'PR-EPS-L325', 7,10, 'Rak F-1', 1650000.00,  2050000.00, 'Print, Scan, Copy, WiFi, Ink Tank');

-- ============================================================
-- 5. TRANSAKSI STOK — stok masuk (10 data, bulan April 2026)
-- ============================================================
INSERT INTO `transaksi_stok` (`id_supplier`, `kode_produk`, `tgl_transaksi`, `tgl_kadaluarsa`, `jumlah`, `total_nilai`) VALUES
(1, 'LP001', '2026-04-01', NULL,  5, 42500000.00),
(2, 'LP002', '2026-04-02', NULL,  8, 49600000.00),
(10,'LP003', '2026-04-02', NULL,  6, 42000000.00),
(6, 'MN001', '2026-04-04', NULL,  4, 19200000.00),
(8, 'MN002', '2026-04-05', NULL, 10, 19000000.00),
(1, 'KP001', '2026-04-07', NULL, 30, 19500000.00),
(4, 'KP002', '2026-04-07', NULL, 20, 15000000.00),
(5, 'PF001', '2026-04-09', NULL, 15,  9750000.00),
(7, 'JR001', '2026-04-10', NULL, 12,  6240000.00),
(3, 'PR001', '2026-04-11', NULL,  6,  9900000.00);

-- ============================================================
-- 6. PENJUALAN — stok keluar (10 data, bulan April 2026)
-- ============================================================
INSERT INTO `penjualan` (`kode_produk`, `tgl_penjualan`, `jumlah`, `harga_jual`, `total_nilai`, `keterangan`) VALUES
('LP001', '2026-04-03',  1,  9800000.00,  9800000.00, 'Pelanggan walk-in'),
('LP002', '2026-04-04',  2,  7200000.00, 14400000.00, 'Pembelian paket pelajar'),
('MN002', '2026-04-06',  3,  2350000.00,  7050000.00, 'Pembelian korporat'),
('KP001', '2026-04-08', 10,   820000.00,  8200000.00, 'Upgrade RAM pelanggan'),
('KP002', '2026-04-08',  5,   950000.00,  4750000.00, 'Upgrade storage pelanggan'),
('PF001', '2026-04-10',  2,   830000.00,  1660000.00, NULL),
('LP003', '2026-04-11',  1,  8200000.00,  8200000.00, 'Pelanggan online (Tokopedia)'),
('JR001', '2026-04-12',  4,   680000.00,  2720000.00, 'UMKM paket WiFi'),
('PR001', '2026-04-13',  2,  2050000.00,  4100000.00, 'Kantor kelurahan'),
('MN001', '2026-04-14',  1,  5700000.00,  5700000.00, 'Desainer grafis freelance');

SET FOREIGN_KEY_CHECKS = 1;

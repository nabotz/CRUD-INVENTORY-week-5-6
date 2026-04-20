<?php
// Sidebar template — set $base_url and $current_page before including
?>
<aside class="sidebar">
    <div class="logo">
        <span class="logo-text">Inventori</span>
    </div>

    <ul class="nav-menu">
        <li><a href="<?= $base_url ?>menu.php" class="<?= $current_page == 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="<?= $base_url ?>produk/TampilProduk.php" class="<?= $current_page == 'barang' ? 'active' : '' ?>">Barang</a></li>
        <li><a href="<?= $base_url ?>pembelian/TampilPembelian.php" class="<?= $current_page == 'pembelian' ? 'active' : '' ?>">Pembelian</a></li>
        <li><a href="<?= $base_url ?>penjualan/TampilPenjualan.php" class="<?= $current_page == 'penjualan' ? 'active' : '' ?>">Penjualan</a></li>
        <li><a href="<?= $base_url ?>stok/TampilStok.php" class="<?= $current_page == 'stok' ? 'active' : '' ?>">Stok</a></li>
        <li><a href="<?= $base_url ?>laporan/TampilLaporan.php" class="<?= $current_page == 'laporan' ? 'active' : '' ?>">Laporan</a></li>
        <li><a href="<?= $base_url ?>supplier/TampilSupplier.php" class="<?= $current_page == 'supplier' ? 'active' : '' ?>">Supplier</a></li>
        <li><a href="<?= $base_url ?>kategori/TampilKategori.php" class="<?= $current_page == 'kategori_merk' ? 'active' : '' ?>">Kategori &amp; Merk</a></li>
        <li><a href="<?= $base_url ?>pengaturan/index.php" class="<?= $current_page == 'pengaturan' ? 'active' : '' ?>">Pengaturan</a></li>
    </ul>

    <div class="sidebar-footer">
        <div class="sidebar-brand">Sistem Inventori</div>
        <div class="user-card">
            <div class="user-avatar">
                <?php if (!empty($_SESSION['foto'])): ?>
                    <img src="<?= $base_url ?>user/uploads/<?= htmlspecialchars($_SESSION['foto']) ?>" alt="Avatar"
                        style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                <?php else: ?>
                    <span style="color:#6b7280;">&#128100;</span>
                <?php endif; ?>
            </div>
            <div class="user-info">
                <div class="user-name"><?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?></div>
                <div class="user-role">Admin</div>
            </div>
            <a href="<?= $base_url ?>logout.php" class="logout-link" title="Logout">&#x2192;</a>
        </div>
    </div>
</aside>

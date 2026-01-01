<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-landmark-dome"></i>
        <span>PortalDesa.</span>
    </div>

    <div class="nav-group">
        <span class="nav-label">Menu Utama</span>
        <a href="dashboard_masyarakat.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard_masyarakat.php') ? 'active' : ''; ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="form_pengajuan.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'form_pengajuan.php') ? 'active' : ''; ?>">
            <i class="fas fa-paper-plane"></i> Buat Laporan
        </a>
        <a href="riwayat_laporan.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'riwayat_laporan.php' || basename($_SERVER['PHP_SELF']) == 'detail_laporan.php') ? 'active' : ''; ?>">
            <i class="fas fa-history"></i> Riwayat Laporan
        </a>
    </div>

    <div class="nav-group">
        <span class="nav-label">Lainnya</span>
        <a href="profil.php" class="nav-item"><i class="fas fa-user-circle"></i> Akun Saya</a>
        <a href="backend/logout.php" class="nav-item" style="color: #ef4444;"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
</aside>
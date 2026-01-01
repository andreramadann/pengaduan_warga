<aside class="sidebar admin-sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-shield-halved"></i>
        <span>Admin Panel.</span>
    </div>

    <div class="nav-group">
        <span class="nav-label">Monitoring</span>
        <a href="dashboard_admin.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard_admin.php') ? 'active' : ''; ?>">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        
        <a href="kelola_laporan.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'kelola_laporan.php' || basename($_SERVER['PHP_SELF']) == 'proses_laporan_admin.php') ? 'active' : ''; ?>">
            <i class="fas fa-tasks"></i> Verifikasi Laporan
        </a>
    </div>

    <div class="nav-group">
        <span class="nav-label">Data Master</span>
        <a href="data_warga.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'data_warga.php') ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> Data Warga
        </a>
        
        <a href="pengaturan_sistem.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'pengaturan_sistem.php') ? 'active' : ''; ?>">
            <i class="fas fa-cogs"></i> Pengaturan
        </a>
    </div>

    <div class="nav-group" style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
        <span class="nav-label">Akun Petugas</span>
        <a href="profil_admin.php" class="nav-item">
            <i class="fas fa-user-shield"></i> Profil Admin
        </a>
        <a href="backend/logout.php" class="nav-item logout-link" onclick="return confirm('Keluar dari panel admin?')">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
    </div>
</aside>
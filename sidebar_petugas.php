<?php
// Deteksi halaman aktif untuk memberikan highlight pada menu
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-user-shield"></i>
        <span>PANEL PETUGAS</span>
    </div>
    
    <nav class="nav-menu">
        <a href="dashboard_petugas.php" class="nav-link <?= ($current_page == 'dashboard_petugas.php') ? 'active' : ''; ?>">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <a href="kelola_laporan.php" class="nav-link <?= ($current_page == 'kelola_laporan.php') ? 'active' : ''; ?>">
            <i class="fas fa-clipboard-list"></i>
            <span>Kelola Laporan</span>
        </a>

        <a href="profil_admin.php" class="nav-link <?= ($current_page == 'profil_admin.php') ? 'active' : ''; ?>">
            <i class="fas fa-user-circle"></i>
            <span>Profil Saya</span>
        </a>

        <div class="nav-divider" style="height: 1px; background: rgba(255,255,255,0.1); margin: 15px 20px;"></div>

        <a href="logout.php" class="nav-link logout" style="color: #fb7185;" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar Sesi</span>
        </a>
    </nav>
</aside>

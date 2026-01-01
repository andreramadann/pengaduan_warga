<?php
session_start();
// Pastikan koneksi dan session aman
require_once 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['role'] != "masyarakat") {
    header("location:login.php?pesan=belum_login");
    exit();
}

$nama_user = $_SESSION['nama_lengkap'];
$id_user = $_SESSION['id_user'];

// Query data untuk statistik
$laporan_user = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id_user='$id_user'");
$count_laporan = mysqli_num_rows($laporan_user);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Government Portal | Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-landmark-dome"></i>
            <span>PortalDesa.</span>
        </div>

        <div class="nav-group">
            <span class="nav-label">Menu Utama</span>
            <a href="#" class="nav-item active"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="form_pengajuan.php" class="nav-item"><i class="fas fa-paper-plane"></i> Buat Laporan</a>
            <a href="riwayat_laporan.php" class="nav-item"><i class="fas fa-history"></i> Riwayat Laporan</a>
        </div>

        <div class="nav-group">
            <span class="nav-label">Pusat Informasi</span>
            <a href="info_pembangunan.php" class="nav-item"><i class="fas fa-map-location-dot"></i> Pembangunan</a>
            <a href="pengumuman.php" class="nav-item"><i class="fas fa-bullhorn"></i> Berita Desa</a>
        </div>

        <div class="nav-group" style="margin-top: auto;">
            <span class="nav-label">Lainnya</span>
            <a href="profil.php" class="nav-item"><i class="fas fa-user-circle"></i> Akun Saya</a>
            <a href="backend/logout.php" class="nav-item" style="color: #ef4444;"><i class="fas fa-sign-out-alt"></i> Keluar</a>
        </div>
    </aside>

    <main class="main">
        <header class="top-bar">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari layanan...">
            </div>
            
            <div class="user-nav">
                <i class="far fa-bell" style="font-size: 1.2rem; color: var(--text-muted);"></i>
                <div style="text-align: right;">
                    <p style="font-size: 0.9rem; font-weight: 700;"><?php echo $nama_user; ?></p>
                    <p style="font-size: 0.75rem; color: var(--text-muted);">Warga Terverifikasi</p>
                </div>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($nama_user); ?>&background=4f46e5&color=fff" 
                     alt="avatar" style="width: 40px; border-radius: 10px;">
            </div>
        </header>

        <section class="welcome">
            <h1 style="font-size: 1.875rem; margin-bottom: 8px;">Selamat Pagi, <?php echo explode(' ', $nama_user)[0]; ?>! 👋</h1>
            <p style="color: var(--text-muted); margin-bottom: 40px;">Berikut rangkuman aktivitas layanan publik Anda hari ini.</p>
        </section>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon-circle" style="background: var(--primary-soft); color: var(--primary);">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <h2><?php echo $count_laporan; ?></h2>
                <p>Total Laporan</p>
            </div>
            <div class="stat-card">
                <div class="icon-circle" style="background: #fff7ed; color: #f97316;">
                    <i class="fas fa-clock"></i>
                </div>
                <h2>2</h2>
                <p>Sedang Diproses</p>
            </div>
            <div class="stat-card">
                <div class="icon-circle" style="background: #f0fdf4; color: #22c55e;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2><?php echo $count_laporan - 2; ?></h2>
                <p>Selesai Ditangani</p>
            </div>
            <div class="stat-card">
                <div class="icon-circle" style="background: #fdf2f8; color: #ec4899;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h2>Aktif</h2>
                <p>Status Warga</p>
            </div>
        </div>


      <h2 class="section-title">Layanan Masyarakat</h2>
    <div class="service-grid">
        <a href="form_pengajuan.php" class="service-card">
            <div class="icon-box"><i class="fas fa-tools"></i></div>
            <h3>Lapor Infrastruktur</h3>
            <p>Adukan kerusakan fasilitas umum seperti jalan rusak atau lampu mati.</p>
        </a>
        <a href="info_pembangunan.php" class="service-card">
            <div class="icon-box"><i class="fas fa-chart-bar"></i></div>
            <h3>Transparansi Desa</h3>
            <p>Pantau penggunaan dana desa dan realisasi program kerja pemerintah.</p>
        </a>
        <a href="kotak_saran.php" class="service-card">
            <div class="icon-box"><i class="fas fa-lightbulb"></i></div>
            <h3>Kotak Aspirasi</h3>
            <p>Sampaikan ide atau masukan untuk kemajuan lingkungan desa Anda.</p>
        </a>

        <a href="pengajuan_surat.php" class="service-card">
            <div class="icon-box"><i class="fas fa-file-signature"></i></div>
            <h3>Layanan Surat <span class="badge-new">PROSES</span></h3>
            <p>Ajukan surat keterangan domisili atau SKTM tanpa harus antre di kantor desa.</p>
        </a>

        <a href="pasar_desa.php" class="service-card">
            <div class="icon-box"><i class="fas fa-store"></i></div>
            <h3>UMKM & Pasar Desa</h3>
            <p>Lihat dan beli produk unggulan karya warga desa untuk dukung ekonomi lokal.</p>
        </a>

        <a href="jadwal_kesehatan.php" class="service-card">
            <div class="icon-box"><i class="fas fa-heart-pulse"></i></div>
            <h3>Info Kesehatan</h3>
            <p>Cek jadwal imunisasi, Posyandu, dan ketersediaan ambulans desa 24 jam.</p>
        </a>
    </div>
    </main>

</body>
</html>
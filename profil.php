<?php
session_start();
include 'koneksi.php';

// Proteksi Halaman
if (!isset($_SESSION['status']) || $_SESSION['role'] != "masyarakat") {
    header("location:login.php");
    exit();
}

// Ambil ID dari session dengan fallback agar tidak error line 12
$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    die("Sesi berakhir, silakan login kembali.");
}

// Ambil data user - PASTIKAN nama tabel 'user' sesuai dengan database Anda
$query_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");

if (!$query_user || mysqli_num_rows($query_user) == 0) {
    // Jika tabel Anda namanya 'masyarakat', ganti 'user' di atas menjadi 'masyarakat'
    die("Data pengguna tidak ditemukan di database. Pastikan nama tabel benar.");
}

$user = mysqli_fetch_assoc($query_user);

// Ambil statistik laporan untuk dipajang di profil
$query_stat = mysqli_query($koneksi, "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai 
    FROM pengajuan WHERE id_user = '$id_user'");
$stat = mysqli_fetch_assoc($query_stat);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya | PortalDesa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/modern-dashboard.css">
</head>
<body>

    <?php include 'sidebar_masyarakat.php'; ?>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Akun / <span style="color: var(--primary);">Pengaturan Profil</span></div>
            <div class="user-nav">
                <a href="backend/logout.php" class="logout-btn" style="text-decoration: none; font-size: 0.8rem;">
                    <i class="fas fa-power-off"></i> Keluar
                </a>
            </div>
        </header>

        <div class="profile-container">
            <div class="profile-sidebar">
                <div class="profile-card-static">
                    <div class="avatar-wrapper">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['nama_lengkap']); ?>&background=4f46e5&color=fff&size=128" alt="Profile">
                        <div class="online-indicator"></div>
                    </div>
                    <h2 style="margin-top: 15px; font-size: 1.2rem;"><?php echo $user['nama_lengkap']; ?></h2>
                    <p style="color: var(--text-muted); font-size: 0.85rem;"><?php echo $user['username']; ?></p>
                    
                    <div class="profile-stats-mini">
                        <div class="stat-item">
                            <span class="stat-num"><?php echo $stat['total']; ?></span>
                            <span class="stat-label">Laporan</span>
                        </div>
                        <div class="stat-sep"></div>
                        <div class="stat-item">
                            <span class="stat-num"><?php echo $stat['selesai']; ?></span>
                            <span class="stat-label">Selesai</span>
                        </div>
                    </div>
                </div>

                <div class="content-card" style="margin-top: 20px; padding: 20px;">
                    <span class="info-label">Informasi Sistem</span>
                    <ul style="list-style: none; font-size: 0.85rem; color: var(--text-main);">
                        <li style="margin-bottom: 10px;"><i class="fas fa-id-badge" style="width: 20px; color: var(--primary);"></i> ID: #USR-<?php echo $user['id_user']; ?></li>
                        <li><i class="fas fa-user-shield" style="width: 20px; color: var(--primary);"></i> Role: <?php echo ucfirst($user['role']); ?></li>
                    </ul>
                </div>
            </div>

            <div class="profile-main">
                <div class="account-form">
                    <div style="margin-bottom: 30px; border-bottom: 1px solid var(--border); padding-bottom: 15px;">
                        <h3 style="font-size: 1.25rem;">Detail Biodata</h3>
                        <p style="color: var(--text-muted); font-size: 0.85rem;">Pastikan data Anda sesuai dengan KTP untuk mempermudah verifikasi.</p>
                    </div>

                    <form action="backend/update_profil.php" method="POST">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo $user['nama_lengkap']; ?>" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>NIK (Terdaftar)</label>
                                <input type="text" class="form-control" value="<?php echo $user['nik'] ?? 'Not Set'; ?>" readonly style="background: #f1f5f9; cursor: not-allowed;">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" value="<?php echo $user['username']; ?>" readonly style="background: #f1f5f9; cursor: not-allowed;">
                            </div>
                        </div>

                        <div style="margin: 40px 0 20px 0; border-top: 1px solid var(--border); padding-top: 30px;">
                            <h3 style="font-size: 1.1rem; margin-bottom: 5px;">Ubah Keamanan</h3>
                            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 20px;">Ganti password secara berkala untuk menjaga keamanan akun.</p>
                        </div>

                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password_baru" class="form-control" placeholder="Isi hanya jika ingin mengganti password">
                        </div>

                        <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-check-circle"></i> Perbarui Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
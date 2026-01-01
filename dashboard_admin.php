<?php
session_start();
include 'koneksi.php';

// 1. Proteksi Halaman Admin
if (!isset($_SESSION['status']) || $_SESSION['role'] != "admin") {
    header("location:login.php?pesan=bukan_admin");
    exit();
}

// 2. Ambil Statistik (Tetap dari tabel pengajuan)
$total_laporan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengajuan"));
$pending = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status='pending'"));
$proses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status='proses'"));
$selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status='selesai'"));

// 3. Query Laporan Terbaru (SUDAH DISESUAIKAN KE TABEL users)
$sql_laporan = "SELECT p.*, u.nama_lengkap 
                FROM pengajuan p 
                JOIN users u ON p.id_user = u.id_user 
                WHERE p.status = 'pending' 
                ORDER BY p.tanggal_input DESC LIMIT 5";

$laporan_baru = mysqli_query($koneksi, $sql_laporan);

// Cek jika query gagal untuk debugging
if (!$laporan_baru) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel | PortalDesa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body style="background-color: #f1f5f9;">

    <?php include 'sidebar_admin.php'; ?>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Administrator / <span style="color: var(--primary);">Dashboard</span></div>
            <div class="user-nav">
                <span style="font-weight: 600;">Admin Desa</span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=1e293b&color=fff" style="width: 35px; border-radius: 8px;">
            </div>
        </header>

        <section class="welcome">
            <h1>Statistik Pelayanan</h1>
            <p style="color: var(--text-muted);">Memantau aduan warga dari tabel <b>users</b> dan <b>pengajuan</b>.</p>
        </section>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon-circle" style="background: #e0f2fe; color: #0ea5e9;"><i class="fas fa-inbox"></i></div>
                <h2><?php echo $total_laporan; ?></h2>
                <p>Total Masuk</p>
            </div>
            <div class="stat-card">
                <div class="icon-circle" style="background: #fff7ed; color: #f97316;"><i class="fas fa-clock"></i></div>
                <h2><?php echo $pending; ?></h2>
                <p>Belum Verifikasi</p>
            </div>
            <div class="stat-card">
                <div class="icon-circle" style="background: #eef2ff; color: var(--primary);"><i class="fas fa-spinner fa-spin"></i></div>
                <h2><?php echo $proses; ?></h2>
                <p>Dalam Pengerjaan</p>
            </div>
            <div class="stat-card">
                <div class="icon-circle" style="background: #f0fdf4; color: #22c55e;"><i class="fas fa-check-double"></i></div>
                <h2><?php echo $selesai; ?></h2>
                <p>Selesai</p>
            </div>
        </div>

        <h2 class="section-title">Laporan Perlu Tindakan</h2>
        <div class="card-table">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Pelapor</th>
                        <th>Judul Aduan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($laporan_baru) > 0) : ?>
                        <?php while($row = mysqli_fetch_assoc($laporan_baru)): ?>
                        <tr>
                            <td style="font-weight: 600;"><?php echo $row['nama_lengkap']; ?></td>
                            <td><?php echo $row['judul']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['tanggal_input'])); ?></td>
                            <td>
                                <a href="proses_laporan_admin.php?id=<?php echo $row['id_pengajuan']; ?>" class="btn-detail" style="background: var(--primary); color: white; padding: 5px 15px; text-decoration: none; border-radius: 5px; font-size: 0.8rem;">
                                    Verifikasi
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada laporan pending saat ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
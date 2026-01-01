<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya Petugas yang bisa akses
if (!isset($_SESSION['status']) || $_SESSION['role'] != "petugas") {
    header("location:login.php?pesan=bukan_petugas");
    exit();
}

// Statistik Laporan untuk Petugas
$jml_pending = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengajuan WHERE status='pending'"))['total'];
$jml_proses  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengajuan WHERE status='proses'"))['total'];
$jml_selesai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengajuan WHERE status='selesai'"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas | Portal Desa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <?php include 'sidebar_petugas.php'; ?>

   <?php include 'sidebar_petugas.php'; ?>

    <main class="main">
        <header style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <div style="font-weight: 500; color: #64748b;">
                Petugas / <span style="color: #4f46e5;">Dashboard</span>
            </div>
            <div style="font-weight: 600;">Halo, <?= $_SESSION['nama_lengkap']; ?></div>
        </header>

        <section class="welcome">
            <h1>Panel Kerja Petugas</h1>
            <p>Pantau aduan warga secara real-time.</p>
        </section>

        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
            <div class="card-stat" style="background: #fff; padding: 20px; border-radius: 12px; border-left: 5px solid #ef4444; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 1.5rem;"></i>
                <h3 style="margin-top: 10px;"><?= $jml_pending; ?></h3>
                <p style="color: #64748b; font-size: 0.9rem;">Menunggu Verifikasi</p>
            </div>
            
            <div class="card-stat" style="background: #fff; padding: 20px; border-radius: 12px; border-left: 5px solid #f59e0b; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <i class="fas fa-sync-alt" style="color: #f59e0b; font-size: 1.5rem;"></i>
                <h3 style="margin-top: 10px;"><?= $jml_proses; ?></h3>
                <p style="color: #64748b; font-size: 0.9rem;">Sedang Diproses</p>
            </div>

            <div class="card-stat" style="background: #fff; padding: 20px; border-radius: 12px; border-left: 5px solid #10b981; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <i class="fas fa-check-double" style="color: #10b981; font-size: 1.5rem;"></i>
                <h3 style="margin-top: 10px;"><?= $jml_selesai; ?></h3>
                <p style="color: #64748b; font-size: 0.9rem;">Selesai Dikerjakan</p>
            </div>
        </div>

        <div class="card-table" style="margin-top: 30px; padding: 20px;">
            <h3 style="margin-bottom: 15px;">Antrean Laporan Terbaru</h3>
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_list = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status != 'selesai' ORDER BY tanggal_input DESC LIMIT 5");
                    while($row = mysqli_fetch_assoc($query_list)):
                    ?>
                    <tr>
                        <td><?= $row['judul']; ?></td>
                        <td><?= $row['kategori']; ?></td>
                        <td>
                            <span class="badge" style="background: <?= ($row['status'] == 'pending' ? '#fee2e2' : '#fef3c7'); ?>; color: <?= ($row['status'] == 'pending' ? '#ef4444' : '#d97706'); ?>; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem;">
                                <?= ucfirst($row['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="kelola_laporan.php" class="btn-detail" style="font-size: 0.8rem; text-decoration: none; color: #4f46e5;">Tindak Lanjut <i class="fas fa-arrow-right"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
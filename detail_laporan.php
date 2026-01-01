<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['role'] != "masyarakat") {
    header("location:login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$id_laporan = mysqli_real_escape_string($koneksi, $_GET['id']);

$query = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id_pengajuan = '$id_laporan' AND id_user = '$id_user'");
$data = mysqli_fetch_assoc($query);

if (!$data) { die("Laporan tidak ditemukan."); }

$s = $data['status'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Laporan #<?php echo $id_laporan; ?> | PortalDesa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

    <?php include 'sidebar_masyarakat.php'; ?>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">
                <a href="riwayat_laporan.php">Riwayat</a> / Detail Laporan
            </div>
            <div class="user-nav">
                <span class="user-name"><?php echo $_SESSION['nama_lengkap']; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['nama_lengkap']); ?>&background=4f46e5&color=fff" style="width: 35px; border-radius: 8px;">
            </div>
        </header>

        <div class="status-banner">
            <div>
                <span class="info-label">Status Saat Ini</span>
                <h3 style="color: var(--primary);"><?php echo strtoupper($s); ?></h3>
            </div>
            <div style="text-align: right;">
                <span class="info-label">Nomor Tiket</span>
                <p style="font-weight: 700;">#LP-<?php echo str_pad($data['id_pengajuan'], 5, "0", STR_PAD_LEFT); ?></p>
            </div>
        </div>

        <div class="detail-container">
            <div class="main-info">
                <div class="content-card">
                    <span class="info-label">Judul Laporan</span>
                    <h2 style="margin-bottom: 20px;"><?php echo $data['judul']; ?></h2>
                    
                    <span class="info-label">Deskripsi Lengkap</span>
                    <p style="line-height: 1.8; color: #475569;"><?php echo nl2br($data['deskripsi']); ?></p>
                </div>

                <div class="content-card">
                    <span class="info-label">Tanggapan Petugas</span>
                    <div style="padding: 15px; background: var(--bg-main); border-radius: 12px; border-left: 4px solid var(--primary);">
                        <p style="font-style: italic; color: var(--text-main);">
                            <?php echo $data['feedback_petugas'] ?? "Belum ada tanggapan resmi dari petugas lapangan. Laporan Anda sedang dalam antrean verifikasi."; ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="side-info">
                <div class="content-card">
                    <span class="info-label">Progres Laporan</span>
                    <div class="timeline-wrapper">
                        <div class="timeline-step">
                            <div class="step-icon active"><i class="fas fa-check"></i></div>
                            <div class="step-content">
                                <h4>Laporan Terkirim</h4>
                                <p><?php echo date('d M Y', strtotime($data['tanggal_input'])); ?></p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="step-icon <?php echo ($s == 'proses' || $s == 'selesai') ? 'active' : ''; ?>">
                                <i class="fas <?php echo ($s == 'proses' || $s == 'selesai') ? 'fa-check' : 'fa-clock'; ?>"></i>
                            </div>
                            <div class="step-content">
                                <h4>Verifikasi & Proses</h4>
                                <p><?php echo ($s == 'proses') ? "Sedang dikerjakan" : "Menunggu"; ?></p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="step-icon <?php echo ($s == 'selesai') ? 'active' : ''; ?>">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <div class="step-content">
                                <h4>Selesai</h4>
                                <p><?php echo ($s == 'selesai') ? "Sudah diperbaiki" : "-"; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-card photo-display">
                    <span class="info-label">Foto Lampiran</span>
                    <img src="assets/img/laporan/<?php echo $data['foto']; ?>" alt="Bukti Laporan">
                </div>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <a href="riwayat_laporan.php" class="btn-detail" style="display: inline-block;">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Laporan
            </a>
        </div>
    </main>
</body>
</html>
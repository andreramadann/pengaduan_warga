<?php
session_start();
include 'koneksi.php';

// Proteksi Halaman Admin
// Izinkan Admin DAN Petugas
if (!isset($_SESSION['status']) || ($_SESSION['role'] != "admin" && $_SESSION['role'] != "petugas")) {
    header("location:login.php");
    exit();
}

// Ambil filter status
$filter = isset($_GET['status']) ? $_GET['status'] : '';

// Query JOIN ke tabel users
$sql = "SELECT p.*, u.nama_lengkap 
        FROM pengajuan p 
        JOIN users u ON p.id_user = u.id_user";

if ($filter != '') {
    $sql .= " WHERE p.status = '" . mysqli_real_escape_string($koneksi, $filter) . "'";
}

$sql .= " ORDER BY p.tanggal_input DESC";
$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Laporan | Admin Desa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

    <?php include 'sidebar_admin.php'; ?>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Manajemen / <span style="color: var(--primary);">Semua Laporan</span></div>
            <div class="user-nav">
                <span class="user-name">Admin Pusat</span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=1e293b&color=fff" style="width: 35px; border-radius: 8px;">
            </div>
        </header>

        <section class="welcome">
            <h1>Daftar Laporan Masuk</h1>
            <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'update_berhasil'): ?>
        <div style="background: #dcfce7; color: #15803d; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #bbf7d0; font-size: 0.9rem;">
        <i class="fas fa-check-circle"></i> Berhasil! Status laporan dan tanggapan telah diperbarui.
    </div>
<?php endif; ?>
            <p style="color: var(--text-muted);">Kelola dan verifikasi aduan masyarakat dengan mudah.</p>   
        </section>

        <div class="filter-wrapper">
            <a href="kelola_laporan.php" class="filter-btn <?php echo $filter == '' ? 'active' : ''; ?>">
                <i class="fas fa-list" style="margin-right: 8px;"></i> Semua
            </a>
            <a href="kelola_laporan.php?status=pending" class="filter-btn <?php echo $filter == 'pending' ? 'active' : ''; ?>">
                Pending
            </a>
            <a href="kelola_laporan.php?status=proses" class="filter-btn <?php echo $filter == 'proses' ? 'active' : ''; ?>">
                Diproses
            </a>
            <a href="kelola_laporan.php?status=selesai" class="filter-btn <?php echo $filter == 'selesai' ? 'active' : ''; ?>">
                Selesai
            </a>
        </div>

        <div class="card-table">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Tgl. Lapor</th>
                        <th>Nama Pelapor</th>
                        <th>Judul Aduan</th>
                        <th>Status</th>
                        <th style="text-align: right;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($row['tanggal_input'])); ?></td>
                            <td><strong><?php echo $row['nama_lengkap']; ?></strong></td>
                            <td><?php echo $row['judul']; ?></td>
                            <td>
                                <span class="badge badge-<?php echo $row['status']; ?>">
                                    <?php echo ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="proses_laporan_admin.php?id=<?php echo $row['id_pengajuan']; ?>" class="btn-action">
                                    <i class="fas fa-search"></i> Periksa
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-folder-open fa-2x" style="display:block; margin-bottom:10px;"></i>
                                Tidak ada laporan dalam kategori ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['role'] != "masyarakat") {
    header("location:login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$nama_user = $_SESSION['nama_lengkap'];

// Ambil data laporan khusus milik user yang sedang login
$query = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id_user = '$id_user' ORDER BY tanggal_input DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Laporan | Portal Desa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        /* Tambahan style khusus untuk tabel riwayat */
        .card-table {
            background: white;
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            text-align: left;
            padding: 15px;
            background: #f8fafc;
            color: #64748b;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #f1f5f9;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .img-thumbnail-laporan {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .img-thumbnail-laporan:hover { opacity: 0.8; }

        /* Status Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-pending { background: #fff7ed; color: #f97316; }   /* Oranye */
        .badge-proses { background: #eef2ff; color: #4f46e5; }    /* Biru */
        .badge-selesai { background: #f0fdf4; color: #22c55e; }   /* Hijau */

        .btn-view {
            padding: 8px 12px;
            background: #f1f5f9;
            color: #475569;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .btn-view:hover { background: #e2e8f0; color: #1e293b; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-landmark-dome"></i>
            <span>PortalDesa.</span>
        </div>
        <div class="nav-group">
            <span class="nav-label">Menu Utama</span>
            <a href="dashboard_masyarakat.php" class="nav-item"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="form_pengajuan.php" class="nav-item"><i class="fas fa-paper-plane"></i> Buat Laporan</a>
            <a href="riwayat_laporan.php" class="nav-item active"><i class="fas fa-history"></i> Riwayat Laporan</a>
        </div>
        </aside>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Layanan Publik / Riwayat Laporan</div>
            <div class="user-nav">
                <span style="font-weight: 600;"><?php echo $nama_user; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($nama_user); ?>&background=4f46e5&color=fff" style="width: 35px; border-radius: 8px;">
            </div>
        </header>

        <section class="welcome">
            <h1 style="font-size: 1.8rem;">Daftar Laporan Anda</h1>
            <p style="color: var(--text-muted); margin-bottom: 30px;">Pantau status perbaikan fasilitas yang telah Anda ajukan.</p>
        </section>

        <div class="card-table">
            <?php if (mysqli_num_rows($query) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Tanggal</th>
                            <th>Judul Laporan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td>
                                    <img src="assets/img/laporan/<?php echo $data['foto']; ?>" class="img-thumbnail-laporan" alt="Foto Laporan">
                                </td>
                                <td>
                                    <span style="color: #64748b; font-size: 0.85rem;">
                                        <?php echo date('d/m/Y', strtotime($data['tanggal_input'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 600;"><?php echo $data['judul']; ?></div>
                                    <small style="color: #94a3b8;"><?php echo substr($data['deskripsi'], 0, 50); ?>...</small>
                                </td>
                                <td>
                                    <?php 
                                        $s = $data['status'];
                                        $badge_class = "badge-pending";
                                        if($s == 'proses') $badge_class = "badge-proses";
                                        if($s == 'selesai') $badge_class = "badge-selesai";
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo $s; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detail_laporan.php?id=<?php echo $data['id_pengajuan']; ?>" class="btn-view">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-folder-open fa-3x" style="color: #e2e8f0; margin-bottom: 15px;"></i>
                    <p style="color: #94a3b8;">Belum ada laporan yang dikirimkan.</p>
                    <a href="form_pengajuan.php" style="color: #4f46e5; font-weight: 600; text-decoration: none;">Buat laporan sekarang</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
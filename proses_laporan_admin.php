<?php
session_start();
include 'koneksi.php';

// Proteksi Halaman Admin
if (!isset($_SESSION['status']) || $_SESSION['role'] != "admin") {
    header("location:login.php?pesan=bukan_admin");
    exit();
}

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) { header("location:kelola_laporan.php"); exit(); }

// Query detail laporan JOIN ke tabel users
$query = mysqli_query($koneksi, "SELECT p.*, u.nama_lengkap, u.nik 
                                FROM pengajuan p 
                                JOIN users u ON p.id_user = u.id_user 
                                WHERE p.id_pengajuan = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) { die("Data tidak ditemukan."); }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Laporan | Admin Desa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

    <?php include 'sidebar_admin.php'; ?>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Manajemen / <a href="kelola_laporan.php">Daftar Laporan</a> / <span style="color: var(--primary);">Detail</span></div>
        </header>

        <section class="welcome">
            <h1>Verifikasi Laporan</h1>
            <p style="color: var(--text-muted);">Tinjau bukti foto dan tentukan langkah selanjutnya.</p>
        </section>

        <div class="profile-container"> <div class="profile-sidebar">
                <div class="account-form" style="padding: 20px;">
                    <h3 style="margin-bottom: 15px; font-size: 1rem;">Bukti Foto</h3>
                    <?php if ($data['foto']): ?>
                        <img src="assets/img/laporan/<?php echo $data['foto']; ?>" style="width: 100%; border-radius: 12px; border: 1px solid var(--border);">
                    <?php else: ?>
                        <div style="background: #f1f5f9; padding: 40px; text-align: center; border-radius: 12px; color: #94a3b8;">
                            <i class="fas fa-image-slash fa-2x"></i><br>Tidak ada foto
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="profile-main">
                <div class="account-form">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                        <div>
                            <span class="badge badge-<?php echo $data['status']; ?>"><?php echo $data['status']; ?></span>
                            <h2 style="margin-top: 10px;"><?php echo $data['judul']; ?></h2>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">Dilaporkan oleh: <strong><?php echo $data['nama_lengkap']; ?></strong> (NIK: <?php echo $data['nik']; ?>)</p>
                        </div>
                        <div style="text-align: right; color: var(--text-muted); font-size: 0.8rem;">
                            <i class="fas fa-calendar-alt"></i> <?php echo date('d F Y', strtotime($data['tanggal_input'])); ?>
                        </div>
                    </div>

                    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
                        <h4 style="margin-bottom: 10px; color: var(--text-main);">Deskripsi Laporan:</h4>
                        <p style="line-height: 1.6; color: #475569;"><?php echo nl2br($data['deskripsi']); ?></p>
                    </div>

                    <hr style="border: 0; border-top: 1px solid var(--border); margin: 30px 0;">

                    <form action="backend/update_status_laporan.php" method="POST">
                     <input type="hidden" name="id_pengajuan" value="<?php echo $data['id_pengajuan']; ?>">
    
                        <div class="form-group">
                            <label>Tanggapan Admin (Feedback ke Warga)</label>
                            <textarea name="feedback" class="form-control" rows="4" placeholder="Berikan penjelasan atau perkembangan aduan ini..." required><?php echo $data['feedback_petugas'] ?? ''; ?></textarea>
                        </div>

                        <div class="form-row" style="margin-top: 20px;">
                            <div class="form-group">
                                <label>Ubah Status Laporan</label>
                                <select name="status" class="form-control" required>
                                    <option value="pending" <?php if($data['status'] == 'pending') echo 'selected'; ?>>Pending (Tunda)</option>
                                    <option value="proses" <?php if($data['status'] == 'proses') echo 'selected'; ?>>Proses (Dikerjakan)</option>
                                    <option value="selesai" <?php if($data['status'] == 'selesai') echo 'selected'; ?>>Selesai (Ditutup)</option>
                                </select>
                            </div>
                            <div class="form-group" style="display: flex; align-items: flex-end;">
                                <button type="submit" class="btn-primary" style="width: 100%; height: 45px;">
                                    <i class="fas fa-save"></i> Perbarui Status Laporan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
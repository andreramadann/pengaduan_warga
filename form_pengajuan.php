<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['role'] != "masyarakat") {
    header("location:login.php");
    exit();
}
include 'koneksi.php';
$nama_user = $_SESSION['nama_lengkap'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Laporan | Portal Desa</title>
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
            <a href="dashboard_masyarakat.php" class="nav-item"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="form_pengajuan.php" class="nav-item active"><i class="fas fa-paper-plane"></i> Buat Laporan</a>
            <a href="riwayat_laporan.php" class="nav-item"><i class="fas fa-history"></i> Riwayat Laporan</a>
        </div>
        </aside>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Layanan Publik / <span style="color: var(--primary);">Buat Laporan</span></div>
            <div class="user-nav">
                <span class="user-name"><?php echo $nama_user; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($nama_user); ?>&background=4f46e5&color=fff" alt="avatar" style="width: 35px; border-radius: 8px;">
            </div>
        </header>

        <section class="welcome">
            <h1 style="font-size: 1.8rem;">Ajukan Perbaikan Fasilitas</h1>
            <p style="color: var(--text-muted); margin-bottom: 30px;">Laporan Anda akan langsung masuk ke sistem verifikasi perangkat desa.</p>
        </section>

        <div class="card-form">
            <form action="backend/proses_pengajuan.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="judul">Judul Laporan</label>
                    <input type="text" id="judul" name="judul" class="form-control" placeholder="Contoh: Perbaikan Aspal Jalan Berlubang" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Detail Kerusakan & Lokasi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" placeholder="Sebutkan lokasi detail (RT/RW) dan kronologi kerusakan..." required></textarea>
                </div>

                <div class="form-group">
                    <label>Lampiran Foto Bukti</label>
                    <div class="upload-dropzone" onclick="document.getElementById('foto').click()">
                        <i class="fas fa-image fa-3x"></i>
                        <p style="font-size: 0.9rem; color: var(--text-muted);">Klik untuk memilih foto kerusakan</p>
                        <input type="file" name="foto" id="foto" hidden accept="image/*" required onchange="previewImg()">
                    </div>
                    <div id="preview-box" style="display: none; text-align: center;">
                        <img id="img-preview" src="#" alt="Preview Gambar">
                        <p style="font-size: 0.8rem; color: var(--primary); margin-top: 5px; cursor: pointer;" onclick="document.getElementById('foto').click()">Ganti Foto</p>
                    </div>
                </div>

                <div style="margin-top: 40px; display: flex; gap: 15px;">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Laporan
                    </button>
                    <a href="dashboard_masyarakat.php" style="text-decoration: none; padding: 14px 20px; color: var(--text-muted); font-weight: 600;">Batal</a>
                </div>
            </form>
        </div>
    </main>

    <script>
        function previewImg() {
            const foto = document.querySelector('#foto');
            const imgPreview = document.querySelector('#img-preview');
            const previewBox = document.querySelector('#preview-box');
            const dropzone = document.querySelector('.upload-dropzone');

            previewBox.style.display = 'block';
            dropzone.style.display = 'none';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(foto.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
</body>
</html>
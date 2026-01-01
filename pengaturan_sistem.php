<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['role'] != "admin") {
    header("location:login.php"); exit();
}

// Ambil data sistem dari ID 1
$query = mysqli_query($koneksi, "SELECT * FROM pengaturan_sistem WHERE id = 1");
$sys = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Sistem | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <?php include 'sidebar_admin.php'; ?>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Admin / <span style="color: var(--primary);">Pengaturan Sistem</span></div>
        </header>

        <section class="welcome">
            <h1>Konfigurasi Portal Desa</h1>
            <p style="color: var(--text-muted);">Ubah informasi identitas desa yang tampil di publik.</p>
        </section>

        <div class="card-table" style="padding: 30px; max-width: 800px;">
            <form action="backend/update_sistem.php" method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label style="font-weight: bold;">Nama Aplikasi</label>
                        <input type="text" name="nama_aplikasi" class="form-control" value="<?= $sys['nama_aplikasi'] ?>" required style="width:100%; padding:10px; margin-top:5px; border-radius:8px; border:1px solid #ddd;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold;">Nama Desa</label>
                        <input type="text" name="nama_desa" class="form-control" value="<?= $sys['nama_desa'] ?>" required style="width:100%; padding:10px; margin-top:5px; border-radius:8px; border:1px solid #ddd;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold;">Kontak/WhatsApp</label>
                        <input type="text" name="kontak_desa" class="form-control" value="<?= $sys['kontak_desa'] ?>" style="width:100%; padding:10px; margin-top:5px; border-radius:8px; border:1px solid #ddd;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold;">Email Instansi</label>
                        <input type="email" name="email_desa" class="form-control" value="<?= $sys['email_desa'] ?>" style="width:100%; padding:10px; margin-top:5px; border-radius:8px; border:1px solid #ddd;">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <label style="font-weight: bold;">Alamat Lengkap</label>
                    <textarea name="alamat_desa" class="form-control" rows="3" style="width:100%; padding:10px; margin-top:5px; border-radius:8px; border:1px solid #ddd;"><?= $sys['alamat_desa'] ?></textarea>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 30px; width: 100%; padding: 12px; cursor: pointer;">
                    <i class="fas fa-save"></i> Perbarui Informasi Desa
                </button>
            </form>
        </div>
    </main>
</body>
</html>
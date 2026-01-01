<?php
session_start();
include 'koneksi.php';

// Proteksi: Pastikan hanya admin yang bisa akses
if (!isset($_SESSION['status']) || $_SESSION['role'] != "admin") {
    header("location:login.php");
    exit();
}

// Ambil data detail admin berdasarkan session ID
$id_admin = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_admin'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <?php include 'sidebar_admin.php'; ?>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Admin / <span style="color: var(--primary);">Profil Saya</span></div>
        </header>

        <section class="welcome">
            <h1>Profil Pengguna</h1>
            <p style="color: var(--text-muted);">Informasi akun administrator Anda.</p>
        </section>

        <div class="profile-container" style="display: flex; gap: 30px; margin-top: 20px;">
            
            <div class="card-table" style="flex: 1; padding: 30px; text-align: center; height: fit-content;">
                <img src="https://ui-avatars.com/api/?name=<?= $data['nama_lengkap'] ?>&background=4f46e5&color=fff&size=128" 
                     style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #f1f5f9; margin-bottom: 15px;">
                <h2 style="margin-bottom: 5px;"><?= $data['nama_lengkap'] ?></h2>
                <span class="badge" style="background: #e0e7ff; color: #4338ca; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                    <i class="fas fa-shield-alt"></i> ADMINISTRATOR
                </span>
                
                <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">
                
                <div style="text-align: left; font-size: 0.9rem; color: #64748b;">
                    <p style="margin-bottom: 10px;"><i class="fas fa-user-circle" style="width: 25px;"></i> <?= $data['username'] ?></p>
                    <p><i class="fas fa-id-card" style="width: 25px;"></i> NIK: <?= $data['nik'] ?: '-' ?></p>
                </div>
            </div>

            <div style="flex: 2;">
                <div class="card-table" style="padding: 30px;">
                    <h3 style="margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">Opsi Akun</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <a href="pengaturan.php" style="text-decoration: none; color: inherit;">
                            <div style="padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; transition: 0.3s; background: #fff;" onmouseover="this.style.borderColor='#4f46e5'" onmouseout="this.style.borderColor='#e2e8f0'">
                                <i class="fas fa-user-edit" style="font-size: 1.5rem; color: #4f46e5; margin-bottom: 10px;"></i>
                                <h4 style="margin-bottom: 5px;">Edit Profil</h4>
                                <p style="font-size: 0.8rem; color: #64748b;">Ubah nama, username, atau password.</p>
                            </div>
                        </a>

                        <a href="logout.php" style="text-decoration: none; color: inherit;" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                            <div style="padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; transition: 0.3s; background: #fff;" onmouseover="this.style.borderColor='#ef4444'" onmouseout="this.style.borderColor='#e2e8f0'">
                                <i class="fas fa-sign-out-alt" style="font-size: 1.5rem; color: #ef4444; margin-bottom: 10px;"></i>
                                <h4 style="margin-bottom: 5px;">Keluar</h4>
                                <p style="font-size: 0.8rem; color: #64748b;">Akhiri sesi Anda sekarang.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>
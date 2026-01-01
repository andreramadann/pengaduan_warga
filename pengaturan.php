<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['role'] != "admin") {
    header("location:login.php"); exit();
}

$id_admin = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_admin'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <?php include 'sidebar_admin.php'; ?>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Admin / <a href="profil_admin.php">Profil</a> / Edit</div>
        </header>

        <div class="card-table" style="max-width: 800px; margin: 20px auto; padding: 30px;">
            <h2 style="margin-bottom: 20px;"><i class="fas fa-user-cog"></i> Pengaturan Akun</h2>
            
            <form action="backend/update_pengaturan.php" method="POST" enctype="multipart/form-data">
                <div style="display: flex; gap: 30px; flex-wrap: wrap;">
                    
                    <div style="flex: 1; text-align: center; min-width: 200px;">
                        <label style="font-weight: bold; display: block; margin-bottom: 15px;">Foto Profil</label>
                        <?php 
                        $foto_path = !empty($data['foto']) ? "assets/img/profil/" . $data['foto'] : "https://ui-avatars.com/api/?name=" . $data['nama_lengkap'];
                        ?>
                        <img src="<?= $foto_path ?>" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 3px solid #4f46e5; margin-bottom: 10px;">
                        <input type="file" name="foto" class="form-control" style="font-size: 0.8rem;">
                        <p style="font-size: 0.75rem; color: #64748b; mt-2">Format: JPG, PNG. Max 2MB</p>
                    </div>

                    <div style="flex: 2; min-width: 300px;">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= $data['nama_lengkap'] ?>" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                        </div>

                        <div class="form-group" style="margin-bottom: 15px;">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                        </div>

                        <div style="background: #f1f5f9; padding: 15px; border-radius: 8px; margin-top: 20px;">
                            <label style="font-weight: bold; color: #475569;">Ganti Kata Sandi</label>
                            <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 10px;">Kosongkan jika tidak ingin mengubah password.</p>
                            <input type="password" name="password_baru" class="form-control" placeholder="Password Baru" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                        </div>

                        <button type="submit" name="update" class="btn-primary" style="width: 100%; margin-top: 25px; padding: 12px; cursor: pointer;">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </main>
</body>
</html>
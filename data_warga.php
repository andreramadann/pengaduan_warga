<?php
session_start();
include 'koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['status']) || $_SESSION['role'] != "admin") {
    header("location:login.php"); exit();
}

// 1. Logika Pencarian
$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['cari']);
    // Mencari berdasarkan NIK atau Nama Lengkap
    $sql = "SELECT * FROM users 
            WHERE role = 'masyarakat' 
            AND (nama_lengkap LIKE '%$keyword%' OR nik LIKE '%$keyword%')
            ORDER BY nama_lengkap ASC";
} else {
    $sql = "SELECT * FROM users WHERE role = 'masyarakat' ORDER BY nama_lengkap ASC";
}

$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Warga | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <?php include 'sidebar_admin.php'; ?>

    <main class="main">
        <header class="top-bar">
            <div class="breadcrumb">Admin / <span style="color: var(--primary);">Pencarian Warga</span></div>
        </header>

        <section class="welcome">
            <h1>Manajemen Masyarakat</h1>
            <p style="color: var(--text-muted);">Gunakan NIK atau Nama untuk mencari data warga.</p>
        </section>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; flex-wrap: wrap;">
            <form action="" method="GET" style="display: flex; gap: 10px; flex: 1; max-width: 500px;">
                <input type="text" name="cari" class="form-control" placeholder="Cari Nama atau NIK..." value="<?php echo $keyword; ?>" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; width: 100%;">
                <button type="submit" class="btn-primary" style="padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer;">
                    <i class="fas fa-search"></i>
                </button>
                <?php if($keyword != ""): ?>
                    <a href="data_warga.php" class="btn-detail" style="background: #f1f5f9; color: #64748b; padding: 10px; border-radius: 8px; text-decoration: none;">Reset</a>
                <?php endif; ?>
            </form>

            <a href="tambah_warga.php" class="btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 8px;">
                <i class="fas fa-plus"></i> Tambah Warga
            </a>
        </div>

        <div class="card-table">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($query) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><code><?php echo $row['nik']; ?></code></td>
                            <td><strong><?php echo $row['nama_lengkap']; ?></strong></td>
                            <td><?php echo $row['username']; ?></td>
                            <td style="text-align: center;">
                                <a href="edit_warga.php?id=<?php echo $row['id_user']; ?>" style="color: #f59e0b; margin-right: 15px; text-decoration: none;"><i class="fas fa-edit"></i> Edit</a>
                                <a href="backend/hapus_warga.php?id=<?php echo $row['id_user']; ?>" style="color: #ef4444; text-decoration: none;" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px; color: #94a3b8;">Data warga tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
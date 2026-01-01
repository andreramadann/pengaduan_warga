    <?php
    session_start();
    include 'koneksi.php';

    // Proteksi Admin
    if (!isset($_SESSION['status']) || $_SESSION['role'] != "admin") {
        header("location:login.php"); exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
        $user = mysqli_real_escape_string($koneksi, $_POST['username']);
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (nik, nama_lengkap, username, password, role) VALUES ('$nik', '$nama', '$user', '$pass', 'masyarakat')";
        if (mysqli_query($koneksi, $sql)) {
            header("location:data_warga.php?pesan=tambah_berhasil");
            exit();
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Tambah Warga | Admin</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="assets/css/dashboard.css">
    </head>
    <body>

        <?php include 'sidebar_admin.php'; ?>

        <main class="main">
            <header class="top-bar">
                <div class="breadcrumb">Admin / <a href="data_warga.php">Data Warga</a> / Tambah</div>
            </header>

            <section class="welcome">
                <h1>Tambah Warga Baru</h1>
                <p style="color: var(--text-muted);">Masukkan data NIK dan Nama warga secara manual.</p>
            </section>

            <div class="card-table" style="padding: 30px; max-width: 800px;">
                <form method="POST">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">NIK (16 Digit)</label>
                        <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK..." required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama sesuai KTP..." required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Untuk login warga..." required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Password Sementara</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter..." required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn-primary" style="padding: 10px 25px; border: none; border-radius: 8px; cursor: pointer;">
                            <i class="fas fa-save"></i> Simpan Warga
                        </button>
                        <a href="data_warga.php" class="btn-detail" style="background: #64748b; color: white; text-decoration: none; padding: 10px 25px; border-radius: 8px;">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </body>
    </html>
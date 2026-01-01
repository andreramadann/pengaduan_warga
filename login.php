<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SISFO DESA</title>
    <link rel="stylesheet" href="assets/css/daftar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-page">

    <div class="auth-card">
        <div class="auth-header">
            <i class="fas fa-user-circle"></i>
            <h2>Selamat Datang</h2>
            <p>Silakan masuk ke akun Anda</p>
        </div>

        <form action="backend/cek_login.php" method="POST">
            <div class="form-group">
                <label><i class="fas fa-user"></i> Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="form-group">
    <label><i class="fas fa-users-cog"></i> Masuk Sebagai</label>
    <select name="role" class="form-input" required>
        <option value="masyarakat">Masyarakat</option>
        <option value="petugas">Petugas Desa</option>
        <option value="admin">Administrator</option>
    </select>
</div>
            <button type="submit" class="btn-auth">Masuk ke Sistem</button>
        </form>

        <div class="auth-footer">
            Belum memiliki akun? <a href="register.php">Daftar Sekarang</a>
            <br><br>
            <a href="index.html" style="color: #888;"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>
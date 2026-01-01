<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SISFO DESA</title>
    <link rel="stylesheet" href="assets/css/daftar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-page">

    <div class="auth-card">
        <div class="auth-header">
            <i class="fas fa-user-plus"></i>
            <h2>Registrasi Warga</h2>
            <p>Lengkapi data untuk membuat akun</p>
        </div>

        <form action="backend/proses_register.php" method="POST">
            <div class="form-group">
                <label><i class="fas fa-id-card"></i> NIK (Sesuai KTP)</label>
                <input type="text" name="nik" placeholder="16 Digit NIK" required maxlength="16">
            </div>
            <div class="form-group">
                <label><i class="fas fa-address-book"></i> Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="Nama sesuai KTP" required>
            </div>
            <div class="form-group">
                <label><i class="fas fa-user"></i> Username</label>
                <input type="text" name="username" placeholder="Buat username" required>
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" placeholder="Buat password" required>
            </div>
            <div class="form-group">
        <label><i class="fas fa-user-tag"></i> Daftar Sebagai</label>
        <select name="role" class="form-input" required>
        <option value="masyarakat">Masyarakat</option>
        <option value="petugas">Petugas Desa</option>
    </select>
</div>
            <button type="submit" class="btn-auth">Daftar Sekarang</button>
        </form>

        <div class="auth-footer">
            Sudah memiliki akun? <a href="login.php">Masuk di sini</a>
        </div>
    </div>

    

</body>
</html>
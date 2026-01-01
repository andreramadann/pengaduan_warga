<?php
// Memanggil koneksi.php yang berada di luar folder backend
include '../koneksi.php';

// Menangkap data dari form register.php
$nik           = mysqli_real_escape_string($koneksi, $_POST['nik']);
$nama_lengkap  = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
$username      = mysqli_real_escape_string($koneksi, $_POST['username']);
$password      = $_POST['password']; 
$role          = $_POST['role']; // Menangkap role yang dipilih pengguna

// 1. Validasi: Cek apakah NIK atau Username sudah terdaftar
$cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE nik='$nik' OR username='$username'");

if (mysqli_num_rows($cek_user) > 0) {
    // Jika data sudah ada, berikan peringatan dan kembali ke halaman register
    echo "<script>
            alert('Gagal! NIK atau Username sudah digunakan.');
            window.location='../register.php';
          </script>";
} else {
    // 2. Jika data belum ada, masukkan ke tabel users
    $query = "INSERT INTO users (nik, nama_lengkap, username, password, role) 
              VALUES ('$nik', '$nama_lengkap', '$username', '$password', '$role')";
    
    $simpan = mysqli_query($koneksi, $query);

    if ($simpan) {
        // Berhasil, arahkan ke login.php di luar folder backend
        echo "<script>
                alert('Registrasi Berhasil sebagai " . ucfirst($role) . "! Silakan Login.');
                window.location='../login.php';
              </script>";
    } else {
        // Gagal simpan karena error SQL
        echo "<script>
                alert('Terjadi kesalahan saat menyimpan data.');
                window.location='../register.php';
              </script>";
    }
}
?>
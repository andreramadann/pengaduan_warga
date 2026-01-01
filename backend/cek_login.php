<?php 
session_start();
// Mundur satu folder untuk menemukan koneksi.php
include '../koneksi.php'; 

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if($cek > 0){
    $data = mysqli_fetch_assoc($query);
    $_SESSION['id_user']      = $data['id_user'];
    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
    $_SESSION['role']         = $data['role'];
    $_SESSION['status']       = "login";

    // Penamaan file sekarang menggunakan awalan 'dashboard_'
    if($data['role'] == "admin"){
        header("location:../dashboard_admin.php");
    } else if($data['role'] == "petugas"){
        header("location:../dashboard_petugas.php");
    } else if($data['role'] == "masyarakat"){
        header("location:../dashboard_masyarakat.php");
    }
} else {
    // Gunakan forward slash (/) agar tidak terjadi error path di browser
    echo "<script>alert('Username atau Password Salah!'); window.location='../login.php';</script>";
}
?>
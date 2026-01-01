<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id'"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['nik'];
    $nama = $_POST['nama_lengkap'];
    $user = $_POST['username'];

    $sql = "UPDATE users SET nik='$nik', nama_lengkap='$nama', username='$user' WHERE id_user='$id'";
    if (mysqli_query($koneksi, $sql)) {
        header("location:data_warga.php?pesan=update_berhasil");
    }
}
?>
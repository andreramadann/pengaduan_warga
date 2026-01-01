<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id']) && $_SESSION['role'] == 'admin') {
    $id = $_GET['id'];
    // Opsional: Hapus juga laporan yang dibuat oleh user ini agar tidak error (Cascade)
    mysqli_query($koneksi, "DELETE FROM pengajuan WHERE id_user = '$id'");
    mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id'");
    
    header("location:../data_warga.php?pesan=hapus_sukses");
}
?>
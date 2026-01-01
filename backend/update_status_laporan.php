<?php
session_start();
include '../koneksi.php'; // Pastikan path ke koneksi benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengajuan = $_POST['id_pengajuan'];
    $feedback = mysqli_real_escape_string($koneksi, $_POST['feedback']);
    $status = $_POST['status'];

    // Update status dan feedback
    $query = "UPDATE pengajuan SET 
              status = '$status', 
              feedback_petugas = '$feedback' 
              WHERE id_pengajuan = '$id_pengajuan'";

    if (mysqli_query($koneksi, $query)) {
        // Redirect kembali ke halaman kelola (keluar folder backend)
        header("Location: ../kelola_laporan.php?pesan=sukses");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
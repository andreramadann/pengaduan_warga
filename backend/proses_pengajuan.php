<?php
session_start();
// Pastikan koneksi database benar
include '../koneksi.php';

// Pastikan hanya user login yang bisa akses
if (!isset($_SESSION['status']) || $_SESSION['role'] != "masyarakat") {
    header("location:../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Ambil Data dari Form
    $id_user   = $_SESSION['id_user'];
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tanggal   = date('Y-m-d H:i:s');

    // 2. Konfigurasi Upload Foto
    $nama_file   = $_FILES['foto']['name'];
    $ukuran_file = $_FILES['foto']['size'];
    $error_file  = $_FILES['foto']['error'];
    $tmp_file    = $_FILES['foto']['tmp_name'];

    // Cek apakah ada file yang diupload
    if ($error_file === 4) {
        header("location:../form_pengajuan.php?pesan=foto_kosong");
        exit();
    }

    // Cek ekstensi file (Hanya Gambar)
    $ekstensi_boleh = ['jpg', 'jpeg', 'png'];
    $ekstensi_file  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if (!in_array($ekstensi_file, $ekstensi_boleh)) {
        header("location:../form_pengajuan.php?pesan=ekstensi_salah");
        exit();
    }

    // Cek ukuran file (Maks 2MB)
    if ($ukuran_file > 2048000) {
        header("location:../form_pengajuan.php?pesan=ukuran_besar");
        exit();
    }

    // 3. Penyiapan Folder dan Nama File Baru
    // Gunakan nama unik agar tidak tertimpa (Contoh: 65912384_laporan.jpg)
    $nama_file_baru = time() . '_' . uniqid() . '.' . $ekstensi_file;
    $folder_tujuan  = '../assets/img/laporan/';

    // Cek apakah folder sudah ada, jika belum buat otomatis
    if (!is_dir($folder_tujuan)) {
        mkdir($folder_tujuan, 0777, true);
    }

    // 4. Eksekusi Upload dan Simpan ke Database
    if (move_uploaded_file($tmp_file, $folder_tujuan . $nama_file_baru)) {
        
        $query = "INSERT INTO pengajuan (id_user, judul, deskripsi, foto, tanggal_input, status) 
                  VALUES ('$id_user', '$judul', '$deskripsi', '$nama_file_baru', '$tanggal', 'pending')";
        
        if (mysqli_query($koneksi, $query)) {
            // Berhasil! Lempar ke dashboard dengan pesan sukses
            header("location:../dashboard_masyarakat.php?pesan=laporan_terkirim");
            exit();
        } else {
            // Jika database error, hapus foto yang terlanjur diupload
            unlink($folder_tujuan . $nama_file_baru);
            die("Database Error: " . mysqli_error($koneksi));
        }

    } else {
        // Jika gagal pindah file ke folder
        die("Gagal mengunggah gambar. Pastikan folder assets/img/laporan dapat ditulis (writable).");
    }

} else {
    // Jika akses langsung ke file ini tanpa POST
    header("location:../form_pengajuan.php");
    exit();
}
?>
<?php
session_start();
include '../koneksi.php';

if (isset($_POST['update']) && $_SESSION['role'] == 'admin') {
    $id = $_SESSION['id_user'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $user = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass = $_POST['password_baru'];
    
    // Ambil data lama untuk cek foto lama
    $res = mysqli_query($koneksi, "SELECT foto FROM users WHERE id_user = '$id'");
    $old_data = mysqli_fetch_assoc($res);

    $sql_part = "";

    // 1. Logika Password
    if (!empty($pass)) {
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql_part .= ", password = '$hashed_pass'";
    }

    // 2. Logika Upload Foto
    if ($_FILES['foto']['name'] != "") {
        $filename = time() . "_" . $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $folder = "../assets/img/profil/";

        // Buat folder jika belum ada
        if (!is_dir($folder)) { mkdir($folder, 0777, true); }

        if (move_uploaded_file($tmp_name, $folder . $filename)) {
            $sql_part .= ", foto = '$filename'";
            // Hapus foto lama jika ada
            if ($old_data['foto'] && file_exists($folder . $old_data['foto'])) {
                unlink($folder . $old_data['foto']);
            }
        }
    }

    // 3. Jalankan Query Update
    $query = "UPDATE users SET nama_lengkap = '$nama', username = '$user' $sql_part WHERE id_user = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        header("location:../profil_admin.php?pesan=update_sukses");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
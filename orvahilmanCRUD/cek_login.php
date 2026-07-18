<?php
session_start();
include "koneksi.php";

// Ambil input dari form login dan bersihkan
$username = mysqli_real_escape_string($koneksi, trim($_POST['user']));
$password = $_POST['pass'];

// Enkripsi MD5 sesuai bawaan database
$password_md5 = md5($password);

// Query cek kecocokan username dan password
$query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$username' AND password='$password_md5'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data_login = mysqli_fetch_assoc($query);

    // Set session untuk tanda berhasil login
    $_SESSION['login'] = true;
    $_SESSION['user'] = $username;
    
    // Simpan data foto profil admin ke session
    $_SESSION['foto_admin'] = !empty($data_login['foto']) ? $data_login['foto'] : 'admin_default.png';

    // ALUR DIUBAH: Diarahkan langsung menuju halaman home.php
    header("location: home.php");
    exit();
} else {
    // Jika gagal login, dikembalikan ke halaman awal dengan pesan error
    header("location: index.php?p=Username atau Password salah!");
    exit();
}
?>
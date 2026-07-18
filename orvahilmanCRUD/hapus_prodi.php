<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location:index.php?p=Anda harus login terlebih dahulu");
    exit();
}

include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("location:prodi.php");
    exit();
}

$id_prodi = mysqli_real_escape_string($koneksi, $_GET['id']);

$q = mysqli_query($koneksi, "SELECT * FROM prodi WHERE id_prodi='$id_prodi'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    header("location:prodi.php");
    exit();
}

$kd_prodi = $data['kd_prodi'];

// Validasi Tugas 1: Cek relasi ke tabel mahasiswa
$cek = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE kd_prodi='$kd_prodi'");

if (mysqli_num_rows($cek) > 0) {
    header("location:prodi.php?p=Data tidak dapat dihapus karena masih digunakan oleh mahasiswa");
    exit();
} else {
    $hapus = mysqli_query($koneksi, "DELETE FROM prodi WHERE id_prodi='$id_prodi'");
    if ($hapus) {
        header("location:prodi.php?p=Data prodi berhasil dihapus");
        exit();
    } else {
        header("location:prodi.php?p=Gagal menghapus data prodi");
        exit();
    }
}
?>
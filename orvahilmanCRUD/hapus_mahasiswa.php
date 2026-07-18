<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location:index.php?p=Anda harus login terlebih dahulu");
    exit();
}

include "koneksi.php";

if (!isset($_GET['id'])) {
    header("location:mahasiswa.php");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil info nama file foto dulu untuk dihapus fisiknya dari folder uploads
$q = mysqli_query($koneksi, "SELECT foto FROM mahasiswa WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if ($data) {
    $foto = $data['foto'];
    if (!empty($foto) && $foto != "default.png" && file_exists("uploads/" . $foto)) {
        unlink("uploads/" . $foto);
    }
    
    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id='$id'");
}

header("location:mahasiswa.php");
exit();
?>
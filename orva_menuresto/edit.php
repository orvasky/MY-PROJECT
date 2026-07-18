<?php
include 'dbconnect.php';

$id_menu     = $_GET['id_menu'];
$nama_menu   = $_GET['judul_bk'];
$deskripsi   = $_GET['terbit_bk'];
$id_kategori = $_GET['genre_bk'];
$harga       = $_GET['harga_bk'];

$query = mysqli_query($conn, "UPDATE Menu SET nama_menu='$nama_menu', deskripsi='$deskripsi', harga='$harga', id_kategori='$id_kategori' WHERE id_menu='$id_menu'");

if($query) {
    header("Location: index.php");
} else {
    echo "Gagal mengupdate data menu.";
}
?>
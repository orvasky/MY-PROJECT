<?php
include 'dbconnect.php';

if(isset($_POST['submit'])) {
    $kategori = $_POST['add_genre']; // Menangkap input name="add_genre" dari form modal

    $query = mysqli_query($conn, "INSERT INTO Kategori (kategori) VALUES ('$kategori')");

    if($query) {
        header("Location: index.php");
    } else {
        echo "Gagal menambahkan kategori.";
    }
}
?>
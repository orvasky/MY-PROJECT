<?php
include 'dbconnect.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM Menu WHERE id_menu='$id'");

if($query) {
    header("Location: index.php");
} else {
    echo "Gagal menghapus data menu.";
}
?>
<?php
// Hubungkan ke database orva_menuresto
include 'dbconnect.php';

// Menangkap data yang dikirim dari form index.php
$nama_menu   = $_POST['judul_bk']; 
$deskripsi   = $_POST['deskripsi_menu'];
$id_kategori = $_POST['genre_bk']; 
$harga       = $_POST['harga_bk']; 

// Perbaikan Query: Menyebutkan nama kolom secara spesifik agar datanya masuk ke tempat yang pas
$query = mysqli_query($conn, "INSERT INTO Menu (nama_menu, deskripsi, harga, id_kategori) 
                              VALUES ('$nama_menu', '$deskripsi', '$harga', '$id_kategori')");

if($query) {
    // Jika berhasil, alihkan halaman kembali ke index.php
    header("Location: index.php");
} else {
    // Jika gagal, tampilkan pesan error detail dari database agar tahu rusaknya di mana
    echo "<h3>Gagal menambahkan data menu!</h3>";
    echo "Pesan Error: " . mysqli_error($conn);
}
?>
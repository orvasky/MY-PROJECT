<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu Resto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap4/css/bootstrap.min.css">
    <script src="js/jquery.js"></script>
    <script src="bootstrap4/js/bootstrap.min.js"></script>
</head>
<body>
<?php
// Koneksi database
include 'dbconnect.php';

// Mengambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM Menu WHERE id_menu='$id'");
while($row = mysqli_fetch_assoc($query)) {
?>
<div class="container bg-info" style="padding-top: 20px; padding-bottom: 20px; margin-top: 20px; color: white;">
    <h3>Update Data Resto</h3>
    <form role="form" action="edit.php" method="get">
        <input type="hidden" name="id_menu" value="<?php echo $row['id_menu']; ?>">
        
        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="judul_bk" class="form-control" value="<?php echo $row['nama_menu']; ?>">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="terbit_bk" class="form-control" value="<?php echo $row['deskripsi']; ?>">
        </div>
        <div class="form-group">
            <label>Kategori Menu</label>
            <select class="form-control custom-select-value" name="genre_bk" required>
                <?php
                $query_kat = mysqli_query($conn, "SELECT * FROM Kategori");
                while($k = mysqli_fetch_assoc($query_kat)) {
                    $selected = ($k['id_ketegori'] == $row['id_kategori']) ? "selected" : "";
                    echo "<option value='".$k['id_ketegori']."' $selected>".$k['kategori']."</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="text" name="harga_bk" class="form-control" value="<?php echo $row['harga']; ?>">
        </div>
        
        <div class="d-flex">
            <button type="submit" class="btn btn-success flex-fill mr-2">Update Menu</button>
            <a href="index.php" class="btn btn-secondary flex-fill">Batal</a>
        </div>
    </form>
</div>
<?php 
}
mysqli_close($conn);
?>
</body>
</html>
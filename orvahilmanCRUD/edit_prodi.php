<?php
session_start();
header("Cache-Control: no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location:index.php?p=Anda harus login terlebih dahulu");
    exit();
}

include 'koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location:prodi.php");
    exit();
}

$id_prodi = mysqli_real_escape_string($koneksi, $_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM prodi WHERE id_prodi='$id_prodi'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("location:prodi.php");
    exit();
}

$error = "";

if (isset($_POST['update'])) {
    $kd_prodi = mysqli_real_escape_string($koneksi, trim($_POST['kd_prodi']));
    $nama_prodi = mysqli_real_escape_string($koneksi, trim($_POST['nama_prodi']));

    if (empty($kd_prodi) || empty($nama_prodi)) {
        $error = "Semua field harus diisi!";
    } else {
        // Cek jika kode prodi diubah dan ternyata kembar dengan punya data prodi lain
        $cek = mysqli_query($koneksi, "SELECT * FROM prodi WHERE kd_prodi='$kd_prodi' AND id_prodi != '$id_prodi'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Kode Prodi sudah digunakan oleh program studi lain!";
        } else {
            $update = mysqli_query($koneksi, "UPDATE prodi SET kd_prodi='$kd_prodi', nama_prodi='$nama_prodi' WHERE id_prodi='$id_prodi'");
            if ($update) {
                header("location: prodi.php?p=Data prodi berhasil diperbarui");
                exit();
            } else {
                $error = "Gagal memperbarui data ke database.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Program Studi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navigasi.php'; ?>

    <div id="main" style="max-width: 1000px; margin: 30px auto; padding: 0 20px; box-sizing: border-box;">
        <div class="container" style="border: 1px solid #ccc; padding: 25px; background-color: #fff; border-radius: 4px; font-family: sans-serif;">
            <h2>Edit Program Studi</h2>
            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">

            <?php if (!empty($error)) { ?>
                <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
            <?php } ?>

            <form method="POST">
                <table cellpadding="10" style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr style="border-bottom: 1px solid #eee;">
                        <td width="200">Kode Prodi</td>
                        <td><input type="text" name="kd_prodi" value="<?php echo htmlspecialchars($data['kd_prodi']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Nama Prodi</td>
                        <td><input type="text" name="nama_prodi" value="<?php echo htmlspecialchars($data['nama_prodi']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-top: 20px;">
                            <button type="submit" name="update" class="submit" style="background-color: #008CBA; color: white; padding: 10px 25px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">SIMPAN PERUBAHAN</button>
                            <a href="prodi.php" style="background-color: #f44336; color: white; padding: 10px 25px; text-decoration: none; display: inline-block; border-radius: 4px; font-size: 14px; font-weight: bold; margin-left: 5px;">BATAL</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
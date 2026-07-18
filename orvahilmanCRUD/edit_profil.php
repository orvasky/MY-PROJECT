<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: index.php?p=Silakan login terlebih dahulu!");
    exit();
}

$username_aktif = $_SESSION['user'];
$error = "";

if (isset($_POST['update_profil'])) {
    $nama_foto   = $_FILES['foto_baru']['name'];
    $tmp_foto    = $_FILES['foto_baru']['tmp_name'];
    $ukuran_foto = $_FILES['foto_baru']['size'];
    
    if (!empty($nama_foto)) {
        $ekstensi_boleh = array('png','jpg','jpeg');
        $x = explode('.', $nama_foto);
        $ekstensi = strtolower(end($x));
        
        if (in_array($ekstensi, $ekstensi_boleh) === true) {
            if ($ukuran_foto < 2048000) {
                $foto_baru = "admin_" . $username_aktif . "_" . time() . "." . $ekstensi;
                
                if (move_uploaded_file($tmp_foto, "uploads/" . $foto_baru)) {
                    $query_lama = mysqli_query($koneksi, "SELECT foto FROM pengguna WHERE username='$username_aktif'");
                    $data_lama = mysqli_fetch_assoc($query_lama);
                    
                    if ($data_lama['foto'] != 'admin_default.png' && file_exists("uploads/" . $data_lama['foto'])) {
                        unlink("uploads/" . $data_lama['foto']);
                    }
                    
                    mysqli_query($koneksi, "UPDATE pengguna SET foto='$foto_baru' WHERE username='$username_aktif'");
                    $_SESSION['foto_admin'] = $foto_baru;
                    
                    echo "<script>alert('Foto profil admin berhasil diubah!'); window.location='home.php';</script>";
                    exit();
                }
            } else {
                $error = "Ukuran file terlalu besar! Maksimal 2MB.";
            }
        } else {
            $error = "Ekstensi tidak diperbolehkan! Gunakan format PNG/JPG.";
        }
    } else {
        $error = "Silakan pilih berkas file gambar terlebih dahulu.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navigasi.php"; ?> 

    <div id="main" style="max-width: 800px; margin: 30px auto; padding: 0 20px; box-sizing: border-box;">
        <div class="container" style="border: 1px solid #ccc; padding: 25px; background-color: #fff; border-radius: 4px; font-family: sans-serif;">
            <h2>Pengaturan Profil Admin</h2>
            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
            
            <?php if (!empty($error)) { ?>
                <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
            <?php } ?>
            
            <form action="" method="POST" enctype="multipart/form-data">
                <table cellpadding="10" style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr style="border-bottom: 1px solid #eee;">
                        <td width="200" valign="top">Foto Profil Saat Ini</td>
                        <td align="center" style="padding: 20px 0;">
                            <img src="uploads/<?php echo $_SESSION['foto_admin']; ?>" width="120" height="120" style="border-radius: 50%; object-fit: cover; border: 3px solid #ddd; box-shadow: 0px 0px 5px rgba(0,0,0,0.1);">
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Pilih File Foto Baru</td>
                        <td>
                            <input type="file" name="foto_baru" accept="image/*" required style="padding: 5px; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;"><br>
                            <small style="color: gray; display: inline-block; margin-top: 5px;">*Format wajib: PNG, JPG, atau JPEG (Maksimal file 2MB)</small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-top: 20px;">
                            <button type="submit" name="update_profil" class="submit" style="background-color: #008CBA; color: white; padding: 10px 25px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">SIMPAN PERUBAHAN</button>
                            <a href="home.php" style="background-color: #f44336; color: white; padding: 10px 25px; text-decoration: none; display: inline-block; border-radius: 4px; font-size: 14px; font-weight: bold; margin-left: 5px;">KEMBALI</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
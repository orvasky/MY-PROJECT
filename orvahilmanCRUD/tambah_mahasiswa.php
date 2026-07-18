<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location:index.php?p=Anda harus login terlebih dahulu");
    exit();
}

include "koneksi.php";
$prodi = mysqli_query($koneksi, "SELECT * FROM prodi");
$error = "";

if (isset($_POST['simpan'])) {
    $npm = mysqli_real_escape_string($koneksi, trim($_POST['npm']));
    $nama = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $semester = isset($_POST['semester']) ? $_POST['semester'] : '';
    $kd_prodi = mysqli_real_escape_string($koneksi, $_POST['kd_prodi']);
    $jk = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';

    if (empty($npm) || empty($nama) || empty($kd_prodi) || empty($semester) || empty($jk)) {
        $error = "Semua field bertanda bintang (*) wajib diisi!";
    } else {
        $cek_npm = mysqli_query($koneksi, "SELECT npm FROM mahasiswa WHERE npm = '$npm'");
        if (mysqli_num_rows($cek_npm) > 0) {
            $error = "Gagal: NPM $npm sudah terdaftar di sistem!";
        } else {
            // Foto diset default karena input Choose File dihapus
            $foto_baru = "default.png";

            if (empty($error)) {
                mysqli_query($koneksi, "INSERT INTO mahasiswa (npm, nama, kelas, semester, kd_prodi, jenis_kelamin, foto) 
                VALUES ('$npm', '$nama', '$kelas', '$semester', '$kd_prodi', '$jk', '$foto_baru')");
                header("location:mahasiswa.php");
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navigasi.php"; ?>

    <div id="main" style="max-width: 1000px; margin: 30px auto; padding: 0 20px; box-sizing: border-box;">
        <div class="container" style="border: 1px solid #ccc; padding: 25px; background-color: #fff; border-radius: 4px; font-family: sans-serif;">
            <h2>Tambah Mahasiswa</h2>
            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">

            <?php if (!empty($error)) { ?>
                <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
            <?php } ?>

            <form method="POST">
                <table cellpadding="10" style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr style="border-bottom: 1px solid #eee;">
                        <td width="200">NPM *</td>
                        <td><input type="text" name="npm" value="<?php echo isset($_POST['npm']) ? htmlspecialchars($_POST['npm']) : ''; ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Nama *</td>
                        <td><input type="text" name="nama" value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Kelas</td>
                        <td><input type="text" name="kelas" value="<?php echo isset($_POST['kelas']) ? htmlspecialchars($_POST['kelas']) : ''; ?>" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Semester *</td>
                        <td>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="I" required> I</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="II"> II</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="III"> III</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="IV"> IV</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="V"> V</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="VI"> VI</label>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Prodi *</td>
                        <td>
                            <select name="kd_prodi" required style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="">-- Pilih Prodi --</option>
                                <?php while ($p = mysqli_fetch_assoc($prodi)) { ?>
                                    <option value="<?php echo $p['kd_prodi']; ?>"><?php echo $p['nama_prodi']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Jenis Kelamin *</td>
                        <td>
                            <label style="margin-right: 15px;"><input type="radio" name="jenis_kelamin" value="Laki-laki" required> Laki-laki</label>
                            <label style="margin-right: 15px;"><input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan</label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-top: 20px;">
                            <button type="submit" name="simpan" class="submit" style="background-color: #008CBA; color: white; padding: 10px 25px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">SIMPAN</button>
                            <a href="mahasiswa.php" style="background-color: #f44336; color: white; padding: 10px 25px; text-decoration: none; display: inline-block; border-radius: 4px; font-size: 14px; font-weight: bold; margin-left: 5px;">BATAL</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
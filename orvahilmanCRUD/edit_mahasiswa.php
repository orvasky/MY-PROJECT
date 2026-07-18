<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location:index.php?p=Anda harus login terlebih dahulu");
    exit();
}

include "koneksi.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location:mahasiswa.php");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query_data = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id = '$id'");
$data = mysqli_fetch_assoc($query_data);

if (!$data) {
    header("location:mahasiswa.php");
    exit();
}

$prodi = mysqli_query($koneksi, "SELECT * FROM prodi");
$error = "";

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $semester = isset($_POST['semester']) ? $_POST['semester'] : '';
    $kd_prodi = mysqli_real_escape_string($koneksi, $_POST['kd_prodi']);
    $jk = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';

    if (empty($nama) || empty($kd_prodi) || empty($semester) || empty($jk)) {
        $error = "Semua field bertanda bintang (*) wajib diisi!";
    } else {
        mysqli_query($koneksi, "UPDATE mahasiswa SET nama='$nama', kelas='$kelas', semester='$semester', kd_prodi='$kd_prodi', jenis_kelamin='$jk' WHERE id='$id'");
        header("location:mahasiswa.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navigasi.php"; ?>

    <div id="main" style="max-width: 1000px; margin: 30px auto; padding: 0 20px; box-sizing: border-box;">
        <div class="container" style="border: 1px solid #ccc; padding: 25px; background-color: #fff; border-radius: 4px; font-family: sans-serif;">
            <h2>Edit Data Mahasiswa</h2>
            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">

            <?php if (!empty($error)) { ?>
                <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
            <?php } ?>

            <form method="POST">
                <table cellpadding="10" style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr style="border-bottom: 1px solid #eee; background-color: #f9f9f9;">
                        <td width="200">NPM (Tidak Dapat Diubah)</td>
                        <td><input type="text" value="<?php echo htmlspecialchars($data['npm']); ?>" disabled style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; background-color: #e9ecef; cursor: not-allowed; font-weight: bold;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Nama *</td>
                        <td><input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Kelas</td>
                        <td><input type="text" name="kelas" value="<?php echo htmlspecialchars($data['kelas']); ?>" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Semester *</td>
                        <td>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="I" <?php echo ($data['semester'] == 'I') ? 'checked' : ''; ?> required> I</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="II" <?php echo ($data['semester'] == 'II') ? 'checked' : ''; ?>> II</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="III" <?php echo ($data['semester'] == 'III') ? 'checked' : ''; ?>> III</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="IV" <?php echo ($data['semester'] == 'IV') ? 'checked' : ''; ?>> IV</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="V" <?php echo ($data['semester'] == 'V') ? 'checked' : ''; ?>> V</label>
                            <label style="margin-right: 15px;"><input type="radio" name="semester" value="VI" <?php echo ($data['semester'] == 'VI') ? 'checked' : ''; ?>> VI</label>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Prodi *</td>
                        <td>
                            <select name="kd_prodi" required style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="">-- Pilih Prodi --</option>
                                <?php while ($p = mysqli_fetch_assoc($prodi)) { ?>
                                    <option value="<?php echo $p['kd_prodi']; ?>" <?php echo ($data['kd_prodi'] == $p['kd_prodi']) ? 'selected' : ''; ?>><?php echo $p['nama_prodi']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td>Jenis Kelamin *</td>
                        <td>
                            <?php 
                            $cek_l = ($data['jenis_kelamin'] == "Laki-laki" || strtolower($data['jenis_kelamin']) == "la" || strtolower($data['jenis_kelamin']) == "l") ? 'checked' : '';
                            $cek_p = ($data['jenis_kelamin'] == "Perempuan" || strtolower($data['jenis_kelamin']) == "pe" || strtolower($data['jenis_kelamin']) == "p") ? 'checked' : '';
                            ?>
                            <label style="margin-right: 15px;"><input type="radio" name="jenis_kelamin" value="Laki-laki" <?php echo $cek_l; ?> required> Laki-laki</label>
                            <label style="margin-right: 15px;"><input type="radio" name="jenis_kelamin" value="Perempuan" <?php echo $cek_p; ?>> Perempuan</label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-top: 20px;">
                            <button type="submit" name="update" class="submit" style="background-color: #008CBA; color: white; padding: 10px 25px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">SIMPAN PERUBAHAN</button>
                            <a href="mahasiswa.php" style="background-color: #f44336; color: white; padding: 10px 25px; text-decoration: none; display: inline-block; border-radius: 4px; font-size: 14px; font-weight: bold; margin-left: 5px;">BATAL</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location:index.php?p=Anda harus login terlebih dahulu");
    exit();
}

include "koneksi.php";

$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($koneksi, trim($_POST['keyword']));
}

if ($keyword != "") {
    $query = mysqli_query($koneksi, "SELECT mahasiswa.*, prodi.nama_prodi FROM mahasiswa 
                                    LEFT JOIN prodi ON mahasiswa.kd_prodi = prodi.kd_prodi 
                                    WHERE mahasiswa.npm LIKE '%$keyword%' OR mahasiswa.nama LIKE '%$keyword%' 
                                    ORDER BY mahasiswa.id DESC");
} else {
    $query = mysqli_query($koneksi, "SELECT mahasiswa.*, prodi.nama_prodi FROM mahasiswa 
                                    LEFT JOIN prodi ON mahasiswa.kd_prodi = prodi.kd_prodi 
                                    ORDER BY mahasiswa.id DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "navigasi.php"; ?>

    <div id="main" style="max-width: 1200px; margin: 30px auto; padding: 0 20px; box-sizing: border-box;">
        <div class="container" style="border: 1px solid #ccc; padding: 20px; background-color: #fff; border-radius: 4px;">
            <h2>Data Mahasiswa</h2>
            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">

            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; align-items: center;">
                <a href="tambah_mahasiswa.php" class="btn" style="background-color: #4CAF50; color: white; padding: 8px 15px; text-decoration: none; font-weight: bold; border-radius: 4px; font-size: 14px;">+ Tambah Mahasiswa</a>
                
                <form action="" method="POST" style="display: flex; gap: 5px;">
                    <input type="text" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Cari Nama / NPM..." style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <button type="submit" name="cari" style="padding: 6px 12px; background-color: #008CBA; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Cari</button>
                    <?php if ($keyword != "") { ?>
                        <a href="mahasiswa.php" style="padding: 6px 12px; background-color: #e7e7e7; color: black; text-decoration: none; border-radius: 4px; font-size: 13px; border: 1px solid #ccc;">Reset</a>
                    <?php } ?>
                </form>
            </div>

            <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%; font-family: sans-serif; font-size: 14px;">
                <tr style="background-color: #f2f2f2; text-align: left;">
                    <th style="text-align: center;" width="5%">No</th>
                    <th width="15%">NPM</th>
                    <th width="25%">Nama</th>
                    <th width="10%">Kelas</th>
                    <th style="text-align: center;" width="10%">Semester</th>
                    <th width="20%">Prodi</th>
                    <th style="text-align: center;" width="5%">Gender</th>
                    <th style="text-align: center;" width="10%">Aksi</th>
                </tr>
                <?php
                $no = 1;
                if (mysqli_num_rows($query) > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                        // Logika konversi text agar menampilkan L atau P saja secara akurat
                        $gender_tampil = "-";
                        if ($data['jenis_kelamin'] == "Laki-laki" || strtolower($data['jenis_kelamin']) == "la" || strtolower($data['jenis_kelamin']) == "l") {
                            $gender_tampil = "L";
                        } else if ($data['jenis_kelamin'] == "Perempuan" || strtolower($data['jenis_kelamin']) == "pe" || strtolower($data['jenis_kelamin']) == "p") {
                            $gender_tampil = "P";
                        }
                ?>
                <tr>
                    <td align="center"><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($data['npm']); ?></td>
                    <td><?php echo htmlspecialchars($data['nama']); ?></td>
                    <td><?php echo htmlspecialchars($data['kelas']); ?></td>
                    <td align="center"><?php echo htmlspecialchars($data['semester']); ?></td>
                    <td><?php echo htmlspecialchars($data['nama_prodi']); ?></td>
                    <td align="center"><strong><?php echo $gender_tampil; ?></strong></td>
                    <td align="center">
                        <div style="display: flex; gap: 5px; justify-content: center;">
                            <a href="edit_mahasiswa.php?id=<?php echo $data['id']; ?>" style="background-color: #008CBA; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold;">Edit</a>
                            <a href="hapus_mahasiswa.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data <?php echo $data['nama']; ?>?')" style="background-color: #f44336; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold;">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='8' align='center' style='color: red; font-style: italic; padding: 15px;'>Data mahasiswa tidak ditemukan.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
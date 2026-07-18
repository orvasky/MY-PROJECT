<?php
// Memastikan session sudah aktif sebelum memanggil data user
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigasi</title>
</head>
<body>
    <nav class="navbar" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 20px; background-color: #fd0808; color: white; font-family: sans-serif;">
        
        <div style="display: flex; align-items: center; gap: 25px;">
            <span class="open-slide">       
                <a href="#" onclick="openSlideMenu()" style="display: inline-block; vertical-align: middle;">
                    <svg width="30" height="30">
                        <path d="M0,5 30,5" stroke="#fff" stroke-width="5"/>
                        <path d="M0,14 30,14" stroke="#fff" stroke-width="5"/>
                        <path d="M0,23 30,23" stroke="#fff" stroke-width="5"/>
                    </svg>
                </a>
            </span>

            <ul class="navbar-nav" style="display: flex; list-style: none; margin: 0; padding: 0; align-items: center; gap: 25px;">
                <li><a href="home.php" style="color: white; text-decoration: none;">Home</a></li>
                <li><a href="mahasiswa.php" style="color: white; text-decoration: none;">Mahasiswa</a></li>
                <li><a href="prodi.php" style="color: white; text-decoration: none;">Prodi</a></li>
            </ul>
        </div>

        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="edit_profil.php" style="color: #f8f8f8; text-decoration: none; font-weight: bold;">Edit Profil</a>
            
            <div style="display: flex; align-items: center;">
                <img src="uploads/<?php echo isset($_SESSION['foto_admin']) ? $_SESSION['foto_admin'] : 'admin_default.png'; ?>" 
                     width="30" height="30" style="border-radius: 50%; object-fit: cover; border: 1px solid #4CAF50;">
            </div>

            <div class="logout">
                <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')" style="color: #080000; text-decoration: none; font-weight: bold;">
                    (<?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Admin'; ?>) Logout
                </a>
            </div>
        </div>
    </nav>

    <div id="side-menu" class="side-nav">
        <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
        
        <div style="display: flex; flex-direction: column; align-items: center; padding: 15px 10px; background-color: #222; margin-bottom: 15px; border-bottom: 1px solid #444;">
            <img src="uploads/<?php echo isset($_SESSION['foto_admin']) ? $_SESSION['foto_admin'] : 'admin_default.png'; ?>" 
                 width="65" height="65" style="border-radius: 50%; object-fit: cover; border: 2px solid #4CAF50; margin-bottom: 8px;">
            <span style="color: white; font-size: 14px;">Halo, <strong><?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Admin'; ?></strong></span>
        </div>

        <a href="home.php">Home</a>
        <a href="mahasiswa.php">Mahasiswa</a>
        <a href="prodi.php">Prodi</a>
        <a href="edit_profil.php" style="color: #ff9800;">Edit Profil Admin</a>
        <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')" style="color: #ff4444;">
            (<?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Admin'; ?>) Logout
        </a>
    </div>

    <script>
        function openSlideMenu(){
            document.getElementById('side-menu').style.width = '250px';
        }

        function closeSlideMenu(){
            document.getElementById('side-menu').style.width = '0';
        }
    </script>
</body>
</html>
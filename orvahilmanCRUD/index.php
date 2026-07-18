<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("location:mahasiswa.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Penilaian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin: 100px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; font-family: sans-serif;">Login Admin</h2>
        <hr style="border: 0; border-top: 1px solid #ccc; margin-bottom: 20px;">
        
        <?php if (isset($_GET['p'])) { ?>
            <p style="color: red; font-weight: bold; text-align: center; font-family: sans-serif;"><?php echo htmlspecialchars($_GET['p']); ?></p>
        <?php } ?>
        
        
        <form action="cek_login.php" method="POST" autocomplete="off">
            
            <label style="font-family: sans-serif; font-size: 14px;">Username:</label><br>
            
            <input type="text" name="user" value="" autocomplete="new-password" required style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; background-color: #f0f4f9;"><br>
            
            <label style="font-family: sans-serif; font-size: 14px;">Password:</label><br>
            <input type="password" name="pass" value="" autocomplete="new-password" required style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 25px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; background-color: #f0f4f9;"><br>
            
            <button type="submit" name="login" class="submit" style="width: 100%; padding: 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 16px;">LOGIN</button>
        </form>
    </div>
</body>
</html>
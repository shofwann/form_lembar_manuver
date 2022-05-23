<?php
session_start();

if (isset($_SESSION["username"])) {
	echo "<script>Anda Belum Login</script>";
  header("location:main-dashboard.php");
	exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        
       
    </style>

</head>
<body id="login">
    
    <form class="user" method="post" action="cek_login.php">
        <div class="login">
            <h2>Form Login</h2>
            <div class="input-group">
                <input type="text" name="username" placeholder="Masukkan Username" required="">
                <!-- <span>Username</span> -->
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required="">
                <!-- <span>Password</span> -->
            </div>
            <div class="input-group">
                <input type="submit" name="login" value="Login">
            </div>
        </div>
    </form>
    
</body>
</html>
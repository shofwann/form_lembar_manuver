<?php

if (!isset($_SESSION["username"])) {
	echo "<script>Anda Belum Login</script>";
  header("location:index.php");
	exit;
}

require "functions.php";

$id2= $_SESSION["id"];

if (isset($_POST["submit"]) ){
    if( rubahPass($_POST) > 0){
        echo "<script>alert('Password berhasil dirubah');
        document.location.href = 'home.php?url=inbox';
        </script>";
    } else {
        echo "<script>
        alert('data gagal disubmit'); 
        document.location.href = 'home.php?url=inbox';
        </script>
        "; die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="icons/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="card">
        <div class="card-header">
            Rubah Password
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="" method="post">
                    <table style="width:25%">
                        <tr>
                            <td><div for="curPass">Current Password</div></td>
                            <td><div>:</div></td>
                            <td><input type="password" name="curPass" id="curPass"></td>
                        </tr>
                        <tr>
                            <td><div class="col-4" for="newPass">New Password</div></td>
                            <td>:</td>
                            <td>
                                <input type="password" name="newPass" id="newPass">
                                <input type="checkbox" for="newPass" onclick="showHide2()">Show Password
                            </td>
                        </tr>
                        <tr>
                            <td><div class="col-4" for="ConPass">Confirm Password</div></td>
                            <td>:</td>
                            <td>
                                <input type="password" name="conPass" id="conPass">
                                <input type="checkbox" onclick="showHide3()">Show Password
                            </td>
                        </tr>
                    </table>
               
               
                <div class="row">
                    <div class="col"></div>
                    <div class="col-2"><button type="submit" class="btn" name="submit">Change</button></div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
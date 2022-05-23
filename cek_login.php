<?php
session_start();
require "functions.php";
$user=$_POST['username'];
$pass=$_POST['password'];

$sql=mysqli_query($conn, "SELECT * FROM db_user WHERE username='$user'");
$data = mysqli_fetch_assoc($sql);

if (mysqli_num_rows($sql)>0) {
    if (password_verify($pass, $data["password"])) {

        session_start();
        if($data["level"]=="admin"){
            $_SESSION['username'] = $user;
            $_SESSION["level"] = "admin";
            $_SESSION["id"] = $data["id"];
            header("location:home.php");
            exit;
        }

        elseif ($data["level"]=="initiator") {
            $_SESSION["username"] = $user;
            $_SESSION["level"] = "initiator";
            $_SESSION["id"] = $data["id"];
            header("location:home.php");
            exit;
        }

        elseif ($data["level"]=="amn"){
            $_SESSION['username'] = $user;
            $_SESSION["level"] = "amn";
            $_SESSION["id"] = $data["id"];
            header("location:home.php");
            exit;
        }

        elseif ($data["level"]=="msb"){
            $_SESSION['username'] = $user;
            $_SESSION["level"] = "msb";
            $_SESSION["id"] = $data["id"];
            header("location:home.php");
        }

        elseif ($data["level"]=="dispa"){
            $_SESSION['username'] = $user;
            $_SESSION["level"] = "dispa";
            $_SESSION["id"] = $data["id"];
            header("location:home.php");
        }

        elseif ($data["level"]=="amn_dispa"){
            $_SESSION['username'] = $user;
            $_SESSION["level"] = "amn_dispa";
            $_SESSION["id"] = $data["id"];
            header("location:home.php");
        }

        elseif ($data["level"]=="plh_amn"){
            $_SESSION['username'] = $user;
            $_SESSION["level"] = "plh_amn";
            $_SESSION["id"] = $data["id"];
            header("location:home.php");
        }

        elseif ($data["level"]=="plh_msb"){
            $_SESSION['username'] = $user;
            $_SESSION["level"] = "plh_msb";
            $_SESSION["id"] = $data["id"];
            header("location:home.php");
        }

        elseif ($data["level"]=="plh_amn_dispa"){
            $_SESSION['username'] = $user;
            $_SESSION["level"] = "plh_amn_dispa";
            $_SESSION["id"] = $data["id"];
            header("location:home.php");
        }

        elseif ($data["level"]=="all"){
            $_SESSION['username'] = $user;
            $_SESSION["level"] = "all";
            header("location:home.php");
        }

    }
    else{
        ?>
        <script type="text/javascript">
        alert ('belum terdaftar');
        window.location="index.php";
        </script>    
        <?php
    }
}


   

?>
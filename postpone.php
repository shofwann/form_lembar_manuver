
<?php 

if (!isset($_SESSION["username"])) {
	echo "<script>Anda Belum Login</script>";
  header("location:index.php");
	exit;
}

require "functions.php";

$data = query("SELECT * FROM db_form WHERE id = $_GET[id]")[0];


if( isset($_POST["submit"]) ){

    if( postpone($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                //document.location.href = 'home.php?url=inbox';
                </script>
                ";  
                
    } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                //document.location.href = 'home.php?url=inbox';
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
    <style>
        table {
            border: none;
            width: 40%;
        }
        table tr td {
            border: none;
        }

        td {
            vertical-align: top;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Postpon Task
        </div>
        <div class="container-wrap">

            <div class="container">
            <div class="back">
                <input type="button" value="Kembali" onclick="history.back()" style="">
            </div> <br>
                <form action="" method="post">
                    <table >
                        <tr >
                            <td width="170">Pekerjaan</td>
                            <td>:</td>
                            <td><?= $data['pekerjaan']?></td>
                        </tr>
                        <tr>
                            <td>Tanggal pelaksanaan</td>
                            <td>:</td>
                            <td><?= $dayList[date("D", strtotime($data["date"]))] ?>, <?= date(" d F Y", strtotime($data["date"])); ?></td>
                        </tr>
                        <tr>
                            <td >Alasan Penundaan</td>
                            <td>:</td>
                            <td><textarea name="postpone" id="" cols="50" rows="10" style="padding: 10px" placeholder="Masukkan alasan" <?= ($data["postpone"] != '') ? 'disabled' : '' ?>><?= $data["postpone"]?></textarea></td>
                        </tr>
                    </table>
                   
               
               
                
                    
                 
                    <button type="submit" class="btn" name="submit" id="submit">Postpone</button>

                    
                </form>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script>
        // var id = location.search.split('id=')[1]
        
    </script>
</body>
</html>
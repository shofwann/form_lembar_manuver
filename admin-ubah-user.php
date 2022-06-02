<?php
if (!isset($_SESSION["username"])) {
	echo "<script>Anda Belum Login</script>";
  header("location:index.php");
	exit;
}

require "functions.php";

if( isset($_POST["submit"]) ){

    if( ubahUser($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil dirubah'); 
                document.location.href = 'home.php?url=users';
                </script>
                ";  
                
    } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                document.location.href = 'admin-users.php';
                </script>
                "; die;
                
    }
}

$id = $_GET["id"];

$isiId = mysqli_query($conn, "SELECT * FROM db_user WHERE id = '$id'");

$dataUbah = mysqli_fetch_assoc($isiId);

$sql = mysqli_query($conn,"SELECT * FROM db_user ORDER By id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:16.60,16.60i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body id="page-top"><br>
<div class="card">
    <div class="card-header">
                Change Role
    </div>
    <div class="container-wrap">
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
                <table style="width:50%">
                    <tr>
                        <td>nama</td>
                        <td>:</td>
                        <td><input type="text" name="nama" value="<?= $dataUbah["username"]; ?>"></td>
                    </tr>
                    <tr>
                        <td>level</td>
                        <td>:</td>
                        <td>
                            <select name="level" id="">
                                <option value="">-pilih-</option>
                                <option value="admin" <?php if ($dataUbah["level"]=="admin") echo 'selected="selected"'; ?>>Admin</option>
                                <option value="initiator" <?php if ($dataUbah["level"]=="initiator") echo 'selected="selected"'; ?>>Initiator</option>
                                <option value="amn" <?php if ($dataUbah["level"]=="amn") echo 'selected="selected"'; ?>>AMN</option>
                                <option value="msb" <?php if ($dataUbah["level"]=="msb") echo 'selected="selected"'; ?>>MSB</option>
                                <option value="dispa" <?php if ($dataUbah["level"]=="dispa") echo 'selected="selected"'; ?>>Dispa</option>
                                <option value="amn_dispa" <?php if ($dataUbah["level"]=="amn_dispa") echo 'selected="selected"'; ?>>Amn Dispa</option>
                                <option value="plh_amn" <?php if ($dataUbah["level"]=="plh_amn") echo 'selected="selected"'; ?>>PLH AMN</option>
                                <option value="plh_msb" <?php if ($dataUbah["level"]=="plh_msb") echo 'selected="selected"'; ?>>PLH MSB</option>
                                <option value="plh_amndispa" <?php if ($dataUbah["level"]=="plh_amndispa") echo 'selected="selected"'; ?>>PLH AMN Dispa</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                                    
                        <td colspan="3" ><button type="submit" name="submit">Ubah</button><a href="home.php?url=users" class=""><input type="button" value="batal"></a></td>
                        
                    </tr>
                </table>
            </form>

            <table class="table-bordered" style="width:50%">
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2" style="width: 100px;">Nama</th>
                <th rowspan="2"style="width: 100px;">Level</th>
                <th colspan="2">Action</th>
            </tr>
            <tr>
                <th>Ubah</th>
                <th>Hapus</th>
            </tr>
                <?php $no=1; ?>
                <?php if(mysqli_num_rows($sql) > 0) { ?>
                    <?php while($data = mysqli_fetch_assoc($sql)) { ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $data["username"]; ?></td>
                            <td><?= $data["level"]; ?></td>
                            <td><a href="?url=userUbah&id=<?= $data["id"]; ?>"><i class="fa fa-pencil"></i></a></td>
                            <td><a href="?url=hapus&id=<?= $data["id"]; ?>"><i class="fa fa-trash"></a></td>
                        </tr>
                        <?php $no++; ?>
                    <?php } ?>
                <?php } ?>
                
            </table>
        </div>


    
    </div>
</div>
    
</body>
</html>
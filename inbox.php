<?php 
if (!isset($_SESSION["username"])) {
	echo "<script>Anda Belum Login</script>";
  header("location:index.php");
	exit;
}

require "functions.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO-Inbox</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Inbox
        </div>
        <div class="container-wrap">
            <div class="container" style="">
                <table>
                    <tr>
                        <th style="width:3%;">No</th>
                        <th>Pekerjaan</th>
                        <th>Waktu</th>
                        <th>Installasi</th>
                        <th>lokasi</th>
                        <th>process</th>
                        <th>action</th>
                    </tr>

                    <?php if ($_SESSION["level"]=="initiator") { ?>
                        <?php
                            
                            $datas=query("SELECT * FROM db_form WHERE user = '$_SESSION[username]' AND status = 'initiator'");
                        ?>
                        <?php $i=1;?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= date("d F Y", strtotime($row["date"]));?></td>  
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= "-" ?></td>
                            <td>
                                <a href="?url=updateForm-1&id=<?= $row["id"];?>" id="updateForm-2" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                            
                        </tr>
                        <?php $i++;?>
                        <?php endforeach; ?>
                    <?php } ?>

                    <?php if ($_SESSION["level"]=="amn" || $_SESSION["level"] == "plh_amn") { ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'amn'");
                        ?>
                        <?php $i=1;?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= date("d F Y", strtotime($row["date"]));?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= "-" ?></td>
                            <td>
                                <a href="?url=amnApprove&id=<?= $row["id"]; ?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                                <!-- <a href="remove.php?id=<?= $row["id"];?>" onclick="return confirm('yakin menghapus');">Delete</a>-->
                            </td> 
                        </tr>
                        <?php $i++;?>
                        <?php endforeach; ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'amnUpdate' AND user_amn = '$_SESSION[username]'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= date("d F Y", strtotime($row["date"]));?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= "-" ?></td>
                            <td align="center" valign="center">
                                <a href="?url=amnApprove&id=<?= $row["id"];?>" class="" ><i class="fa fa-pencil-square-o"></i></a>
                                <!-- <a href="remove.php?id=<?= $row["id"];?>" onclick="return confirm('yakin menghapus');">Delete</a> -->
                            </td>
                        </tr>
                        <?php $i++;?>
                        <?php endforeach; ?>   
                    
                    <?php } ?>

                    <?php if ($_SESSION["level"]=="msb" || $_SESSION["level"] == "plh_msb") { ?>
                        <?php
                        $datas=query("SELECT * FROM db_form WHERE status='msb'");
                        ?>
                        <?php $i=1;?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= date("d F Y", strtotime($row["date"]));?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= "-" ?></td>
                            <td align="center" valign="center" >
                                <a href="?url=msbApprove&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        <?php $i++;?>
                        <?php endforeach; ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status='msbUbah' AND user_msb='$_SESSION[username]'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= date("d F Y", strtotime($row["date"]));?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= "-" ?></td>
                            <td align="center" valign="center"> 
                                <a href="?url=msbApprove&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        </tr>
                        <?php $i++;?>
                        <?php endforeach; ?>
                    
                    <?php } ?>

                    <?php if ($_SESSION["level"]=="dispa") { ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE  status = 'dispaAwal'");
                        ?>
                        <?php $i=1;?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= $row["date"];?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=dispaInputAwal&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        <?php $i++;?>
                        <?php endforeach; ?>
                            <!-- untuk percobaan -->
                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'dispaAwalUbah' AND user_dispa_awal = '$_SESSION[username]'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= $row["date"];?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=dispaInputAwal&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        <?php $i++;?>
                        <?php endforeach; ?>


                        <?php
                            $datas=query("SELECT * FROM db_form WHERE  status = 'dispaAkhir'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= $row["date"];?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td> 
                            <a href="?url=dispaInputAkhir&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        <?php $i++;?>
                        <?php endforeach; ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'dispaAkhirUbah' AND user_dispa_akhir = '$_SESSION[username]'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= $row["date"];?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=dispaInputAkhir&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        <?php $i++;?>
                        <?php endforeach; ?> 
                    
                    <?php } ?>

                    <?php if ($_SESSION["level"]=="amn_dispa") { ?>
                        <?php
                        
                        $datas=query("SELECT * FROM db_form WHERE  status = 'amnDispaAwal'");
                        ?>
                        <?php $i=1;?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= $row["date"];?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=amnApproveAwal&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        </tr>
                        <?php $i++;?>
                        <?php endforeach; ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'amnDispaAwalUbah' AND user_amn_dispa_awal= '$_SESSION[username]'");
                        ?>
                        
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= $row["date"];?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=amnApproveAwal&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        </tr>
                        <?php $i++;?>
                        <?php endforeach; ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'amnDispaAkhir'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= $row["date"];?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=amnApproveAkhir&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        </tr>
                        <?php $i++;?>
                        <?php endforeach; ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'amnDispaAkhirUbah' AND user_amn_dispa_akhir= '$_SESSION[username]'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= $row["date"];?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=amnApproveAkhir&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        </tr>
                        <?php $i++;?>
                        <?php endforeach; ?>

                    <?php } ?>

                </table>
            </div>
        </div>
    </div>
    
</body>
</html>
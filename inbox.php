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
<body >
    <div class="card">
        <div class="card-header">
            Inbox
        </div>
        <div class="container-wrap" >
            <?php if ($_SESSION["level"] == 'dispa') {?>
            <div class="container" style="height: 990px;">
            <label class="switch">
                <input type="checkbox" class="check" id="check">
                <span class="slider"></span>
            </label><br><br>

            <p id="verdict"></p>
            <?php } ?>
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
                            <td><?= $row["status"]?></td>
                            <td>
                                <a href="?url=updateForm-1&id=<?= $row["id"];?>"  class="w3-xlarge w3-text-green">
                                <span class="icon text-white-50">
                                    <i class="fa fa-pencil-square-o"></i>
                                </span>
                            </a>
                            </td>
                            
                        </tr>
                        <?php $i++;?>
                        <?php endforeach; ?>

                        <?php
                            $datas = query("SELECT * FROM db_form WHERE user = '$_SESSION[username]' AND status = 'postpone'");
                            foreach($datas as $row):
                        ?>

                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?></td>
                            <td><?= date("d F Y", strtotime($row["date"]));?></td>  
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"] ?></td>
                            <td>
                                <a href="?url=updateForm-1&id=<?= $row["id"];?>" id="updateForm-2" class=""><i class="fa fa-pencil-square-o"></i></a>
                                <a href="?url=hapus&id=<?= $row['id'];?>" onclick="return confirm('anda yakin menghapus <?= $data['pekerjaan']?>?')" >
                                    <span >
                                        <i class="fa fa-trash"></i>
                                    </span>
                                </a>
                            </td>  
                        </tr>
                        <?php
                            $i++;
                            endforeach; 
                        ?>
                    <?php } ?>

                    <?php if ($_SESSION["level"]=="amn" || $_SESSION["level"] == "plh_amn") { ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'amn' ORDER BY DATE(create_date) DESC");
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
                            $datas=query("SELECT * FROM db_form WHERE status = 'amnUbah' AND user_amn = '$_SESSION[username]'");
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
                            <td><?= $row["pekerjaan"];?> <?= ($row['user'] != '') ? '<span style="color:blue;font-weight: bold;">(terencana)</span>' : '<span style="color:red;font-weight: bold;">(emergency)</span>' ?></td>
                            <td><?= $dayList[date("D", strtotime($row["date"]))]?>, <?= date(" d F Y", strtotime($row["date"])); ?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=dispaInputAwal&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                                <a href="?url=postpone&id=<?= $row["id"];?>"><i class="fa fa-times"></i></a> 
                        <?php $i++;?>
                        <?php endforeach; ?>
                            <!-- untuk percobaan -->
                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'dispaAwalUbah' AND user_dispa_awal = '$_SESSION[username]'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?> <?= ($row['user'] != '') ? '<span style="color:blue;font-weight: bold;">(terencana)</span>' : '<span style="color:red;font-weight: bold;">(emergency)</span>' ?></td>
                            <td><?= $dayList[date("D", strtotime($row["date"]))]?>, <?= date(" d F Y", strtotime($row["date"])); ?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=<?= ($row["user"] != '') ? 'dispaInputAwal' : 'update_form_emergency_awal' ?>&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        <?php $i++;?>
                        <?php endforeach; ?>


                        <?php
                            $datas=query("SELECT * FROM db_form WHERE  status = 'dispaAkhir'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?> <?= ($row['user'] != '') ? '<span style="color:blue;font-weight: bold;">(terencana)</span>' : '<span style="color:red;font-weight: bold;">(emergency)</span>' ?></td>
                            <td><?= $dayList[date("D", strtotime($row["date"]))]?>, <?= date(" d F Y", strtotime($row["date"])); ?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td> 
                            <a href="?url=<?= ($row["user"] != '') ? 'dispaInputAkhir' : 'update_form_emergency_akhir' ?>&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        <?php $i++;?>
                        <?php endforeach; ?>

                        <?php
                            $datas=query("SELECT * FROM db_form WHERE status = 'dispaAkhirUbah' AND user_dispa_akhir = '$_SESSION[username]'");
                        ?>
                        <?php foreach($datas as $row):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?= $row["pekerjaan"];?> <?= ($row['user'] != '') ? '<span style="color:blue;font-weight: bold;">(terencana)</span>' : '<span style="color:red;font-weight: bold;">(emergency)</span>' ?></td>
                            <td><?= $dayList[date("D", strtotime($row["date"]))]?>, <?= date(" d F Y", strtotime($row["date"])); ?></td>
                            <td><?= $row["installasi"];?></td>
                            <td><?= $row["lokasi"];?></td>
                            <td><?= $row["status"];?></td>
                            <td>
                                <a href="?url=<?= ($row["user"] != '') ? 'dispaInputAkhir' : 'update_form_emergency_akhir' ?>&id=<?= $row["id"];?>" class=""><i class="fa fa-pencil-square-o"></i></a>
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
                            <td><?= $row["pekerjaan"];?> <?= ($row['user'] != '') ? '<span style="color:blue;font-weight: bold;">(terencana)</span>' : '<span style="color:red;font-weight: bold;">(emergency)</span>' ?></td>
                            <td><?= $dayList[date("D", strtotime($row["date"]))]?>, <?= date(" d F Y", strtotime($row["date"])); ?></td>
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
                            <td><?= $row["pekerjaan"];?> <?= ($row['user'] != '') ? '<span style="color:blue;font-weight: bold;">(terencana)</span>' : '<span style="color:red;font-weight: bold;">(emergency)</span>' ?></td>
                            <td><?= $dayList[date("D", strtotime($row["date"]))]?>, <?= date(" d F Y", strtotime($row["date"])); ?></td>
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
                            <td><?= $row["pekerjaan"];?> <?= ($row['user'] != '') ? '<span style="color:blue;font-weight: bold;">(terencana)</span>' : '<span style="color:red;font-weight: bold;">(emergency)</span>' ?></td>
                            <td><?= $dayList[date("D", strtotime($row["date"]))]?>, <?= date(" d F Y", strtotime($row["date"])); ?></td>
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
                            <td><?= $row["pekerjaan"];?> <?= ($row['user'] != '') ? '<span style="color:blue;font-weight: bold;">(terencana)</span>' : '<span style="color:red;font-weight: bold;">(emergency)</span>' ?></td>
                            <td><?= $dayList[date("D", strtotime($row["date"]))]?>, <?= date(" d F Y", strtotime($row["date"])); ?></td>
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

                <!-- <button id="show-modal">Learn More</button>
                
                <div class="overlay overlay--hidden"></div>
                <div class="modal modal--hidden">
                <div class="modal__contents">
                    <div class="modal__close-bar">
                    <span>X</span>
                    </div>
                    <p>Please enter your email address to find out more</p>
                    <form id="learn-more-form">
                    
                        <input type="email" placeholder="Your Best Email">
                        <button id="submit">Submit</button>
                    </form>
                    
                </div>

                </div> -->




            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
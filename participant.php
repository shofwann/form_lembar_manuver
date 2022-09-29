<?php
        require 'functions.php';  
        //$totalData = count(query("SELECT * FROM db_form WHERE user_dispa_awal = '$_SESSION[username]' OR user_dispa_akhir = '$_SESSION[username]' ORDER BY id DESC LIMIT $dataAwal,$jumlahDataPerHalaman"));
        if (isset($_GET['halaman'])){
            $halamanAktif = $_GET['halaman'];
        } else {
            $halamanAktif =1;
        }                     
        $dataAwal = ($halamanAktif * $jumlahDataPerHalaman)-$jumlahDataPerHalaman;  //data pertama ditabel
        $jumlahLink = 2;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO-Participant</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="icons/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="card">
        <div class="card-header">
        Participant
        </div>
        <div class="container-wrap">
            <div class="container" style="">
                <input type="text" class="search" placeholder="search..." id="keywordSearchParticipant">
                <br><br>
                <table id="dinamicChange">
                    <thead>
                        <tr>
                            <tr>
                            <th rowspan="2" style="width:5%">No</th>
                            <th rowspan="2" style="width:20%">Pekerjaan</th>
                            <th rowspan="2">waktu</th>
                            <th rowspan="2">lokasi</th>
                            <th colspan="2">Status Aproval</th>
                            <th rowspan="2">Details</th>
                            </tr>
                            <tr>
                            <th>AMN</th>
                            <th>MSB</th>
                            </tr>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($_SESSION["level"]=="initiator") { ?>
                            <?php   
                                $folder = query("SELECT * FROM db_form WHERE user='$_SESSION[username]' ORDER BY id DESC LIMIT $dataAwal,$jumlahDataPerHalaman");  
                                $totalData = count(query("SELECT * FROM db_form WHERE user = '$_SESSION[username]'")); 
                                $no=1; 
                                foreach ( $folder as $data) : 
                            ?>
                            <tbody>
                                <tr>
                                <td class="lebar-tabel"><?= $no+$dataAwal?></td>
                                <td><?= $data['pekerjaan'];?> </div>
                                </td>
                                <td class="lebar-tabel"><?= $dayList[date("D", strtotime($data["date"]))]?>, <?= date(" d F Y", strtotime($data["date"])); ?></td>
                                <td class="lebar-tabel"><?= ($data['lokasi']) ;?></td>
                                <td class="manuver lebar-tabel"><?php if($data['status'] == "msb" || $data['status'] == "msbUbah" || $data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                                echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                            }elseif ($data['status'] == "initiator")  {
                                                echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down' aria-hidden='true'></i></a>";
                                            }else{
                                                echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                            }?>
                                    </td>
                                    <td class="manuver lebar-tabel"><?php if($data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                                echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                                echo "<a href='createPDF.php?id=". $data['id']."&jumlah=' id='pdf' class='pdf'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
                                                echo "<a href='cetakPDF.php?id=". $data['id']."' target='_blank' id='pdf' class='pdf'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
                                            }elseif ($data['msb'] == "disapprove") {
                                                echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down' aria-hidden='true'></i></a>";
                                            }else{
                                                echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                            }?>
                                    </td>
                                <td class="lebar-tabel">
                                    <a href="?url=show_detail&id=<?= $data['id'];?>" class="w3-xlarge w3-text-blue">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </span>
                                    </a> 
                                    
                                    <?php if ($data["postpone"] != '') { ?>
                                        <a href="?url=postpone&id=<?= $data['id']; ?>" class="w3-xlarge w3-text-red">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-pause-circle" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                    <?php }?>
                                </td>
                                </tr>
                            </tbody>
                            <?php $no++ ?>
                            <?php endforeach; ?>
                        <?php } ?>

                        <?php if ($_SESSION["level"]=="amn" || $_SESSION["level"] == "plh_amn") { ?>
                            <?php 
                                $folder = query("SELECT * FROM db_form WHERE user_amn='$_SESSION[username]' OR user_msb = '$_SESSION[username]' ORDER BY id DESC LIMIT $dataAwal,$jumlahDataPerHalaman"); 
                                $totalData = count(query("SELECT * FROM db_form WHERE user_amn='$_SESSION[username]' OR user_msb = '$_SESSION[username]'"));
                                $no=1; 
                                foreach ( $folder as $data) : 
                            ?>
                            <tbody>
                                <tr>
                                    <td><?= $no+$dataAwal?></td>
                                    <td><?= $data['pekerjaan'];?></td>
                                    <td><?= $dayList[date("D", strtotime($data["date"]))]?>, <?= date(" d F Y", strtotime($data["date"])); ?></td>
                                    <td><?= $data['lokasi'];?></td>
                                    <td class="manuver lebar-tabel"><?php if($data['status'] == "msb" || $data['status'] == "msbUbah" || $data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                                echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                            }elseif ($data['status'] == "initiator")  {
                                                echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down' aria-hidden='true'></i></a>";
                                            }else{
                                                echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                            }?>
                                    </td>
                                    <td class="manuver lebar-tabel"><?php if($data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                                echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                            }elseif ($data['msb'] == "disapprove") {
                                                echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down' aria-hidden='true'></i></a>";
                                            }else{
                                                echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                            }?>
                                    </td>
                                    <td class="manuver lebar-tabel">
                                        <a href="?url=show_detail&id=<?= $data['id'];?>" class="w3-xlarge w3-text-blue">
                                            <span class="icon text-white-50">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </span>                                          
                                        </a>
                                        <?php if ($data["postpone"] != '') { ?>
                                        <a href="?url=postpone&id=<?= $data['id']; ?>" class="w3-xlarge w3-text-red">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-pause-circle" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                        <?php }?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php $no++ ?>
                            <?php endforeach; ?>
                        <?php } ?>

                        <?php if ($_SESSION["level"]=="msb" || $_SESSION["level"] == "plh_msb") { ?>
                            <?php 
                                $folder = query("SELECT * FROM db_form WHERE user_msb='$_SESSION[username]' ORDER BY id DESC LIMIT $dataAwal,$jumlahDataPerHalaman");  
                                $no=1; 
                                $totalData = count(query("SELECT * FROM db_form WHERE user_msb='$_SESSION[username]'"));
                                foreach ( $folder as $data) : 
                            ?>
                            <tbody>
                                <tr>
                                <td><?= $no+$dataAwal?></td>
                                <td><?= $data['pekerjaan'];?></td>
                                <td><?= $dayList[date("D", strtotime($data["date"]))]?>, <?= date(" d F Y", strtotime($data["date"])); ?></td>
                                <td><?= $data['lokasi'];?></td>
                                <td class="manuver lebar-tabel"><?php if($data['status'] == "msb" || $data['status'] == "msbUbah" || $data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                            echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                        }elseif ($data['status'] == "initiator") {
                                            echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down' aria-hidden='true'></i></a>";
                                        }else{
                                            echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                        }?>
                                        
                                </td>
                                <td class="manuver lebar-tabel"><?php if($data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                            echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                        }elseif ($data['status'] == "initiator") {
                                            echo "<a href='#' class='disapprove' title='disapprove'>< class='icon text-white-50'><i class='fas fa-thumbs-down'></i></a>";
                                        }else{
                                            echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                        }?>
                                        

                                </td>
                                <td class="manuver lebar-tabel">
                                    <a href="?url=show_detail&id=<?= $data['id'];?>" class="w3-xlarge w3-text-blue">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                    <?php if ($data["postpone"] != '') { ?>
                                        <a href="?url=postpone&id=<?= $data['id']; ?>" class="w3-xlarge w3-text-red">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-pause-circle" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                    <?php }?>
                                </tr>
                            </tbody>
                            <?php $no++ ?>
                            <?php endforeach; ?>
                        <?php } ?>

                        <?php if ($_SESSION["level"]=="dispa") { ?>
                            <?php 
                                $sql=mysqli_query($conn,"SELECT * FROM db_form WHERE user_dispa_awal = '$_SESSION[username]' OR user_dispa_akhir = '$_SESSION[username]' ORDER BY id DESC LIMIT $dataAwal,$jumlahDataPerHalaman" );
                                $no=0;                   
                                $totalData = count(query("SELECT * FROM db_form WHERE user_dispa_awal = '$_SESSION[username]' OR user_dispa_akhir = '$_SESSION[username]' "));
                                while ($data=mysqli_fetch_array($sql)){
                                $no++;
                            ?>

                                <tbody>
                                    <tr>
                                    <td><?= $no?></td>
                                    <td><?= $data['pekerjaan'];?></td>
                                    <td><?= $dayList[date("D", strtotime($data["date"]))]?>, <?= date(" d F Y", strtotime($data["date"])); ?></td>
                                    <td><?= $data['lokasi'];?></td>
                                    <td class="manuver lebar-tabel"><?php if($data['status'] == "msb" || $data['status'] == "msbUbah" || $data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                            echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                        }elseif ($data['status'] == "initiator") {
                                            echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down' aria-hidden='true'></i></a>";
                                        }else{
                                            echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                        }?>
                                        
                                    </td>
                                    <td class="manuver lebar-tabel"><?php if($data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                            echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                        }elseif ($data['status'] == "initiator") {
                                            echo "<a href='#' class='disapprove' title='disapprove'>< class='icon text-white-50'><i class='fas fa-thumbs-down'></i></a>";
                                        }else{
                                            echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                        }?>
                                        

                                    </td>
                                    <td class="manuver lebar-tabel">
                                        <a href="?url=show_detail&id=<?= $data['id'];?>" class="w3-xlarge w3-text-blue">
                                            <span class="icon text-white-50">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                        
                                        <?php if ($data["postpone"] != '') { ?>
                                        <a href="?url=postpone&id=<?= $data['id']; ?>" class="w3-xlarge w3-text-red">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-pause-circle" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                        
                                    <?php }?>
                                    </td>
                                    </tr>
                                </tbody>
                            <?php }?>
                           
                        <?php } ?>

                        <?php if ($_SESSION["level"]=="amn_dispa") { ?>
                            <?php
                                $folder = query("SELECT * FROM db_form WHERE user_amn_dispa_awal='$_SESSION[username]' OR user_amn_dispa_akhir = '$_SESSION[username]' ORDER BY id DESC LIMIT $dataAwal,$jumlahDataPerHalaman");
                                $totalData = count(query("SELECT * FROM db_form WHERE user_amn_dispa_awal='$_SESSION[username]' OR user_amn_dispa_akhir = '$_SESSION[username]'"));
                                $no=1; 
                                foreach ( $folder as $data) : 
                            ?>
                            <tbody>
                                <tr>
                                    <td><?= $no+$dataAwal?></td>
                                    <td><?= $data['pekerjaan'];?></td>
                                    <td><?= $dayList[date("D", strtotime($data["date"]))]?>, <?= date(" d F Y", strtotime($data["date"])); ?></td>
                                    <td><?= $data['lokasi'];?></td>
                                    <td class="manuver lebar-tabel"><?php if($data['status'] == "msb" || $data['status'] == "msbUbah" || $data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                                echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                            }elseif ($data['amn'] == "disapprove") {
                                                echo "<a href='#' class='disapprove' title='disapprove'><span class='icon text-white-50'><i class='fas fa-thumbs-down'></i></span></a>";
                                            }else{
                                                echo "<a href='#' class='pending' title='pending'><span class='icon text-white-50'><i class='fas fa-spinner'></i></span></a>";
                                            }?>
                                    </td>
                                    <td class="manuver lebar-tabel"><?php if($data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done" || $data['status'] == "postpone") {
                                                echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                            }elseif ($data['msb'] == "disapprove") {
                                                echo "<a href='#' class='disapprove' title='disapprove'><span class='icon text-white-50'><i class='fas fa-thumbs-down'></i></span></a>";
                                            }else{
                                                echo "<a href='#' class='pending' title='pending'><span class='icon text-white-50'><i class='fas fa-spinner'></i></span></a>";
                                            }?>
                                    </td>
                                    <td class="manuver lebar-tabel">
                                        <a href="?url=show_detail&id=<?= $data['id'];?>" class="w3-xlarge w3-text-blue">
                                            <span class="icon text-white-50">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                        <?php if ($data["postpone"] != '') { ?>
                                        <a href="?url=postpone&id=<?= $data['id']; ?>" class="w3-xlarge w3-text-red">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-pause-circle" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                    <?php }?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php $no++ ?>
                            <?php endforeach; ?>
                        <?php } ?>

                        
                    </tbody>
                </table>
                <?php
                    $jumlahHalaman = ceil($totalData/$jumlahDataPerHalaman);

                    if ($halamanAktif > $jumlahLink) {
                        $star_number = $halamanAktif - $jumlahLink;
                    } else {
                        $star_number = 1;
                    }

                    if($halamanAktif < ($jumlahHalaman-$jumlahLink)){
                        $end_number = $halamanAktif + $jumlahLink;
                    } else {
                        $end_number = $jumlahHalaman;
                    }
                ?>
                
                    <?php if ($halamanAktif > 1) :?>
                        <a href="home.php?url=participant&halaman=<?= $halamanAktif -1; ?>">&laquo;</a>
                    <?php endif; ?>

                    <?php for($i=$star_number; $i<= $end_number; $i++) : ?>
                        <?php if( $i == $halamanAktif) : ?>
                            <a href="home.php?url=participant&halaman=<?= $i; ?>" style="font-weight:bold;background-color:grey;"><?= $i; ?></a>
                        <?php else : ?>
                            <a href="home.php?url=participant&halaman=<?= $i; ?>"><?= $i; ?></a>
                        <?php endif; ?>
                    <?php endfor?>

                    <?php if ($halamanAktif < $jumlahHalaman) :?>
                        <a href="home.php?url=participant&halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
                    <?php endif; ?>
                

            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
<script>
    

    // ===========================search script==============================================
    var search = document.getElementById('keywordSearchParticipant');
    var change = document.getElementById('dinamicChange');

    search.addEventListener('keyup', function()  {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if( xhr.readyState == 4 && xhr.status == 200 ) { 
            change.innerHTML = xhr.responseText;
        }
    }


    xhr.open('GET','ajax/table_participant.php?search=' + search.value , true);

    xhr.send();

    });



</script>  
</body>
</html>
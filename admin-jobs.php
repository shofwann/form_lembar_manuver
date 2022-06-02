<?php
        require 'functions.php';
                
            

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <div class="card">
        <div class="card-header">
            List Job
        </div>
        <div class="container-wrap">
            <div class="container">
                <form class="">
                    <div class="input-group">
                        <input type="text" name="keyword" id="keyword" size="30" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" autocomplete="off" autofocus>
                    </div>
                </form>
                <div id="bungkus">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                            <th rowspan="2" style="width:5%">No</th>
                            <th rowspan="2" style="width:20%">Pekerjaan</th>
                            <th rowspan="2">waktu</th>
                            <th rowspan="2">lokasi</th>
                            <th colspan="2">Status Aproval</th>
                            <th rowspan="2">Details</th>
                            <th rowspan="2">Action</th>
                            </tr>
                            <tr>
                            <th>AMN</th>
                            <th>MSB</th>
                            </tr>
                        </thead>
                        <?php if ($_SESSION["level"]=="admin") { ?>
                            <?php $folder = query("SELECT * FROM db_form ORDER BY id DESC LIMIT $dataAwal,$jumlahDataPerHalaman");  ?>
                            <?php $no=1; ?>
                            <?php foreach ( $folder as $data) : ?>
                            <tbody>
                                <tr style="height:50px">
                                    <td><?= $no+$dataAwal?></td>
                                    <td><?= $data['pekerjaan'];?></td>
                                    <td><?= $data['date'];?></td>
                                    <td><?= $data['lokasi'];?></td>
                                    <td class="manuver lebar-tabel"><?php if($data['status'] == "msb" || $data['status'] == "msbUbah" || $data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done") {
                                                echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                            }elseif ($data['status'] == "initiator") {
                                                echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down' aria-hidden='true'></i></a>";
                                            }else{
                                                echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                            }?>
                                            
                                        </td>
                                        <td class="manuver lebar-tabel"><?php if($data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done") {
                                                echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                                            }elseif ($data['status'] == "initiator") {
                                                echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down'></i></a>";
                                            }else{
                                                echo "<a href='#' class='pending' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                                            }?>
                                            

                                        </td>
                                    <td>
                                        <a href="?url=show_detail&id=<?= $data['id'];?>" class="btn color_icon" >
                                            <span class="icon text-white-50">
                                                <i class="fa fa-info-circle"> Detail</i>
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="?url=hapus&id=<?= $data['id'];?>" onclick="return confirm('anda yakin menghapus <?= $data['pekerjaan']?>?')" class="btn color_icon">
                                            <span >
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <?php $no++ ?>
                            <?php endforeach; ?>
                        <?php } ?>
                    </table>
                </div>
                    <?php if ($halamanAktif > 1) :?>
                        <a href="home.php?url=jobs&halaman=<?= $halamanAktif -1; ?>">&laquo;</a>
                    <?php endif; ?>

                    <?php for($i=1; $i<= $jumlahHalaman; $i++) : ?>
                        <?php if( $i == $halamanAktif) : ?>
                            <a href="home.php?url=jobs&halaman=<?= $i; ?>" style="font-weight:bold;"><?= $i; ?></a>
                        <?php else : ?>
                            <a href="home.php?url=jobs&halaman=<?= $i; ?>"><?= $i; ?></a>
                        <?php endif; ?>
                    <?php endfor?>

                    <?php if ($halamanAktif < $jumlahHalaman) :?>
                        <a href="home.php?url=jobs&halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
                    <?php endif; ?>
            </div>
        </div>
    </div>
    
</body>
</html>
<?php
session_start();
require "../functions.php";
$search = $_GET["search"];
$query = "SELECT * FROM db_form WHERE (user = '$_SESSION[username]' OR user_amn = '$_SESSION[username]' OR user_msb = '$_SESSION[username]') AND (pekerjaan LIKE '%$search%' OR date LIKE '%$search%' OR lokasi LIKE '%$search%')";
$folder = query($query);

if (isset($_GET['halaman'])){
    $halamanAktif = $_GET['halaman'];
} else {
    $halamanAktif =1;
}  
$dataAwal = ($halamanAktif * $jumlahDataPerHalaman)-$jumlahDataPerHalaman;  //data pertama ditabel
        $jumlahLink = 2;


 

?>


<table>
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
    <?php $no=1; ?>
    <?php foreach ( $folder as $data) : ?>
    <tbody>
        <tr>
        <td><?= $no+$dataAwal?></td>
        <td><?= $data['pekerjaan'];?></td>
        <td><?= $data['date'];?></td>
        <td><?= $data['lokasi'];?></td>
        <td><?php if($data['status'] == "msb" || $data['status'] == "msbUbah" || $data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done") {
                    echo "<a href='#' class='approve' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                }elseif ($data['status'] == "initiator") {
                    echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down' aria-hidden='true'></i></a>";
                }else{
                    echo "<a href='#' class='pending w3-xlarge w3-text-orange' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                }?>
                <a href='createPDF.php?id=<?= $data['id'];?>&jumlah=' class='' hidden><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
        </td>
        <td><?php if($data['status'] == "dispaAwal" || $data['status'] == "dispaAwalUbah" || $data['status'] == "amnDispaAwal" || $data['status'] == "amnDispaAwalUbah" || $data['status'] == "dispaAkhir" || $data['status'] == "dispaAkhirUbah" || $data['status'] == "amnDispaAkhir" || $data['status'] == "amnDispaAkhirUbah" || $data['status'] == "done") {
                    echo "<a href='#' class='approve w3-xlarge w3-text-green' title='approve'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a>";
                    echo "<a href='createPDF.php?id=". $data['id']."&jumlah=' id='pdf' class='pdf'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
                }elseif ($data['msb'] == "disapprove") {
                    echo "<a href='#' class='disapprove' title='disapprove'><i class='fa fa-thumbs-down' aria-hidden='true'></i></a>";
                }else{
                    echo "<a href='#' class='pending w3-xlarge w3-text-orange' title='pending'><i class='fa fa-clock-o' aria-hidden='true'></i></a>";
                   
                }?>
                
        </td>
        <td>
            <a href="?url=show_detail&id=<?= $data['id_new'];?>" class="btn btn-info btn-icon-split">
                <span class="icon text-white-50">
                <i class="fas fa-info-circle"></i>
                </span>
                <span class="text">details</span>
            </a>
        </td>
        </tr>
    </tbody>
    <?php $no++ ?>
    <?php endforeach; ?>
    <script>
     
        
    </script>
</table>

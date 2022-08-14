<?php
// session_start();
require 'functions.php';

$sql=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
$data=mysqli_fetch_assoc($sql);



if( isset($_POST["submit"]) ){

    if( amnDispaAproveAkhir($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                document.location.href = 'home.php?url=inbox';
                </script>
                ";  
                
    } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                document.location.href = 'home.php?url=inbox';
                </script>
                "; die;
                
    }
}

if ($sql){

    $tanggal = $data["date"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO-Aproval MSB</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="icons/font-awesome-4.7.0/css/font-awesome.min.css">
    <style>
        input[type="checkbox"][disabled] {
            border-color: red;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Aproval AMN
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="" method="post">
                    <div class="hiden" hidden>
                        <label for="id" class="control-label">id</label>
                        <input type="text" name="idTask" id="idTask" class="form-control" value="<?= $data["id"]; ?>" readonly>
                    
                        <label>Time Aproval</label>
                        <input type="text" name="time" data-date="" class="form-control" value="<?= date('d-M-Y H:i:s'); ?>" readonly>
                    
                        <label>Level AMN :</label>
                        <input type="text" name="level" class="form-control" placeholder="" value="<?= $_SESSION['level']; ?>" class="form-control" readonly>
                    
                        <label>User AMN Dispa :</label>
                        <input type="text" name="userAmnDispa" placeholder="" value="<?= $_SESSION['username'];?>" class="form-control" readonly>

                        <label>Status :</label>
                        <input type="text" name="status" placeholder="" value="<?= $data["status"]; ?>" class="form-control" readonly>
                        <input type="text" name="" id="user" value="<?= $data["user"]?>">
                    </div>
                    <div class="grid">
                        <div class="grid__item_item01">
                            <div class="back">
                                <input type="button" value="Kembali" onclick="history.back()" style="">
                            </div> <br>
                        </div>
                        <!-- <div class="grid__item grid__item_item02 titel">Creater</div>
                        <div class="grid__item grid__item_item03 titel">Create Form</div>
                        <div class=" grid__item_item04 "></div>
                        <div class="grid__item grid__item_item05 inputan"><p><?= $data['create_user']; ?></p></div>
                        <div class="grid__item grid__item_item06 inputan"><p><?= $data['create_date']; ?></p></div> -->
                        
                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item_item1 titel">pekerjaan</div>
                        <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan</div>
                        <div class="grid__item grid__item_item3 titel">mulai</div>
                        <div class="grid__item grid__item_item4 titel border_right" >selesai</div>
                        <div class="grid__item grid__item_item5 inputan"><p><?= $data["pekerjaan"]; ?></p></div>
                        <div class="grid__item grid__item_item6 inputan"><p><?= date("d F Y", strtotime($tanggal)); ?></p></div>
                        <div class="grid__item grid__item_item7 inputan"><p><?= $dayList[date("D", strtotime($data["start"]))] ?>, <?= date("d F Y G:i",strtotime($data["start"])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item8 inputan border_right"><p><?= $data["end"] == "0000-00-00 00:00:00" ? "not set": $dayList[date("D", strtotime($data["end"]))].",".date("d F Y G:i",strtotime($data["end"]))."WIB" ?></p></div>
                        <div class="grid__item grid__item_item9 titel">lokasi</div>
                        <div class="grid__item grid__item_item10 titel">installasi</div>
                        <div class="grid__item grid__item_item11 titel border_right">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan"><p><?= strtoupper($data["lokasi"]); ?></p></div>
                        <div class="grid__item grid__item_item13 inputan"><p><?= strtoupper($data["installasi"]); ?></p></div>
                        <div class="grid__item grid__item_item14 inputan border_right"><p class="pt-4 pl-2"><?= $data["report_date"]; ?></p></div>
                        <div class="grid__item grid__item_item15 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item16 titel">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item17 titel border_right">kelengkapan dokumen</div>
                        <div class="grid__item grid__item_item18 inputan">
                            <div class="col-7" style="">
                                <br>
                                    <table class="table table-bordered" > 
                                        <thead>
                                                <tr id="mirrodHead" ">  
                                                    <th style="width:158px;">Lokasi</th>
                                                    <th style="width:158px;">Peng. Pekerjaan</th>
                                                    <th style="width:158px;">Peng. Manuver</th>
                                                    <th style="width:158px;">Peng. K3</th>
                                                    <th style="width:158px;">Spv GITET</th>
                                                    <th style="width:158px;">Opr GITET</th>
                                                </tr>
                                        </thead> 
                                        <tbody id="table1">
                                       

                                                <?php foreach (unserialize($data["emergency_pengawas_bebas"]) ?: [] as $row) :
                                                        for($j = 0; $j < count($row["lokasiPembebasan"]); $j++){
                                                    ?>
                                                <tr>
                                                    <td><?= $row['lokasiPembebasan'][$j] ?></td>
                                                    <td><?= $row['peng_pekerjaan'][$j] ?></td>
                                                    <td><?= $row['peng_manuver'][$j] ?></td>
                                                    <td><?= $row['peng_k3'][$j] ?></td>
                                                    <td><?= $row['spv'][$j] ?></td>
                                                    <td><?= $row['opr'][$j] ?></td>
                                                </tr>
                                                    <?php  
                                                        }
                                                        endforeach
                                                    ?>
                
                                        </tbody>
                                    </table>                                        
                                <br>  
                            </div>
                        </div>
                        <div class="grid__item grid__item_item19 inputan">
                            <div class="col-3" >
                                <div class="table-responsive">
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr style="background-color:#F8F9F9;">
                                                <th>Spv GITET</th>
                                                <th>Opr GITET</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table2">
                                        <tbody id="bodyTable2">
                                       

                                            <?php 
                                                    foreach (unserialize($data["emergency_pengawas_normal"]) ?: [] as $row) :
                                                        for($j = 0; $j < count($row["spv_normal"]); $j++){
                                                    ?>
                                                <tr>
                                                    <td><?= $row['spv_normal'][$j] ?></td>
                                                    <td><?= $row['opr_normal'][$j] ?></td>
                                                 
                                                </tr>
                                            <?php  
                                                }
                                                endforeach
                                            ?>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item20 inputan border_right">
                        <div class="col">
                            <br>
                            <?php $cekbok = explode(",", $data["document"]); ?> 
                                    <div action="" style="">
                                        <input type="checkbox" id="" name="" value="wp" <?php in_array('wp', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="vehicle1"> Working Permit</label><br>
                                        <input type="checkbox" id="" name="" value="ik" <?php in_array('ik', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="vehicle2"> IK</label><br>
                                        <input type="checkbox" id="" name="" value="k3" <?php in_array('k3', $cekbok) ? print 'checked' : ' '; ?>  disabled>
                                        <label for="vehicle3"> K3</label><br>
                                        <?php if( $data['user'] == '') {?>
                                            <input type="checkbox" id="surat" name="document[]" value="surat" <?php in_array('surat', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                            <label for="surat"> Surat Emergency</label>    <br><br>
                                            <a href="surat/' . $data['surat'] . '" class="modal-open" download><i style="margin-left:10px;margin-right:10px;"class="fa fa-download"></i></a> <?= ($data['surat'] == '') ? 'belum upload surat' : '<input type="text" value="'.$data['surat'].'" readonly>'  ?>
                                        <?php } ?>
                                    </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item21 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DIBEBASKAN</div>
                        <div class="grid__item grid__item_item22 titel border_right">ALIRAN DAYA PADA INSTALLASI MENJELANG DINORMALKAN</div>
                        <div class="grid__item grid__item_item23 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item24 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item25 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item26 titel border_right">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item27 inputan"><p><?= $data["scada_awal_before"]; ?></p></div>
                        <div class="grid__item grid__item_item28 inputan"><p><?= $data["dpf_awal"]; ?><?= ($data['foto_dpf1'] == null) ? '<span id="emergency">belum upload foto DPF</span>' : '<a href="dpf/' . $data['foto_dpf1'] . '" class="modal-open" download><i style=""class="fa fa-download"></i></a> <button type="button" data-modal="modal1" class="modal-open"><i class="fa fa-eye"></i></button>'; ?></p>
                            <div class="modal" id="modal1">
                                <div class="modal-content" >
                                    <div class="modal-header">
                                        <button type="button" class="modal-close">X</button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="dpf/<?= $data["foto_dpf1"];?>" >
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item29 inputan"><p><?= $data["scada_akhir_before"]; ?></p></div>
                        <div class="grid__item grid__item_item30 inputan border_right"><p><?= $data["dpf_akhir"]; ?> <br> <?= ($data['foto_dpf2'] == null) ? '<span id="emergency">belum upload foto DPF</span>' : '<a href="dpf/' . $data['foto_dpf2'] . '" class="modal-open" download><i style=""class="fa fa-download"></i></a> <button type="button" data-modal="modal2" class="modal-open"><i class="fa fa-eye"></i></button>'; ?></p>
                            <div class="modal" id="modal2">
                                <div class="modal-content" >
                                    <div class="modal-header">
                                        <button type="button" class="modal-close">X</button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="dpf/<?= $data["foto_dpf2"];?>" >
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item31 titel">ALIRAN DAYA SETELAH DIBEBASKAN</div>
                        <div class="grid__item grid__item_item32 titel border_right">ALIRAN DAYA SETELAH DINORMALKAN</div>
                        <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item34 titel border_right">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item35 inputan"><p><?= $data["scada_awal_after"]; ?></p></div>
                        <div class="grid__item grid__item_item36 inputan border_right"><p><?= $data["scada_akhir_after"]; ?></p></div>
                        <div class="grid__item grid__item_item37 titel border_right">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel border_right">Catatan Pra Pembebasan</div>
                        <div class="grid__item grid__item_item39 inputan border_right"><textarea name="catatan_pra_bebas" class="textarea" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_pembebasan"];?></textarea></div>
                        <div class="grid__item grid__item_item40 titel border_right">Tahapan Manuver Pembebasan</div>

                        <?php if ($data["jenis_form"] == 1 || $data["jenis_form"] == 3 ) {  ?>   
                        <div class="grid__item grid__item_item41 inputan">
                            <div class="form-group ml-2">
                                <img src="img/<?= $data["foto"];?>" id="output1" height="auto" width="900px" style="padding-top:.50rem;padding-right:.50rem"><br>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item42 inputan">
                            <table class="table table-bordered mt-2" id="dynamic_field1" style="">
                                <tr>
                                    <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                    <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                    <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                    <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                </tr>
                                <tr>
                                    <th style="width:9rem;">Remote</th>
                                    <th style="width:9rem;">Real (R/L)</th>
                                    <th style="width:9rem;">ADS</th>
                                </tr>
                                <?php $i=1; ?>
                              

                                    <?php 
                                        foreach (unserialize($data["emergency_bebas"]) as $row) :
                                            for($j = 0; $j < count($row["lokasiManuverBebas"]); $j++){
                                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['lokasiManuverBebas'][$j] ?></td>
                                    <td><?= $row['remote_bebas'][$j] ?></td>
                                    <td><?= $row['real_bebas'][$j] ?></td>
                                    <td><?= $row['ads_bebas'][$j] ?></td>
                                    <td><?= $row['installManuverBebas'][$j] ?></td>
                                </tr>
                                    <?php 
                                        $i++;
                                        }
                                        endforeach
                                    ?>

                                </table>
                        </div>
                    <?php } else { ?>
                        <div class="grid__item grid__item_item41new inputan border_right">
                            <?php //var_dump(unserialize($data["emergency_bebas"]));
                                foreach(unserialize($data["emergency_bebas"]) as $row) : 
                                $maxIndex = intval(end($row["idBebas"])); 
                                for($i = 0; $i<=$maxIndex; $i++) { 
                            ?>
                           <div class="container-aprove">
                            <div class="grid-item-aprove">
                                <img src="img/<?= $row["fotoBebas"][$i] ?>" height="auto" width="780px">
                            </div>
                            <div class="grid-item-aprove">
                                <h3 class='titel_table'><?= strtoupper($row["titelBebas"][$i]) ?></h3>
                                <table id="dynamic_field1">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                            <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                            <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                            <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                        </tr>
                                        <tr>
                                            <th style="width:9rem;">Remote</th>
                                            <th style="width:9rem;">Real (R/L)</th>
                                            <th style="width:9rem;">ADS</th>
                                        </tr> 
                                    </thead>
                                        <?php $k=1;
                                            for($j = 0; $j < count($row["idBebas"]); $j++) {
                                                if ($row["idBebas"][$j] == $i) {
                                        ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $k;?></td>
                                            <td><?= $row["lokasiManuverBebas"][$j] ?></td>
                                            <td><?= isset($row['remote_bebas'][$j]) ? $row['remote_bebas'][$j] : '' ?></td>
                                            <td><?= isset($row['real_bebas'][$j]) ? $row['real_bebas'][$j] : '' ?></td>
                                            <td><?= isset($row['ads_bebas'][$j]) ? $row['ads_bebas'][$j] : '' ?></td>
                                            <td><?= $row["installManuverBebas"][$j] ?></td>

                                        </tr>
                                        <?php 
                                            $k++; }}
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            <?php } endforeach;?>
                        </div>
                    <?php }?>
                        <div class="grid__item grid__item_item43 titel border_right">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item44 inputan border_right"><textarea name="catatan_pasca_bebas" class="textarea" cols="232" rows="3" style="" placeholder="Masukan Catatan..." disabled><?= $data["catatan_pasca_pembebasan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item45 titel border_right">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel border_right">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan border_right"><textarea name="catatan_pra_normal" class="textarea" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_penormalan"];?></textarea></div>
                        <div class="grid__item grid__item_item48 titel border_right">Tahapan Manuver Penormalan :</div>
                    <?php if ($data["jenis_form"] == 1 || $data["jenis_form"] == 3) { ?>   
                        <div class="grid__item grid__item_item49 inputan">
                            <div class="form-group ml-2">
                                <img src="img/<?= $data["foto2"];?>" id="output2" height="auto" width="900px" style="padding-top:.50rem;padding-right:.50rem"><br>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item50 inputan border_right">
                            <table class="table table-bordered mt-2" id="dynamic_field2" style="">
                                <tr>
                                    <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                    <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                    <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                    <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                </tr>
                                <tr>
                                    <th>Remote</th>
                                    <th>Real (R/L)</th>
                                    <th>ADS</th>
                                </tr>
                                

                                <?php $i=1; ?>
                                    <?php 
                                        foreach (unserialize($data["emergency_normal"])  ? : []  as $row) :
                                            for($j = 0; $j < count($row["lokasiManuverNormal"]); $j++){
                                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><p><?= $row['lokasiManuverNormal'][$j] ?></p></td>
                                    <td><p><?= $row['remote_normal'][$j] ?></p></td>
                                    <td><p><?= $row['real_normal'][$j] ?></p></td>
                                    <td><p><?= $row['ads_normal'][$j] ?></p></td>
                                    <td><p><?= $row['installManuverNormal'][$j]; ?></p></td>
                                    
                                </tr>
                                    <?php 
                                        $i++;
                                        }
                                        endforeach
                                    ?>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="grid__item grid__item_item49new inputan">
                            <?php 
                                foreach(unserialize($data["emergency_normal"]) as $row) : 
                                $maxIndex = intval(end($row["idNormal"])); 
                                for($i = 0; $i<=$maxIndex; $i++) { 
                            ?>
                            <div class="container-aprove">
                                <div class="grid-item-aprove">
                                    <img src="img/<?= $row["fotoNormal"][$i] ?>" height="auto" width="900px">
                                </div>
                                <div class="grid-item-aprove">
                                    <h3 class='titel_table'><?= $row["titelNormal"][$i] ?></h3>
                                    <table id="dynamic_field2">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                                <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                                <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                                <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                            </tr>
                                            <tr>
                                                <th style="width:9rem;">Remote</th>
                                                <th style="width:9rem;">Real (R/L)</th>
                                                <th style="width:9rem;">ADS</th>
                                            </tr> 
                                        </thead>
                                            <?php $k=1;
                                                for($j = 0; $j < count($row["idNormal"]); $j++) {
                                                    if ($row["idNormal"][$j] == $i) {
                                            ?>
                                        <tbody>
                                            <tr>
                                                <td><?= $k;?></td>
                                                <td><?= $row["lokasiManuverNormal"][$j] ?></td>
                                                <td><p><?= $row['remote_normal'][$j] ?></p></td>
                                                <td><p><?= $row['real_normal'][$j] ?></p></td>
                                                <td><p><?= $row['ads_normal'][$j] ?></p></td>
                                                <td><?= $row["installManuverNormal"][$j] ?></td>

                                            </tr>
                                            <?php 
                                               $k++; }}
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php } endforeach;?>    
                        </div>
                    <?php } ?>
                        <div class="grid__item grid__item_item51 titel border_right">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan border_right"><textarea name="catatan_pasca_normal" class="textarea" cols="232" rows="3" disabled><?= $data["catatan_pasca_penormalan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item53 titel">Catatan AMN Dispa Awal</div>
                        <div class="grid__item grid__item_item54 titel border_right">Catatan AMN Dispa Akhir</div>
                        <div class="grid__item grid__item_item55 inputan"><textarea name="catatan_amndis_awal" class="textarea" cols="113" rows="5" style="" disabled><?= $data["catatan_amnDispa_awal"]; ?></textarea></div>
                        <div class="grid__item grid__item_item56 inputan border_right"><textarea name="catatan_amndis_akhir" class="textarea" cols="113" rows="5" style=""><?= $data["catatan_amnDispa_akhir"]; ?></textarea></div>
                    </div>
                        <div class="grid__item grid__item_item57 inputan border_right border_bottom">
                            <div class="aproval">
                                <input type="radio" id="aprove" name="aproval" value="approve">
                                <label for="aprove">Approve</label>
                                <input type="radio" id="disapprove" name="aproval" value="disapprove">
                                <label for="disapprove">Disapprove</label>
                            </div>
                            <br>
                            <button type="submit" name="submit" >Simpan Form</button>
                        </div>
                    </div>

                </form>
                <?php  } ?>
            </div>

        </div>
    </div>
  

    <script src="js/script.js"></script>
</body>
</html>
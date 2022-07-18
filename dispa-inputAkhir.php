<?php
require 'functions.php';
$sql_manuver_petugas=mysqli_query($conn,"SELECT * FROM db_table_pengawas WHERE id_form='$_GET[id]'");
$sql_manuver_petugas2=mysqli_query($conn,"SELECT * FROM db_table_pengawas WHERE id_form='$_GET[id]'");
$tahapan_manuver_pembebasan=mysqli_query($conn,"SELECT * FROM db_table_tahapan WHERE id_form='$_GET[id]' AND tahapan = 'pembebasan'");
$tahapan_manuver_penormalan=mysqli_query($conn,"SELECT * FROM db_table_tahapan WHERE id_form='$_GET[id]' AND tahapan = 'penormalan'");
$data=query("SELECT * FROM db_form WHERE id='$_GET[id]'")[0];




if( isset($_POST["submit"]) ){

    if( inputDispaAkhir ($_POST) > 0){
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


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO - Dispa</title>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Dispa Job
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="" method="post" enctype="multipart/form-data">
                    <dive class="hiden" hidden>
                        <label for="id" class="control-label">id</label>
                        <input type="text" name="idTask" id="idTask" class="form-control" value="<?= $data["id"]; ?>" readonly>
                        <label>Aproval date</label>
                        <input type="text" name="time" class="form-control" value="<?= date('d-M-Y H:i:s'); ?>" readonly>
                        <label>User Dispa :</label>
                        <input type="text" name="userdispa" placeholder="" value="<?= $_SESSION['username'];?>" class="form-control" readonly>  
                        <label for="fotoLama" class="control-label">foto</label>
                        <input type="text" name="fotoLama" id="fotoLama" class="form-control" value="<?= $data["foto_dpf2"]; ?>" readonly> <!--untuk menyimpan foto lama, jika user tidak ganti foto maka foto ini yg digunakan-->
                        <input type="text" name="status" id="status" value="<?= $data["status"]; ?>">
                        <input type="text" value="<?= $data["emergency_pengawas_normal"]?>" id="pengawas_normal">
                    </dive>
                    <div class="grid">
                        <div class="grid__item_item01">
                            <div class="back">
                                <input type="button" value="Kembali" onclick="history.back()" style="">
                            </div> <br>
                        </div>
                        <!-- <div class="grid__item grid__item_item02 titel">Creater</div>
                        <div class="grid__item grid__item_item03 titel">Create Form</div>
                        <div class=" grid__item_item04 "></div>
                        <div class="grid__item grid__item_item05 inputan"><p><?= $data['user']; ?></p></div>
                        <div class="grid__item grid__item_item06 inputan"><p><?= $data['create_date']; ?></p></div> -->
                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item_item1 titel">pekerjaan<span>*</span></div>
                        <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan<span>*</span></div>
                        <div class="grid__item grid__item_item3 titel">mulai<span>*</span></div>
                        <div class="grid__item grid__item_item4 titel" >selesai<span>*</span></div>
                        <div class="grid__item grid__item_item5 inputan"><p><?= $data["pekerjaan"]; ?></p></div>
                        <div class="grid__item grid__item_item6 inputan"><p><?= $dayList[date("D", strtotime($data["date"]))] ?>, <?= date(" d F Y", strtotime($data["date"])); ?></p></div>
                        <div class="grid__item grid__item_item7 inputan"><p><?= $dayList[date("D", strtotime($data["start"]))] ?>, <?= date("d F Y G:i",strtotime($data["start"])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item8 inputan"><p><?= $dayList[date("D", strtotime($data["end"]))] ?>, <?= date("d F Y G:i",strtotime($data["end"])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                        <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                        <div class="grid__item grid__item_item11 titel">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan"><p><?= strtoupper($data["lokasi"]); ?></p></div>
                        <div class="grid__item grid__item_item13 inputan"><p><?= strtoupper($data["installasi"]); ?></p></div>
                        <div class="grid__item grid__item_item14 inputan"><p><?= date('d-F-Y\ H:i:s', strtotime($data['report_date'])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item15 titel">MANUVER PEMBEBASAN INSTALLASI<span>*</span></div>
                        <div class="grid__item grid__item_item16 titel">MANUVER PENORMALAN INSTALLASI<span>*</span></div>
                        <div class="grid__item grid__item_item17 titel">kelengkapan dokumen</div>
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
                                                    <td><?= isset($row['peng_pekerjaan'][$j]) ? $row['peng_pekerjaan'][$j] : '' ?></td>
                                                    <td><?= isset($row['peng_manuver'][$j]) ? $row['peng_manuver'][$j] :'' ?></td>
                                                    <td><?= isset($row['peng_k3'][$j]) ? $row['peng_manuver'][$j] : '' ?></td>
                                                    <td><?= isset($row['spv'][$j]) ? $row['spv'][$j] : '' ?></td>
                                                    <td><?= isset($row['opr'][$j]) ? $row['opr'][$j] : '' ?></td>
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
                                        <?php 
                                                    foreach (unserialize($data["emergency_pengawas_normal"]) ?: [] as $row) :
                                                      
                                                            for($j = 0; $j < count($row["spv_normal"]); $j++){
                                                    ?>
                                                <tr>
                                                    <td><input type="text" name="spv_normal[]" value="<?= $row['spv_normal'][$j] ?>"></td>
                                                    <td><input type="text" name="opr_normal[]" value="<?= $row['opr_normal'][$j] ?>"></td>
                                                 
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
                        <div class="grid__item grid__item_item20 inputan">
                        <?php $cekbok = explode(",", $data["document"]); ?> 
                        <div class="col">
                            <br>
                                    <div action="">
                                        <input type="checkbox" id="wp" name="document[]" value="wp" <?php in_array('wp', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="wp">wp</label><br>
                                        <input type="checkbox" id="ik" name="document[]" value="ik" <?php in_array('ik', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="ik"> IK</label><br>
                                        <input type="checkbox" id="k3" name="document[]" value="k3" <?php in_array('k3', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="k3"> K3</label><br>
                                    </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item21 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DIBEBASKAN</div>
                        <div class="grid__item grid__item_item22 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DINORMALKAN</div>
                        <div class="grid__item grid__item_item23 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item24 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item25 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item26 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item27 inputan"><p><?= $data["scada_awal_before"]; ?></p></div>
                        <div class="grid__item grid__item_item28 inputan"><p><?= $data["dpf_awal"]; ?><?= ($data['foto_dpf1'] == null) ? 'belum upload foto DPF' : '<a href="dpf/' . $data['foto_dpf1'] . '" class="" download><i style="margin-left:10px;margin-right:10px;"class="fa fa-download"></i></a><button type="button" data-modal="modal1" class="modal-open"><i class="fa fa-eye"></i></button>'; ?></p>
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
                        <div class="grid__item grid__item_item29 inputan"><input type="text" name="scada_akhir_before" placeholder="Fill in Mw MVar Amper Volt" value="<?= $data["scada_akhir_before"]; ?>"></div>
                        <div class="grid__item grid__item_item30 inputan"><input type="text" name="dpf_akhir" style="font-style:italic;" placeholder="Fill in Mw MVar Amper Volt" value="<?= $data["dpf_akhir"]; ?>"><br><input type="file" id="foto1" name="dpfFile_akhir" required><p><?= $data["foto_dpf2"] ? '<button type="button" data-modal="modal2" class="modal-open"><i class="fa fa-eye"></i></button>' : '<span style="color:red">Belum upload</span>'; ?></p>
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
                        <div class="grid__item grid__item_item32 titel">ALIRAN DAYA SETELAH DINORMALKAN</div>
                        <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item34 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item35 inputan"><p><?= $data["scada_awal_after"]; ?></p></div>
                        <div class="grid__item grid__item_item36 inputan"><input type="text" name="scada_akhir_after" placeholder="Fill in Mw MVar Amper Volt" style="" value="<?= $data["scada_akhir_after"]; ?>"></div>
                        <div class="grid__item grid__item_item37 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel">Catatan Pra Pembebasan</div>
                        <div class="grid__item grid__item_item39 inputan"><textarea name="catatan_pra_bebas" class="textarea" cols="232" rows="3"  style="color:red;" disabled><?= $data["catatan_pra_pembebasan"];?></textarea></div>
                        <div class="grid__item grid__item_item40 titel">Tahapan Manuver Pembebasan</div>
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
                                        <td><p><?= $row['lokasiManuverBebas'][$j] ?></p></td>
                                        <td><p><?= $row['remote_bebas'][$j] ? $row['remote_bebas'][$j].' WIB' : '' ?></p></td>
                                        <td><p><?= $row['real_bebas'][$j] ? $row['real_bebas'][$j].' WIB' : '' ?></p></td>
                                        <td><p><?= $row['ads_bebas'][$j] ? $row['ads_bebas'][$j].' WIB' : '' ?></p></td>
                                        <td><p><?= $row['installManuverBebas'][$j] ?></p></td>
                                        
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
                                <h3 style='valign = center;'><?= $row["titelBebas"][$i] ?></h3>
                                <table id="dynamic_field1" >
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
                        <div class="grid__item grid__item_item43 titel">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item44 inputan"><textarea name="catatan_pasca_bebas" class="textarea" cols="232" rows="3" style="" placeholder="Masukan Catatan..." disabled><?= $data["catatan_pasca_pembebasan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item45 titel">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan"><textarea name="catatan_pra_normal" class="textarea" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_penormalan"];?></textarea></div>
                        <div class="grid__item grid__item_item48 titel">Tahapan Manuver Penormalan :</div>
                    <?php if ($data["jenis_form"] == 1 || $data["jenis_form"] == 3) { ?>
                        <div class="grid__item grid__item_item49 inputan">
                            <div class="form-group ml-2">
                                <img src="img/<?= $data["foto2"];?>" id="output2" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item50 inputan">
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
                                        foreach (unserialize($data["emergency_normal"]) ? : []  as $row) :
                                            for($j = 0; $j < count((is_countable($row["lokasiManuverNormal"])?$row["lokasiManuverNormal"]:[])); $j++){
                                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><input type="text" name="lokasiManuverNormal[]" value="<?= $row['lokasiManuverNormal'][$j] ?>" readonly></td>
                                    <td><input type="time" name="remote_normal[]" value="<?= isset($row['remote_normal'][$j]) ? $row['remote_normal'][$j] : '' ?>"></td>
                                    <td><input type="time" name="real_normal[]" value="<?= isset($row['real_normal'][$j]) ? $row['real_normal'][$j] : '' ?>"></td>
                                    <td><input type="time" name="ads_normal[]" value="<?= isset($row['ads_normal'][$j]) ? $row['ads_normal'][$j] : '' ?>"></td>
                                    <td><input type="text" name="installManuverNormal[]" value="<?= $row['installManuverNormal'][$j] ?>" readonly></td>
                                </tr>
                                    <?php 
                                        $i++;
                                        }
                                        endforeach
                                    ?>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="grid__item grid__item_item49new inputan border_right">
                        <?php //var_dump(unserialize($data["emergency_bebas"]));
                                foreach(unserialize($data["emergency_normal"]) as $row) : 
                                $maxIndex = intval(end($row["idNormal"])); 
                                for($i = 0; $i<=$maxIndex; $i++) { 
                            ?>
                           <div class="container-aprove">
                            <div class="grid-item-aprove">
                                <img src="img/<?= $row["fotoNormal"][$i] ?>" height="auto" width="900px">
                                
                            </div>
                            <div class="grid-item-aprove">
                                <h3 style='valign = center;'><?= $row["titelNormal"][$i] ?></h3>
                                <table id="dynamic_field1" >
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
                                            <td><input type="text" name="lokasiManuverNormal[]" value="<?= $row['lokasiManuverNormal'][$j] ?>" readonly></td>
                                            <td><input type="time" name="remote_normal[]" value="<?= isset($row['remote_normal'][$j]) ? $row['remote_normal'][$j] : '' ?>"></td>
                                            <td><input type="time" name="real_normal[]" value="<?= isset($row['real_normal'][$j]) ? $row['real_normal'][$j] : '' ?>"></td>
                                            <td><input type="time" name="ads_normal[]" value="<?= isset($row['ads_normal'][$j]) ? $row['ads_normal'][$j] : '' ?>"></td>
                                            <td>
                                                <input type="text" name="installManuverNormal[]" value="<?= $row['installManuverNormal'][$j] ?>" readonly>
                                            </td>

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
                        <div class="grid__item grid__item_item51 titel">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan"><textarea name="catatan_pasca_normal" class="textarea" cols="232" rows="3"><?= $data["catatan_pasca_penormalan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item53 titel catatan" >Catatan AMN Dispa Awal</div>
                        <div class="grid__item grid__item_item54 titel catatan" >Catatan AMN Dispa Akhir</div>
                        <div class="grid__item grid__item_item55 inputan catatan" ><textarea name="catatan_amndis_awal" class="textarea" cols="113" rows="5" style="" disabled><?= $data["catatan_amnDispa_awal"]; ?></textarea></div>
                        <div class="grid__item grid__item_item56 inputan catatan" ><textarea name="catatan_amndis_akhir" class="textarea" cols="113" rows="5" style="" disabled><?= $data["catatan_amnDispa_akhir"]; ?></textarea></div>
                    </div><br>
                        <button type="submit" name="submit" >Simpan Form</button>
                    </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
<script>
    var catatan =  document.getElementsByClassName("catatan");
    var status = document.getElementById("status").value;
    var isiFoto = document.getElementById("fotoLama").value;
    var foto = document.getElementById("foto1")

    if (isiFoto != "") {
        foto.required= false;
    }

    if (status == 'dispaAwal' || status == 'dispaAkhir'){
        for (var i = 0; i<catatan.length; i++)
        catatan[i].style.display = 'none';
    }

    const jumRowstabel1 = document.querySelector('#table1').rows.length;
    let tabel2 =document.querySelector('#table2')

    // penggunaan untuk sesuai tabel bebas
    let varPengNormal = document.getElementById('pengawas_normal').value;
    if (varPengNormal == ''){
        for(i=0; i<jumRowstabel1; i++){
            const newRow = document.createElement('tr');
            newRow.innerHTML = `<td><input type="text" name="spv_normal[]" placeholder="nama SPV"></td><td><input type="text" name="opr_normal[]" value="" placeholder="nama OPR"></td>`;
            tabel2.appendChild(newRow);
        }

    }

</script>
<script src="js/script.js"></script>
</body>
</html>
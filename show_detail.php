<?php
require 'functions.php';

$sql=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
$data=mysqli_fetch_assoc($sql);




if ($sql){

    $tanggal = $data["date"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO - Detail</title>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Detail pekerjaan
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="">
                    <div class="hiden" hidden>
                        <input type="text" name="status" id="status" value="<?= $data["status"] ?>">
                        <input type="text" name="user" id="user" value="<?= $data["user"] ?>">
                    </div>
                    <div class="grid">
                        <div class="grid__item_item01">
                            <div class="back">
                                <input type="button" value="Kembali" onclick="history.back()" style="">
                            </div>
                        </div>
                        <div class="grid__item grid__item_item02 titel ">Creater</div>
                        <div class="grid__item grid__item_item03 titel border_right">Create Form</div>
                        <div class=" grid__item_item04 "></div>
                        <div class="grid__item grid__item_item05 inputan "><p><?= $data['create_user']; ?></p></div>
                        <div class="grid__item grid__item_item06 inputan border_right"><p><?= $data['create_date']; ?></p></div>
                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item_item1 titel">pekerjaan</div>
                        <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan</div>
                        <div class="grid__item grid__item_item3 titel">mulai</div>
                        <div class="grid__item grid__item_item4 titel border_right" >selesai</div>
                        <div class="grid__item grid__item_item5 inputan"><p><?= $data["pekerjaan"]; ?></p></div>
                        <div class="grid__item grid__item_item6 inputan"><p><?= $dayList[date("D", strtotime($data["date"]))] ?>, <?= date(" d F Y", strtotime($data["date"])); ?></p></div>
                        <div class="grid__item grid__item_item7 inputan"><p><?= $dayList[date("D", strtotime($data["start"]))] ?>, <?= date("d F Y G:i",strtotime($data["start"])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item8 inputan border_right"><p><?= $dayList[date("D", strtotime($data["end"]))] ?>, <?= date("d F Y G:i",strtotime($data["end"])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item9 titel">lokasi</div>
                        <div class="grid__item grid__item_item10 titel">installasi</div>
                        <div class="grid__item grid__item_item11 titel border_right">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan"><p><?= strtoupper($data["lokasi"]); ?></p></div>
                        <div class="grid__item grid__item_item13 inputan"><p><?= strtoupper($data["installasi"]); ?></p></div>
                        <div class="grid__item grid__item_item14 inputan border_right"><p><?= $data["report_date"]; ?></p></div>
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
                                    <div action="">
                                        <?php $cekbok = explode(",", $data["document"]); ?> 
                                        <input type="checkbox" id="wp" name="document[]" value="wp" <?php in_array('wp', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="wp">Working Permit</label><br>
                                        <input type="checkbox" id="ik" name="document[]" value="ik" <?php in_array('ik', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="ik"> IK</label><br>
                                        <input type="checkbox" id="k3" name="document[]" value="k3" <?php in_array('k3', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="k3"> K3</label><br>
                                        <?php if( $data['user'] == '') {?>
                                            <input type="checkbox" id="surat" name="document[]" value="surat" <?php in_array('surat', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                            <label for="surat"> Surat Emergency</label>    <br><br>
                                            <a href="surat/<?= $data['surat'] ?>" class="modal-open" download><i style="margin-left:10px;margin-right:10px;"class="fa fa-download"></i></a> <?= ($data['surat'] == '') ? 'belum upload surat' : '<input type="text" value="'.$data['surat'].'" readonly>'  ?>
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
                        <div class="grid__item grid__item_item28 inputan"><p><?= $data["dpf_awal"]; ?> <?= ($data['foto_dpf1'] == null) ? '<span id="emergency">belum upload foto DPF</span>' : '<a href="dpf/' . $data['foto_dpf1'] . '" class="modal-open" download><i style=""class="fa fa-download"></i></a> <button type="button" data-modal="modal1" class="modal-open"><i class="fa fa-eye"></i></button>'; ?></p>
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
                        <div class="grid__item grid__item_item30 inputan border_right"><p><?= $data["dpf_akhir"]; ?> <?= ($data['foto_dpf2'] == null) ? '<span id="emergency">belum upload foto DPF</span>' : '<a href="dpf/' . $data['foto_dpf2'] . '" class="modal-open" download><i style=""class="fa fa-download"></i></a> <button type="button" data-modal="modal2" class="modal-open"><i class="fa fa-eye"></i></button>'; ?></p>
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
                        <div class="grid__item grid__item_item34 titel border_right">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item35 inputan"><p class="pt-4 pl-2"><?= $data["scada_awal_after"]; ?></p></div>
                        <div class="grid__item grid__item_item36 inputan border_right"><p class="pt-4 pl-2"><?= $data["scada_akhir_after"]; ?></p></div>
                        <div class="grid__item grid__item_item37 titel border_right">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel border_right">Catatan Pra Pembebasan</div>
                        <div class="grid__item grid__item_item39 inputan border_right"><textarea name="catatan_pra_bebas" class="textarea" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_pembebasan"];?></textarea></div>
                        <div class="grid__item grid__item_item40 titel border_right">Tahapan Manuver Pembebasan</div>

                    <?php if ($data["jenis_form"] == 1 ) {  ?>
                        <div class="grid__item grid__item_item41 inputan">
                            <div class="form-group ml-2">
                                <img src="img/<?= $data["foto"];?>" id="output1" height="auto" width="900px" style="padding-top:.50rem;padding-right:.50rem"><br>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item42 inputan border_right">
                            <table class="table table-bordered mt-2" id="dynamic_field1" style="">
                                <thead>
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
                                </thead>
                                <tbody >
                                  

                                        <?php $i=1; ?>
                                        <?php 
                                            foreach (unserialize($data["emergency_bebas"])  ? : []  as $row) :
                                                for($j = 0; $j < count($row["lokasiManuverBebas"]); $j++){
                                        ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><p><?= $row['lokasiManuverBebas'][$j] ?></p></td>
                                        <td><p><?= isset($row['remote_bebas'][$j]) ? $row['remote_bebas'][$j] :'' ?></p></td>
                                        <td><p><?= isset($row['real_bebas'][$j]) ? $row['real_bebas'][$j] : '' ?></p></td>
                                        <td><p><?= isset($row['ads_bebas'][$j]) ? $row['ads_bebas'][$j] : '' ?></p></td>
                                        <td><p><?= $row['installManuverBebas'][$j] ?></p></td>
                                        
                                    </tr>
                                        <?php 
                                            $i++;
                                            }
                                            endforeach
                                            ?>
                                </tbody>
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
                                <table>
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
                        <div class="grid__item grid__item_item44 inputan border_right"><textarea name="catatan_pra_bebas" class="textarea" cols="232" rows="3"  disabled><?= $data["catatan_pasca_pembebasan"];?></textarea></div>
                        <div class="grid__item grid__item_item45 titel border_right">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel border_right">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan border_right"><textarea name="catatan_pra_normal" class="textarea" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_penormalan"];?></textarea></div>
                        <div class="grid__item grid__item_item48 titel border_right">Tahapan Manuver Penormalan :</div>
                    <?php if ($data["jenis_form"] == 1 ) { ?>
                        <div class="grid__item grid__item_item49 inputan">
                            <div class="form-group ml-2">
                                <?php if($data["foto2"]) {?>
                                <img src="img/<?= $data["foto2"];?>" id="output2" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                <?php }?>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item50 inputan border_right">
                            <table class="table table-bordered mt-2" id="dynamic_field2" style="">
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
                                <tbody>
                              

                                <?php $i=1; ?>
                                    <?php 
                                        foreach (unserialize($data["emergency_normal"])  ? : []  as $row) :
                                            for($j = 0; $j < count((is_countable($row["lokasiManuverNormal"])?$row["lokasiManuverNormal"]:[])); $j++){
                                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><p><?= $row['lokasiManuverNormal'][$j] ?></p></td>
                                    <td><p><?= isset($row['remote_normal'][$j]) ? $row['remote_normal'][$j] :'' ?></p></td>
                                    <td><p><?= isset($row['real_normal'][$j]) ? $row['real_normal'][$j] : '' ?></p></td>
                                    <td><p><?= isset($row['ads_normal'][$j]) ? $row['ads_normal'][$j] : '' ?></p></td>
                                    <td><p><?= $row['installManuverNormal'][$j] ?></p></td>
                                    
                                </tr>
                                    <?php 
                                        $i++;
                                        }
                                        endforeach
                                    ?>
                                </tbody>
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
                                    <img src="img/<?= $row["fotoNormal"][$i] ?>" height="auto" width="780px">
                                </div>
                                <div class="grid-item-aprove">
                                    <h3><?= $row["titelNormal"][$i] ?></h3>
                                    <table>
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
                                                <td></td>
                                                <td></td>
                                                <td></td>
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
                        <!-- <div class="grid__item grid__item_item53"></div>
                        <div class="grid__item grid__item_item54"></div>
                        <div class="grid__item grid__item_item55"></div>
                        <div class="grid__item grid__item_item56"></div>
                        <div class="grid__item grid__item_item57"></div> -->
                        <div class="grid__item grid__item_item58 titel border_right">Aproval</div>
                        <div class="grid__item grid__item_item59">AMN ROH</div>
                        <div class="grid__item grid__item_item60">MSB DALOP</div>
                        <div class="grid__item grid__item_item61">Dispa Pembebasan</div>
                        <div class="grid__item grid__item_item62">AMN Dispa Pembebasan</div>
                        <div class="grid__item grid__item_item63">Dispa Penormalan</div>
                        <div class="grid__item grid__item_item64 border_right">AMN Dispa Penormalan</div>
                        <div class="grid__item grid__item_item65">
                            <?php if($data['user_amn'] != "" ){ ?>
                                <?php if ($data["user"] != '') { ?>
                                <div class="stamp is-nope" id="setuju1">
                                    <span class="position"><?= mb_strtoupper(str_replace('_',' ',$data["level_amn"])); ?></span>
                                    <span class="name"><?= $data["user_amn"]?></span>
                                    <span class="date"><?= $data["time_amn_aprove"]?></span>
                                </div>
                            <?php }} ?>
                        </div>
                        <div class="grid__item grid__item_item66">
                            <?php if($data['user_msb'] != "" ){ ?>
                                <?php if ($data["user"] != '') { ?>
                                <div class="stamp is-nope" id="setuju1">
                                    <span class="position"><?= mb_strtoupper(str_replace('_',' ',$data["level_msb"])); ?></span>
                                    <span class="name"><?= $data["user_msb"]?></span>
                                    <span class="date"><?= $data["time_msb_aprove"]?></span>
                                </div>
                            <?php }} ?>
                        </div>
                        <div class="grid__item grid__item_item67">
                            <?php if($data['user_dispa_awal'] != "" ){ ?>
                                <div class="stamp is-nope" id="setuju1">
                                    <span class="position">DISPA</span>
                                    <span class="name"><?= $data["user_dispa_awal"]?></span>
                                    <span class="date"><?= $data["time_dispa_awal_aprove"]?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="grid__item grid__item_item68">
                            <?php if($data['user_amn_dispa_awal'] != ""  ){ ?>
                                <div class="stamp is-nope" id="setuju1">
                                    <span class="position"><?= mb_strtoupper(str_replace('_',' ',$data["level_amn_dispa_awal"])); ?></span>
                                    <span class="name"><?= $data["user_amn_dispa_awal"]?></span>
                                    <span class="date"><?= $data["time_amnDispa_awal_aprove"]?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="grid__item grid__item_item69">
                            <?php if($data['user_dispa_akhir'] != "" ){ ?>
                                <div class="stamp is-nope" id="setuju1">
                                    <span class="position">DISPA</span>
                                    <span class="name"><?= $data["user_dispa_akhir"]?></span>
                                    <span class="date"><?= $data["time_dispa_akhir_aprove"]?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="grid__item grid__item_item70 border_right">
                            <?php if($data['user_amn_dispa_akhir'] != "" ){ ?>
                                <div class="stamp is-nope" id="setuju1">
                                    <span class="position"><?= mb_strtoupper(str_replace('_',' ',$data["level_amn_dispa_akhir"])); ?></span>
                                    <span class="name"><?= $data["user_amn_dispa_akhir"]?></span>
                                    <span class="date"><?= $data["time_amnDispa_akhir_aprove"]?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div><br>
                </form>
                <?php  } ?>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
    const jumRowstabel1 = document.querySelector('#table1').rows.length;
    let tabel2 =document.querySelector('#table2')
    let status = document.getElementById('status').value;
    
    let dataArray = ['amnUbah','amn','msb','msbUbah','dispa','dispaAwalUbah','dispaAkhir','amnDispaAwal','amnDispaAwalUbah','amnDispaAkhirUbah']

    if(dataArray.indexOf(status) !== -1){
        for(i=0; i<jumRowstabel1; i++){
        const newRow = document.createElement('tr');
        newRow.innerHTML = `<td></td><td></td>`;
        tabel2.appendChild(newRow);
    }
    } else{
        console.log("Value does not exists!")
    }



   


    // if (status = array[])
    // for(i=0; i<jumRowstabel1; i++){
    //     const newRow = document.createElement('tr');
    //     newRow.innerHTML = `<td></td><td></td>`;
    //     tabel2.appendChild(newRow);
    // }
    </script>
</body>
</html>
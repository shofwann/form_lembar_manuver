<?php
require 'functions.php';

$sql=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
$data=mysqli_fetch_assoc($sql);




if( isset($_POST["submit"]) ){

    if( ubahEmergencyAwal($_POST) > 0){
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
                //document.location.href = 'home.php?url=inbox';
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
                    <dive class="hiden" >
                        <label for="id" class="control-label">id</label>
                        <input type="text" name="idTask" id="idTask" class="form-control" value="<?= $data["id"]; ?>" readonly>
                        <label>Aproval date</label>
                        <input type="text" name="dateAprove" class="form-control" value="<?= date('d-M-Y H:i:s'); ?>" readonly>
                        <label>User Dispa :</label>
                        <input type="text" name="user" placeholder="" value="<?= $_SESSION['username'];?>" class="form-control" readonly>  
                        <input type="text" name="fotoLamaBebas"  value="<?= $data["foto"]; ?>" readonly> <!--untuk menyimpan foto lama, jika user tidak ganti foto maka foto ini yg digunakan-->
                        <input type="text" name="fotoLamaNormal" value="<?= $data["foto2"]; ?>">
                        <input type="text" name="status" id="statusJob" value="<?= $data["status"]; ?>">
                        <input type="text" name="create_date" value="<?= date('d-M-Y H:i:s');?>">
                        <input type="text" name="filelama" value="<?= $data['surat'];?>">
                        <input type="text" value="<?= $_SESSION['level'];?>" id="level">
                        <input type="text" name="jenis_form" value="<?= $data['jenis_form']?>">
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
                        <div class="grid__item grid__item_item5 inputan"><input type="text" name="pekerjaan" value="<?= $data["pekerjaan"]; ?>"></div>
                        <div class="grid__item grid__item_item6 inputan"><input type="date" name="date" value="<?= $data["date"]; ?>"></div>
                        <div class="grid__item grid__item_item7 inputan"><input type="datetime-local" name="start" value="<?= date('Y-m-d\TH:i:s', strtotime($data['start'])); ?>">  WIB</div>
                        <div class="grid__item grid__item_item8 inputan"><input type="datetime-local" name="end" value="<?= date('Y-m-d\TH:i:s', strtotime($data['end'])); ?>"> WIB</div>
                        <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                        <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                        <div class="grid__item grid__item_item11 titel">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan">
                            <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                <input type="text" name="lokasi" value="<?= strtoupper($data["lokasi"]); ?>" autocomplete="off">
                                <div class="tool-tip slideIn">
                                        Perhatikan untuk Format penulisan...!!!
                                        <ul class="info-list" >
                                            <li><b>SUTET</b>Cawang-Depok</li>
                                            <li><b>REACTOR</b>Bandung Selatan</li>
                                            <li><b>BUSBAR</b>Cawang</li>
                                            <li><b>IBT</b>Cawang</li>
                                        </ul>
                                        untuk pekerjaan Reactor,Busbar, IBT gunakan nama GITET nya
                                    
                                    </div>
                                    <div for="" id="response"></div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                        <div class="grid__item grid__item_item13 inputan">
                            
                            <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                <input type="text" name="instal" id="lokasiDetail" value="<?= strtoupper($data["installasi"]); ?>" autocomplete="off" placeholder="Inputkan detail pekerjaan" style="width: 400px;">
                                <div class="tool-tip  slideIn">
                                    Perhatikan untuk Format penulisan...!!!
                                    <ul class="info-list" >
                                        <li><b>SUTET</b>Sirkit-1</li>
                                        <li><b>REACTOR</b>Reactor-1</li>
                                        <li><b>BUSBAR</b>Busbar-A</li>
                                        <li><b>IBT</b>IBT-1</li>
                                    </ul>
                                    Harap disesuaikan                                   
                                </div>
                                <div for=""id="responseDetail"></div>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                        <div class="grid__item grid__item_item14 inputan"><input type="datetime-local" value="<?= date('Y-m-d\TH:i:s', strtotime($data['report_date'])); ?>" name="report_date" id="report_date"></div>
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
                                     
                                        <?php 
                                        foreach (unserialize($data["emergency_pengawas_bebas"]) as $row) :
                                            for($j = 0; $j < count($row["lokasiPembebasan"]); $j++){
                                        ?>
                                            <tr>
                                                <td><input type="text" name="lokasiPembebasan[]" value="<?= $row['lokasiPembebasan'][$j] ?>"></td>
                                                <td><input type="text" name="peng_pekerjaan[]" value="<?= $row['peng_pekerjaan'][$j] ?>"></td>
                                                <td><input type="text" name="peng_manuver[]" value="<?= $row['peng_manuver'][$j] ?>"></td>
                                                <td><input type="text" name="peng_k3[]" value="<?= $row['peng_k3'][$j] ?>"></td>
                                                <td><input type="text" name="spv[]" value="<?= $row['spv'][$j] ?>"></td>
                                                <td><input type="text" name="opr[]" value="<?= $row['opr'][$j] ?>"></td>
                                            </tr>
                                        <?php  
                                            }
                                            endforeach
                                        ?>
                                        </tbody>
                                    </table> 
                                        <button type="button" id="add1" class="btn green" onclick="tambah()" ><i class='fa fa-plus'></i></button>
                                        <button type="button" id="remove1" class="btn red" onclick="kurang()"><i class="fa fa-minus" aria-hidden="true"></i></button> 
                                        
                                        
                                
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
                                                    foreach (unserialize($data["emergency_pengawas_normal"]) ? : [] as $row) :
                                                        for($j = 0; $j < count($row["lokasi"]); $j++){
                                                    ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                 
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
                                        <input type="checkbox" id="wp" name="document[]" value="wp" <?php in_array('wp', $cekbok) ? print 'checked' : ' '; ?> >
                                        <label for="wp">Working Permit</label><br>
                                        <input type="checkbox" id="ik" name="document[]" value="ik" <?php in_array('ik', $cekbok) ? print 'checked' : ' '; ?> >
                                        <label for="ik"> IK</label><br>
                                        <input type="checkbox" id="k3" name="document[]" value="k3" <?php in_array('k3', $cekbok) ? print 'checked' : ' '; ?> >
                                        <label for="k3"> K3</label><br>
                                        <input type="checkbox" id="surat" name="document[]" value="surat" <?php in_array('surat', $cekbok) ? print 'checked' : ' '; ?> required>
                                        <label for="surat"> Surat       <input type="file" name="pdf"><br><br>
                                        <?= ($data['surat'] == '') ? 'belum upload surat' : '<input type="text" value="'.$data['surat'].'" readonly>'  ?>
                                    </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item21 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DIBEBASKAN</div>
                        <div class="grid__item grid__item_item22 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DINORMALKAN</div>
                        <div class="grid__item grid__item_item23 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item24 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item25 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item26 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item27 inputan"><input type="text" name="scada_awal_before" value="<?= $data["scada_awal_before"]; ?>" style="font-style:italic;width:300px;" placeholder="Fill in Mw MVar Amper Volt" required></div>
                        <div class="grid__item grid__item_item28 inputan"></div>
                        <div class="grid__item grid__item_item29 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item30 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item31 titel">ALIRAN DAYA SETELAH DIBEBASKAN</div>
                        <div class="grid__item grid__item_item32 titel">ALIRAN DAYA SETELAH DINORMALKAN</div>
                        <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item34 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item35 inputan"><input type="text" name="scada_awal_after" value="<?= $data["scada_awal_after"]; ?>" style="width:300px; font-style:italic;" placeholder="Fill in Mw MVar Amper Volt" required></div>
                        <div class="grid__item grid__item_item36 inputan"><h6 class="pt-4 pl-2" disabled><?= $data["scada_akhir_after"]; ?></h6></div>
                        <div class="grid__item grid__item_item37 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel">Catatan Pra Pembebasan</div>
                        <div class="grid__item grid__item_item39 inputan"><textarea name="catatan_pra_bebas" class=textarea cols="232" rows="3" style="color:red;"><?= $data["catatan_pra_pembebasan"];?></textarea></div>
                        <div class="grid__item grid__item_item40 titel">Tahapan Manuver Pembebasan</div>
                    <?php if ($data["jenis_form"] == 1 || $data["jenis_form"] == 3) {?>
                        <div class="grid__item grid__item_item41 inputan">
                            <div class="form-group ml-2">
                                <img src="img/<?= $data["foto"];?>" id="output1" height="auto" width="900px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                <input type="file" accept="image/*" name="foto" >
                            </div>
                        </div>
                        <div class="grid__item grid__item_item42 inputan">
                            <table class="table table-bordered mt-2" id="dynamic_field1" style="">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                        <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                        <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                        <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                        <th rowspan="2"><button type="button" class="btn green" onclick="tambahBaris('dynamic1','lokasiManuverBebas[]','installManuverBebas[]','remote_bebas[]','real_bebas[]','ads_bebas[]')">Add More</button></th>
                                    </tr>
                                    <tr>
                                        <th style="width:9rem;">Remote</th>
                                        <th style="width:9rem;">Real (R/L)</th>
                                        <th style="width:9rem;">ADS</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamic1" >
                            
                                        <?php  $i=1;
                                            foreach (unserialize($data["emergency_bebas"]) as $row) :
                                                for($j = 0; $j < count($row["lokasiManuverBebas"]); $j++){
                                        ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><input type="text" name="lokasiManuverBebas[]" value="<?= $row['lokasiManuverBebas'][$j] ?>"></td>
                                        <td><input type="time" name="remote_bebas[]" value="<?= $row['remote_bebas'][$j] ?>"></td>
                                        <td><input type="time" name="real_bebas[]" value="<?= $row['real_bebas'][$j] ?>"></td>
                                        <td><input type="time" name="ads_bebas[]" value="<?= $row['ads_bebas'][$j] ?>"></td>
                                        <td><input type="text" name="installManuverBebas[]" value="<?= $row['installManuverBebas'][$j] ?>"></td>
                                        <td>
                                            <button type="button" onclick="hapus_baris_emergency(this)" class="btn btn-danger btn_remove">Remove</button>
                                        </td>
                                    </tr>
                                        <?php 
                                            $i++;
                                            }
                                            endforeach
                                        ?>

                                </tbody>
                                </table>
                        </div>
                    <?php } else {?>
                        <div class="grid__item grid__item_item41new inputan border_right">
                            <?php //var_dump(unserialize($data["emergency_bebas"]));
                                foreach(unserialize($data["emergency_bebas"]) as $row) : 
                                  //echo "<br><br>";  var_dump($row["fotoBebas"]); ?>
                            <?php
                                $maxIndex = intval(end($row["idBebas"])); 
                                for($i = 0; $i<=$maxIndex; $i++) { 
                            ?>
                            <div class="container-fluid exist-bebas">
                                <div class="grid-item">
                                    <img src="img/<?= $row["fotoBebas"][$i] ?>" height="auto" width="780px"><br>
                                    <input type="file" accept="image/*" onchange="" name="fotoBebasOld[]">
                                    <input type="hidden" name="idBebasOld[]" value="<?= $i ?>" disabled>
                                    <!-- <input type="text" name="fotoBebas[]" value="<?//= $row["fotoBebas"][$i] ?>" disabled> -->
                                </div>
                                <div class="grid-item">
                                <label for="">Masukkan Titel</label><br>
                                    <input type="text" name="titelBebas[]" value="<?= $row["titelBebas"][$i] ?>" style="font: size 20px; margin-bottom:10px;">
                                    
                                    <table style="">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                                <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                                <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                                <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                                <th rowspan="2"><button type="button" name="add3" id="add3" class="btn green" onclick="tambahRowUpdate(<?= $i ?>,'lokasiManuverBebas[]','installManuverBebas[]','idBebas[]','rowBebas')">Add More</button></th>
                                            </tr>
                                            <tr>
                                                <th style="width:9rem;">Remote</th>
                                                <th style="width:9rem;">Real (R/L)</th>
                                                <th style="width:9rem;">ADS</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rowBebas<?= $i ?>">
                                            <?php $k=1;
                                                for($j = 0; $j < count($row["idBebas"]); $j++) {
                                                    if ($row["idBebas"][$j] == $i) {
                                            ?>
                                                <tr>
                                                    <td><?= $k;?></td>
                                                    <td><input type="text" name="lokasiManuverBebas[]" value="<?= $row["lokasiManuverBebas"][$j] ?>"></td>
                                                    <td><input type="time" name="remote_bebas[]" value="<?= $row['remote_bebas'][$j] ?>"></td>
                                                    <td><input type="time" name="real_bebas[]" value="<?= $row['real_bebas'][$j] ?>"></td>
                                                    <td><input type="time" name="ads_bebas[]" value="<?= $row['ads_bebas'][$j] ?>"></td>
                                                    <td><input type="text" name="installManuverBebas[]" value="<?= $row["installManuverBebas"][$j] ?>"></td>
                                                    <td>
                                                        <button type='button' class='btn red' onclick='kurangRow(this)'>Remove</button>
                                                        <input type="hidden" name="idBebas[]" value="<?= $row["idBebas"][$j] ?>">
                                                    </td>
                                                </tr>
                                            <?php 
                                               $k++; }}
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="grid-item btn_bebas">
                                    <button type="button" class="btn-greend " onclick="tambahFormUpdate(0,'titelBebas[]','lokasiManuverBebas[]','installManuverBebas[]','idBebas[]','fotoBebasNew[]','copyFormBebas','rowBebas<?= $i ?>','removeFormBottonBebas','new-bebas','btn_bebas','exist-bebas')">+</button>
                                </div>
                            </div>
                            <?php } endforeach;?>
                            <div id="copyFormBebas"></div>
                        </div>
                    <?php } ?>
                        <div class="grid__item grid__item_item43 titel">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item44 inputan"><textarea name="catatan_pasca_bebas" class=textarea cols="232" rows="3" style="" placeholder="Masukan Catatan..."><?= $data["catatan_pasca_pembebasan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item45 titel">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan"><textarea name="catatan_pra_normal" class=textarea cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_penormalan"];?></textarea></div>
                        <div class="grid__item grid__item_item48 titel">Tahapan Manuver Penormalan :</div>
                        <?php if($data['jenis_form'] == 3 ) { ?>
                            <!-- <div class="grid__item grid__item_item49 inputan">
                                <div class="form-group ml-2">
                                    <img id="output2" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                    <input type="file" accept="image/*" onchange="" name="foto2" >
                                </div>
                            </div>
                            <div class="grid__item grid__item_item50 inputan">
                                <table class="table table-bordered mt-2" id="dynamic_field2" style="">
                                    <tr>
                                        <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                        <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                        <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                        <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                        <th rowspan="2"><button type="button" name="add4" id="add4" class="btn btn-success green" onclick="tambahManuver('dynamic_field2','lokasiManuverNormal[]','installManuverNormal[]','id_update_normal[]',jumlah_baris2,'remote_normal[]','real_normal[]','ads_normal[]')">Add More</button></th>
                                    </tr>
                                    <tr>
                                        <th style="width:9rem;">Remote</th>
                                        <th style="width:9rem;">Real (R/L)</th>
                                        <th style="width:9rem;">ADS</th>
                                    </tr>
                                     <?php $i=1; ?>
                                            <?php 
                                                foreach (unserialize($data2["manuver_normal"])  ? : []  as $row) :
                                                    for($j = 0; $j < count((is_countable($row["lokasiManuverNormal"])?$row["lokasiManuverNormal"]:[])); $j++){
                                            ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><p><input type="text" name="lokasiManuverNormal[]" value="<?= $row['lokasiManuverNormal'][$j] ?>" style="width:8rem;padding:0rem;" ></p></td>
                                            <td><input type="time" name="remote_normal[]" ></td>
                                            <td><input type="time" name="real_normal[]" ></td>
                                            <td><input type="time" name="ads_normal[]" ></td>
                                            <td><p><input type="text" name="installManuverNormal[]" value="<?= $row["installManuverNormal"][$j] ?>" style="width:8rem;padding:0rem;" ></p></td>
                                            <td><button type='button' class='btn red' onclick='kurangBaris(this)'>Remove</button></td>
                                            
                                        </tr>
                                            <?php 
                                                $i++;
                                                }
                                                endforeach
                                            ?> 
                                </table>
                            </div> -->
                        <?php } else { ?>
                        <!-- <div class="grid__item grid__item_item49new inputan">
                            <?php 
                                foreach(unserialize($data["emergency_normal"]) as $row) : 
                                $maxIndex = intval(end($row["idNormal"])); 
                                for($i = 0; $i<=$maxIndex; $i++) { 
                                    
                            ?>
                            <div class="container-fluid exist-normal">
                                <div class="grid-item">
                                    <img src="" height="auto" width="900px"><br>
                                    <input type="file" accept="image/*" onchange="" name="fotoNormal[]">
                                    <input type="hidden" name="idNormalOld[]" value="<?= $i ?>" disabled>
                                </div>
                                <div class="grid-item">
                                    <h3><input type="text" name="titelNormal[]" value="<?= $row["titelNormal"][$i] ?>"></h3>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                                <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                                <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                                <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                                <th rowspan="2"><button type="button" name="add3" id="add3" class="btn green" onclick="tambahRowUpdate(<?= $i ?>,'lokasiManuverNormal[]','installManuverNormal[]','idNormal[]','rowNormal','remote_Normal[]','real_Normal[]','ads_Normal[]')">Add More</button></th>
                                            </tr>
                                            <tr>
                                                <th style="width:9rem;">Remote</th>
                                                <th style="width:9rem;">Real (R/L)</th>
                                                <th style="width:9rem;">ADS</th>
                                            </tr> 
                                        </thead >
                                        <tbody id="rowNormal<?= $i ?>">
                                            <?php $k=1;
                                                for($j = 0; $j < count($row["idNormal"]); $j++) {
                                                    if ($row["idNormal"][$j] == $i) {    
                                            ?>
                                            <tr>
                                                <td><?= $k;?></td>
                                                <td><input type="text" name="lokasiManuverNormal[]" value="<?= $row["lokasiManuverNormal"][$j] ?>"></td>
                                                <td><input type="time" name="remote_normal[]" value="<?= isset($row['remote_normal'][$j]) ? $row['remote_normal'][$j] : '' ?>"></td>
                                                <td><input type="time" name="real_normal[]" value="<?= isset($row['real_normal'][$j]) ? $row['real_normal'][$j] : '' ?>"></td>
                                                <td><input type="time" name="ads_normal[]" value="<?= isset($row['ads_normal'][$j]) ? $row['ads_normal'][$j] : '' ?>"></td>
                                                <td><input type="text" name="installManuverNormal[]" value="<?= $row["installManuverNormal"][$j] ?>"></td> 
                                                <td>
                                                    <button type='button' class='btn red' onclick='kurangRow(this)'>Remove</button>
                                                    <input type="hidden" name="idNormal[]" value="<?= $row["idNormal"][$j] ?>">
                                                </td>
                                            </tr>
                                            <?php 
                                               $k++; }}
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="grid-item btn_normal">
                                    <button type="button" class="btn-greend " onclick="tambahFormUpdate(0,'titelNormal[]','lokasiManuverNormal[]','installManuverNormal[]','idNormal[]','fotoNormal[]','copyFormNormal','rowNormal<?= $i ?>','removeFormBottonNormal','new-normal','btn_normal','exist-normal','remote_Normal[]','real_Normal[]','ads_Normal[]')">+</button>
                                </div>
                            </div>
                            <?php } endforeach;?>  
                            <div id="copyFormNormal"></div>  
                        </div> -->
                        <?php } ?>
                        <div class="grid__item grid__item_item51 titel">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan"><textarea name="catatan_pasca_normal" class=textarea cols="232" rows="3" disabled><?= $data["catatan_pasca_penormalan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item53 titel catatan" >Catatan AMN Dispa Awal</div>
                        <div class="grid__item grid__item_item54 titel catatan" >Catatan AMN Dispa Akhir</div>
                        <div class="grid__item grid__item_item55 inputan catatan" ><textarea name="catatan_amndis_awal" class=textarea cols="113" rows="5" style="" disabled><?= $data["catatan_amnDispa_awal"]; ?></textarea></div>
                        <div class="grid__item grid__item_item56 inputan catatan" ><textarea name="catatan_amndis_akhir" class=textarea cols="113" rows="5" style="" disabled></textarea></div>
                    </div><br>
                        <button type="submit" name="submit" >Simpan Form</button>
                    </div>
                    </div>
                </form>
                <?php  } ?>
            </div>
        </div>
    </div>
<script>
    var catatan =  document.getElementsByClassName("catatan");
    var foto = document.getElementById("foto1")
    var tabel1 = document.querySelectorAll("#table1 tr").length;
    var tabel2 = document.getElementById('table2');

    for(i=0; i<tabel1; i++){
        const newRow = document.createElement('tr');
        newRow.innerHTML = `<td></td><td></td>`;
        tabel2.appendChild(newRow);
    }

    console.log(tabel1);

    if (status == 'dispaAwal'){
        for (var i = 0; i<catatan.length; i++)
        catatan[i].style.display = 'none';
    }

</script>
<script src="js/script.js"></script>
</body>
</html>
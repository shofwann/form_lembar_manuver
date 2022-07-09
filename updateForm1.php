<?php 
require 'functions.php';

$sql=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
$data=mysqli_fetch_assoc($sql);


$dataAjax = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis=$data[jenis_pekerjaan] AND db_ajax_lokasi.nama= '$data[lokasi]' AND db_ajax_lokasi_detail.nama='$data[installasi]'");
$cekData = mysqli_num_rows($dataAjax);




if( isset($_POST["submit"]) ){
    if( updateForm($_POST) > 0){
        //var_dump(ubah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                //setTimeout(myURL, 5000);
                //document.location.href = 'home.php?url=inbox';
                </script>
                ";  
                
    } else {
        //var_dump(ubah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                //document.location.href = 'home.php?url=inbox';
                </script>"; 
                die;
                
    }
}



// echo $isiajax["id_lokasi_detail"]; 
// var_dump($isiajax);




if ($sql){

    $tanggal = $data["date"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        span {
            color: red;
        }

    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Change Document
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="" method="post" id="form_id" enctype="multipart/form-data">
                    <div class="hiden" >
                        <div class="additional">
                            <div class="default" >
                                <label for="">Create Date:</label>
                                <input type="text" name="create_date" value="<?= $data["create_date"];?>">
                                <label for="">User :</label>
                                <input type="text" name="user" value="<?= $_SESSION['username'];?>">
                                <label>ID Task:</label>
                                <input type="text" name="idTask" value="<?= $data['id']; ?>"  readonly>
                                <label for="">foto Lama pembebasan</label>
                                <input type="text" name="fotoLama1" value="<?= $data["foto"] ?>"  readonly>
                                <label for="">foto Lama penormalan</label>
                                <input type="text" name="fotoLama2" value="<?= $data["foto2"] ?>"  readonly>
                                <label for="">level user:</label>
                                <input type="text" name="level" value="<?= $_SESSION['level'];?>"  readonly>
                                <!-- <label for="">Pilihan Jenis</label>
                                <input type="text" name="jenis_pekerjaan" value="<?= $data["jenis_pekerjaan"] ?>"> -->
                                <label for="">Penyimpanan ke DB :</label>
                                <label for="">lokasi</label>
                                <input type="text" name="lokasi_lama" value="<?= $data["lokasi"]; ?>" width="10">
                                <label for="">lokasi detail</label>
                                <input type="text" name="instal_lama" value="<?= $data["installasi"]; ?>">
                                <input type="text" name="id_lokasi_detail" value="<?= $data["id_lokasi_detail"]; ?>">
                                <input type="text" value="<?= $_SESSION['level'];?>" id="level">
                                <input type="text" value="" id="statusJob">
                                <input type="text" name="jenis_form" value="<?= $data["jenis_form"]?>">
                            </div>
                            <div class="chose">
                                <label for="" style="">Pilih jenis pekerjaan :</label>
                                <select name="jenis_pekerjaan" id="jenis" style="" required>
                                    <option value="">-SELECT-</option>
                                    <option value="1" <?php if ($data["jenis_pekerjaan"] == 1 ) echo 'selected="selected"'; ?>>SUTET</option>
                                    <option value="2" <?php if ($data["jenis_pekerjaan"] == 2 ) echo 'selected="selected"'; ?>>ENERGIZE</option>
                                    <option value="3" <?php if ($data["jenis_pekerjaan"] == 3 ) echo 'selected="selected"'; ?>>IBT</option>
                                    <option value="4" <?php if ($data["jenis_pekerjaan"] == 4 ) echo 'selected="selected"'; ?>>BUSBAR</option>
                                    <option value="5" <?php if ($data["jenis_pekerjaan"] == 5 ) echo 'selected="selected"'; ?>>REACTOR</option>
                                    <option value="6" <?php if ($data["jenis_pekerjaan"] == 6 ) echo 'selected="selected"'; ?>>PMT</option>
                                    <option value="7" <?php if ($data["jenis_pekerjaan"] == 7 ) echo 'selected="selected"'; ?>>PMS</option>
                                    <option value="8" <?php if ($data["jenis_pekerjaan"] == 8 ) echo 'selected="selected"'; ?>>BUSBAR</option>
                                    <option value="9" <?php if ($data["jenis_pekerjaan"] == 9 ) echo 'selected="selected"'; ?>>ENERGIZE</option>
                                    <option value="10" <?php if ($data["jenis_pekerjaan"] == 10 ) echo 'selected="selected"'; ?>>SUTET</option>
                                </select>
                                <label for="">Apakah anda mau MENGUPDATE form ke DB?</label>
                                <input id="toggle-on" class="toggle toggle-left" name="chose_db" value="0" type="radio" <?php if ($data["chose_db"]== 0) echo 'checked'; ?>>
                                <label for="toggle-on" class="btnn">No</label>
                                <input id="toggle-off" class="toggle toggle-right" name="chose_db" value="1" type="radio" <?php if ($data["chose_db"]== 1) echo 'checked'; ?>>
                                <label for="toggle-off" class="btnn">Yes</label>
                            </div>
                        </div>

                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item_item1 titel">pekerjaan<span>*</span></div>
                        <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan<span>*</span></div>
                        <div class="grid__item grid__item_item3 titel">mulai<span>*</span></div>
                        <div class="grid__item grid__item_item4 titel border_right">selesai<span>*</span></div>
                        <div class="grid__item grid__item_item5 inputan"><input type="text" name="pekerjaan" id="pekerjaan" value="<?= $data["pekerjaan"]; ?>"></div>
                        <div class="grid__item grid__item_item6 inputan"><input type="date" name="date" id="start_date"  value="<?= $data["date"]; ?>"></div>
                        <div class="grid__item grid__item_item7 inputan"><input type="datetime-local" name="start" id="end_date" class="" value="<?= date('Y-m-d\TH:i:s', strtotime($data['start'])); ?>">   WIB</div>
                        <div class="grid__item grid__item_item8 inputan border_right"><input type="datetime-local" name="end" id="report_date" class="" value="<?= date('Y-m-d\TH:i:s', strtotime($data['end'])); ?>"> WIB</div>
                        <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                        <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                        <div class="grid__item grid__item_item11 titel border_right">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan" id="lokasinya">
                            <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                <input type="text" name="lokasi" id="lokasi" value="<?= $data["lokasi"] ?>" class="inputi" autocomplete="off" placeholder="Sebelum input lokasi pilih jenis pekerjaan dahulu...!" style="width: 400px;">
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
                            <div style="clear:both"></div>
                        </div>
                        <div class="grid__item grid__item_item13 inputan" id="detailnya">
                            <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                <input type="text" name="instal" id="lokasiDetail" value="<?= $data["installasi"]?>" class="" autocomplete="off" placeholder="Inputkan detail pekerjaan" style="width: 400px;">
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
                                <div style="clear:both"></div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item14 inputan border_right"><input type="datetime-local" name="report_date" id="report_date"  disabled></div>
                        <div class="grid__item grid__item_item15 titel">MANUVER PEMBEBASAN INSTALLASI<span>*</span></div>
                        <div class="grid__item grid__item_item16 titel">MANUVER PENORMALAN INSTALLASI<span>*</span></div>
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
                                                    <td><input type="text" name="lokasiPembebasan[]" value="<?= $row['lokasiPembebasan'][$j] ?>"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                    <?php  
                                                        }
                                                        endforeach
                                                    ?>
                                        </tbody>
                                        <tfoot id="sub_table1" hidden>
                                          

                                            
                                        </tfoot>
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
                                        

                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item20 inputan border_right">
                        <div class="col">
                            <br>
                                    <div action="">
                                        <input type="checkbox" id="" name="wp" value="" disabled>
                                        <label for="vehicle1"> WP</label><br>
                                        <input type="checkbox" id="" name="ik" value="" disabled>
                                        <label for="vehicle2"> IK</label><br>
                                        <input type="checkbox" id="" name="k3" value="" disabled>
                                        <label for="vehicle3"> K3</label><br>
                                    </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item21 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DIBEBASKAN</div>
                        <div class="grid__item grid__item_item22 titel border_right">ALIRAN DAYA PADA INSTALLASI MENJELANG DINORMALKAN</div>
                        <div class="grid__item grid__item_item23 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item24 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item25 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item26 titel border_right">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item27 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item28 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item29 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item30 inputan border_right"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item31 titel">ALIRAN DAYA SETELAH DIBEBASKAN</div>
                        <div class="grid__item grid__item_item32 titel border_right">ALIRAN DAYA SETELAH DINORMALKAN</div>
                        <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item34 titel border_right">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item35 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item36 inputan border_right"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item37 titel border_right">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel border_right">Catatan Pra Pembebasan<span>*</span></div>
                        <div class="grid__item grid__item_item39 inputan border_right"><textarea name="catatan_pra_bebas" class="textarea" cols="232" rows="3" ><?= $data["catatan_pra_pembebasan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item40 titel border_right">Tahapan Manuver Pembebasan<span>*</span></div> 
                    <?php if($data["jenis_form"] == 1) { ?>
                        <div class="grid__item grid__item_item41 inputan">
                            <img src="img/<?= $data["foto"];?>" id="output1" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                            <input type="file" name="foto" accept="image/*" >
                        </div>
                        <div class="grid__item grid__item_item42 inputan border_right">
                            <table class="table table-bordered mt-2" style="">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                        <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                        <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                        <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                        <th rowspan="2"><button type="button" name="add3" id="add3" class="btn green" onclick="tambahBaris('dynamic1','lokasiManuverBebas[]','installManuverBebas[]')">Add More</button></th>
                                    </tr>
                                    <tr>
                                        <th style="width:9rem;">Remote</th>
                                        <th style="width:9rem;">Real (R/L)</th>
                                        <th style="width:9rem;">ADS</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamic1">
                                       

                                        <?php $i=1; ?>
                                    <?php 
                                        foreach (unserialize($data["emergency_bebas"])  ? : []  as $row) :
                                            for($j = 0; $j < count((is_countable($row["lokasiManuverBebas"])?$row["lokasiManuverBebas"]:[])); $j++){
                                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><p><input type="text" name="lokasiManuverBebas[]" value="<?= $row['lokasiManuverBebas'][$j] ?>" style="width:8rem;padding:0rem;" required></p></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><p><input type="text" name="installManuverBebas[]" value="<?= $row["installManuverBebas"][$j] ?>" style="width:8rem;padding:0rem;" required></p></td>
                                    <td><button type='button' class='btn red' onclick='kurangBaris(this)'>Remove</button></td>
                                    
                                </tr>
                                    <?php 
                                        $i++;
                                        }
                                        endforeach
                                    ?>
                                </tbody >
                                <tfoot id="sub_dynamic_field1" hidden>
                                  

                                </tfoot>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="grid__item grid__item_item41new inputan border_right">
                            <?php var_dump(unserialize($data["emergency_bebas"]));
                                foreach(unserialize($data["emergency_bebas"]) as $row) : 
                                  echo "<br><br>";  var_dump($row["fotoBebas"]); ?>
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
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><input type="text" name="installManuverBebas[]" value="<?= $row["installManuverBebas"][$j] ?>"></td>
                                                    <td>
                                                        <button type='button' class='btn red' onclick='kurangRow(this)'>Remove</button>
                                                        <input type="text" name="idBebas[]" value="<?= $row["idBebas"][$j] ?>">
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
                        <div class="grid__item grid__item_item43 titel border_right">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item44 inputan border_right"><textarea name="catatan_pasca_bebas" class="textarea" cols="232" rows="3" disabled></textarea></div>
                        <div class="grid__item grid__item_item45 titel border_right">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel border_right">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan border_right"><textarea name="catatan_pra_normal" class="textarea" cols="232" rows="3" ><?= $data["catatan_pra_penormalan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item48 titel border_right">Tahapan Manuver Penormalan :</div>
                    <?php if($data["jenis_form"] == 1) {?>
                        <div class="grid__item grid__item_item49 inputan">             
                                <img src="img/<?= $data["foto2"];?>" id="output2" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                <input type="file" accept="image/*" name="foto2">
                        </div>
                        <div class="grid__item grid__item_item50 inputan border_right">
                            <table class="table table-bordered mt-2"  style="">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                        <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                        <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                        <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                        <th rowspan="2"><button type="button" name="add4" id="add4" class="btn btn-success green" onclick="tambahBaris('dynamic2','lokasiManuverNormal[]','installManuverNormal[]')">Add More</button></th>
                                    </tr>
                                    <tr>
                                        <th>Remote</th>
                                        <th>Real (R/L)</th>
                                        <th>ADS</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamic2">
                                    <?php $i=1; ?>
                                    <?php 
                                        foreach (unserialize($data["emergency_normal"])  ? : []  as $row) :
                                            for($j = 0; $j < count((is_countable($row["lokasiManuverNormal"])?$row["lokasiManuverNormal"]:[])); $j++){
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><p><input type="text" name="lokasiManuverNormal[]" value="<?= $row['lokasiManuverNormal'][$j] ?>" style="width:8rem;padding:0rem;" required></p></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><p><input type="text" name="installManuverNormal[]" value="<?= $row["installManuverNormal"][$j] ?>" style="width:8rem;padding:0rem;" required></p></td>
                                        <td><button type='button' class='btn red' onclick='kurangBaris(this)'>Remove</button></td>
                                        
                                    </tr>
                                    <?php 
                                        $i++;
                                        }
                                        endforeach
                                    ?>
                                </tbody>
                                <tfoot id="sub_dynamic_field2" hidden>
                                </tfoot>
                            </table>
                        </div>
                    <?php } else { ?> 
                        <div class="grid__item grid__item_item49new inputan">
                            <?php var_dump(unserialize($data["emergency_normal"]));
                                foreach(unserialize($data["emergency_normal"]) as $row) : 
                                $maxIndex = intval(end($row["idNormal"])); 
                                for($i = 0; $i<=$maxIndex; $i++) { 
                                    
                            ?>
                            <div class="container-fluid exist-normal">
                                <div class="grid-item">
                                    <img src="img/<?= $row["fotoNormal"][$i] ?>" height="auto" width="780px"><br>
                                    <input type="file" accept="image/*" onchange="" name="fotoNormalOld[]">
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
                                                <th rowspan="2"><button type="button" name="add3" id="add3" class="btn green" onclick="tambahRowUpdate(<?= $i ?>,'lokasiManuverNormal[]','installManuverNormal[]','idNormal[]','rowNormal')">Add More</button></th>
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
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><input type="text" name="installManuverNormal[]" value="<?= $row["installManuverNormal"][$j] ?>"></td>                                                </td>
                                                <td>
                                                    <button type='button' class='btn red' onclick='kurangRow(this)'>Remove</button>
                                                    <input type="text" name="idNormal[]" value="<?= $row["idNormal"][$j] ?>">
                                                </td>
                                            </tr>
                                            <?php 
                                               $k++; }}
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="grid-item btn_normal">
                                    <button type="button" class="btn-greend " onclick="tambahFormUpdate(0,'titelNormal[]','lokasiManuverNormal[]','installManuverNormal[]','idNormal[]','fotoNormalNew[]','copyFormNormal','rowNormal<?= $i ?>','removeFormBottonNormal','new-normal','btn_normal','exist-normal')">+</button>
                                </div>
                            </div>
                            <?php } endforeach;?>  
                            <div id="copyFormNormal"></div>  
                        </div> 
                    <?php } ?>                            
                        <div class="grid__item grid__item_item51 titel border_right">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan border_right"><textarea name="catatan_pasca_normal" class="textarea" cols="232" rows="3" disabled></textarea></div>
                        <div class="grid__item grid__item_item53 titel ">Masukan AMN jika ada kekeliruan</div>
                        <div class="grid__item grid__item_item54 titel border_right">Masukan MSB Jika ada kekeliruan</div>
                        <div class="grid__item grid__item_item55 inputan border_bottom"><textarea name="catatan_amn" class="textarea" cols="113" rows="5" style="" disabled><?= $data["catatan_amn"];?></textarea></div>
                        <div class="grid__item grid__item_item56 inputan border_right border_bottom"><textarea name="catatan_msb" class="textarea" cols="113" rows="5" style="" disabled><?= $data["catatan_msb"];?></textarea></textarea></div>
                    </div><br>
                        <button type="submit" name="submit" >Simpan Form</button>
                    </div>

                </form>
                <?php  } ?>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script type="text/javascript">

 //--table-jquery--//
        $(document).ready(function(){
            //--table_add/remove w/ number1--/

                // ======================================autocomplete lokasi==========================================
                $("#lokasi").keyup(function(){               
                var query = $("#lokasi").val();
                if (query.length > 1) {
                        $.ajax(
                            {
                                url: 'get_data_autocomplete_lokasi.php',
                                type: 'POST',
                                data: {
                                    //search: 1,
                                    q: query,
                                    id: $("#jenis").val()
                                },
                                success: function (data) {
                                    $("#response").html(data);
                                },
                                dataType: 'text'
                            }
                        );
                    }

                    $('#lokasinya').on('click', 'li', function () {
                        var lokasi = $(this).text();
                        $("#lokasi").val(lokasi);
                        $("#response").html("");
                });
                });

               

                
                $("#lokasiDetail").keyup(function(){
                    var queryDetail = $("#lokasiDetail").val();
                    if (queryDetail.length > 1) {
                        $.ajax(
                            {
                                url: 'get_data_autocomplete_lokasi_detail.php',
                                type: 'POST',
                                data: {
                                    q: queryDetail,
                                    id: $("#jenis").val(),
                                    val: $("#lokasi").val()
                                },
                                success: function(data) {
                                    $("#responseDetail").html(data);
                                },
                                dataType: 'text'
                            }
                        );
                    }

                    $('#detailnya').on('click', 'li', function () {
                        var lokasiDetail = $(this).text();
                        $("#lokasiDetail").val(lokasiDetail);
                        $("#responseDetail").html("");
                });

                });

                


        });
 
    var tabel1 = document.querySelectorAll("#table1 tr").length;
        var tabel2 = document.getElementById('table2');

    for(i=0; i<tabel1; i++){
        const newRow = document.createElement('tr');
        newRow.innerHTML = `<td></td><td></td>`;
        tabel2.appendChild(newRow);
}



    </script>
</body>
</html>
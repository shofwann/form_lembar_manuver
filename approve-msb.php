<?php
// session_start();
require 'functions.php';

$sql=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
$data=mysqli_fetch_assoc($sql);



if( isset($_POST["submit"]) ){

    if( aprovalMsb($_POST) > 0){
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
</head>
<body>
    <div class="card">
        <div class="card-header">
            Aproval AMN
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="" method="post">
                    <div class="hiden" >
                        <div class="col-1">
                            <label>ID Task:</label>
                            <input type="text" name="idTask" value="<?= $data['id']; ?>" class="form-control" readonly>
                            <label class="" style="width: 150px;">tanggal aprove:</label>
                            <input type="text" name="time" value="<?= date('d-M-Y H:i:s');?>" class="form-control" readonly>
                            <label>Status:</label>
                            <input type="text" name="status" placeholder="" value="<?= $data['status']; ?>" class="form-control" readonly>
                            <label>User MSB:</label>
                            <input type="text" name="userMSB" placeholder="" value="<?= $_SESSION['username'];?>" class="form-control" readonly>
                            <label for=""></label>
                            <label for="">level MSB</label>
                            <input type="text" name="level" value="<?= $_SESSION['level'];?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="grid">
                        <div class="grid__item_item01">
                            <div class="back">
                                <input type="button" value="Kembali" onclick="history.back()" style="">
                            </div>
                        </div>
                        <div class="grid__item grid__item_item02 titel">Creater</div>
                        <div class="grid__item grid__item_item03 titel border_right">Create Form</div>
                        <div class=" grid__item_item04 "></div>
                        <div class="grid__item grid__item_item05 inputan"><p><?= $data['user']; ?></p></div>
                        <div class="grid__item grid__item_item06 inputan border_right"><p><?= $data['create_date']; ?></p></div>
                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item_item1 titel">pekerjaan</div>
                        <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan</div>
                        <div class="grid__item grid__item_item3 titel">mulai</div>
                        <div class="grid__item grid__item_item4 titel" >selesai</div>
                        <div class="grid__item grid__item_item5 inputan"><p class="pt-2 pl-2"><?= $data["pekerjaan"]; ?></p></div>
                        <div class="grid__item grid__item_item6 inputan"><p class="pt-2 pl-2"><?= $dayList[date("D", strtotime($data["date"]))] ?>, <?= date(" d F Y", strtotime($data["date"])); ?></p></div>
                        <div class="grid__item grid__item_item7 inputan"><p class="pt-2 pl-2"><?= $dayList[date("D", strtotime($data["start"]))] ?>, <?= date("d F Y G:i",strtotime($data["start"])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item8 inputan"><p class="pt-2 pl-2"><?= $dayList[date("D", strtotime($data["end"]))] ?>, <?= date("d F Y G:i",strtotime($data["end"])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item9 titel">lokasi</div>
                        <div class="grid__item grid__item_item10 titel">installasi</div>
                        <div class="grid__item grid__item_item11 titel">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan"><p class="pt-2 pl-2"><?= strtoupper($data["lokasi"]); ?></p></div>
                        <div class="grid__item grid__item_item13 inputan"><p class="pt-2 pl-2"><?= strtoupper($data["installasi"]); ?></p></div>
                        <div class="grid__item grid__item_item14 inputan"><input type="datetime-local" name="report_date" id="report_date" class="form-control" style="" disabled></div>
                        <div class="grid__item grid__item_item15 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item16 titel">MANUVER PENORMALAN INSTALLASI</div>
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
                                       
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item20 inputan">
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
                        <div class="grid__item grid__item_item22 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DINORMALKAN</div>
                        <div class="grid__item grid__item_item23 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item24 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item25 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item26 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item27 inputan"><input type="text" style="" disabled></div>
                        <div class="grid__item grid__item_item28 inputan"><input type="text" style="" disabled></div>
                        <div class="grid__item grid__item_item29 inputan"><input type="text" style="" disabled></div>
                        <div class="grid__item grid__item_item30 inputan"><input type="text" style="" disabled></div>
                        <div class="grid__item grid__item_item31 titel">ALIRAN DAYA SETELAH DIBEBASKAN</div>
                        <div class="grid__item grid__item_item32 titel">ALIRAN DAYA SETELAH DINORMALKAN</div>
                        <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item34 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item35 inputan"><input type="text" style="" disabled></div>
                        <div class="grid__item grid__item_item36 inputan"><input type="text" style="" disabled></div>
                        <div class="grid__item grid__item_item37 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel">Catatan Pra Pembebasan</div>
                        <div class="grid__item grid__item_item39 inputan"><textarea name="catatan_pra_bebas" class="textarea" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_pembebasan"];?></textarea></div>
                        <div class="grid__item grid__item_item40 titel">Tahapan Manuver Pembebasan</div>
                    <?php if ($data["jenis_form"] == 1 ) {  ?>
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
                                        foreach (unserialize($data["emergency_bebas"])  ? : []  as $row) :
                                            for($j = 0; $j < count((is_countable($row["lokasiManuverBebas"])?$row["lokasiManuverBebas"]:[])); $j++){
                                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['lokasiManuverBebas'][$j] ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
                                <h3 style='valign = center;'><?= $row["titelBebas"][$i] ?></h3>
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
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
                        <div class="grid__item grid__item_item44 inputan"><textarea name="catatan_pasca_bebas" class="textarea" cols="232" rows="3" style="" disabled></textarea></div>
                        <div class="grid__item grid__item_item45 titel">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan"><textarea name="catatan_pra_normal" class="textarea" cols="232" rows="3" style="color:red;"  disabled><?= $data["catatan_pra_penormalan"];?></textarea></div>
                        <div class="grid__item grid__item_item48 titel">Tahapan Manuver Penormalan :</div>
                    <?php if ($data["jenis_form"] == 1 ) { ?>
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
                                    <th style="width:9rem;">Remote</th>
                                    <th style="width:9rem;">Real (R/L)</th>
                                    <th style="width:9rem;">ADS</th>
                                </tr>
                                   

                                    <?php $i=1; ?>
                                    <?php 
                                        foreach (unserialize($data["emergency_normal"])  ? : []  as $row) :
                                            for($j = 0; $j < count((is_countable($row["lokasiManuverNormal"])?$row["lokasiManuverNormal"]:[])); $j++){
                                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['lokasiManuverNormal'][$j] ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?= $row['installManuverNormal'][$j] ?></td>
                                    
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
                            <?php //var_dump(unserialize($data["emergency_normal"]));
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
                        <div class="grid__item grid__item_item51 titel">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan"><textarea name="catatan_pasca_normal" class="textarea" cols="232" rows="3" style="" disabled></textarea></div>
                        <div class="grid__item grid__item_item53 titel">Masukan AMN jika ada kekeliruan</div>
                        <div class="grid__item grid__item_item54 titel">Masukan MSB Jika ada kekeliruan</div>
                        <div class="grid__item grid__item_item55 inputan"><textarea name="catatan_amn" class="textarea" cols="113" rows="5" style=""disabled><?= $data["catatan_amn"];?></textarea></div>
                        <div class="grid__item grid__item_item56 inputan"><textarea name="catatan_msb" class="textarea" cols="113" rows="5" style=""><?= $data["catatan_msb"];?></textarea></div>

                        <div class="grid__item grid__item_item57 inputan">
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
    <script>
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
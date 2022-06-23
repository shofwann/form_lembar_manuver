<?php
require 'functions.php';

$sql=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
$data=mysqli_fetch_assoc($sql);




if( isset($_POST["submit"]) ){

    if( inputDispaAwal ($_POST) > 0){
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
                        <input type="text" name="dateAprove" class="form-control" value="<?= date('d-M-Y H:i:s'); ?>" readonly>
                        <label>User Dispa :</label>
                        <input type="text" name="userdispa" placeholder="" value="<?= $_SESSION['username'];?>" class="form-control" readonly>  
                        <label for="fotoLama" class="control-label">foto</label>
                        <input type="text" name="fotoLama" id="fotoLama" class="form-control" value="<?= $data["foto_dpf1"]; ?>" readonly> <!--untuk menyimpan foto lama, jika user tidak ganti foto maka foto ini yg digunakan-->
                        <input type="text" name="status" id="status" value="<?= $data["status"]; ?>">
                        <input type="text" name="user" id="user" value="<?= $data["user"] ?>">
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
                        <div class="grid__item grid__item_item4 titel border_right" >selesai<span>*</span></div>
                        <div class="grid__item grid__item_item5 inputan"><p><?= $data["pekerjaan"]; ?></p></div>
                        <div class="grid__item grid__item_item6 inputan"><p class="pt-2 pl-2"><?= $dayList[date("D", strtotime($data["date"]))] ?>, <?= date(" d F Y", strtotime($data["date"])); ?></p></div>
                        <div class="grid__item grid__item_item7 inputan"><p class="pt-2 pl-2"><?= $dayList[date("D", strtotime($data["start"]))] ?>, <?= date("d F Y G:i",strtotime($data["start"])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item8 inputan border_right"><p class="pt-2 pl-2"><?= $dayList[date("D", strtotime($data["end"]))] ?>, <?= date("d F Y G:i",strtotime($data["end"])); ?> WIB</p></div>
                        <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                        <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                        <div class="grid__item grid__item_item11 titel border_right">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan"><p><?= strtoupper($data["lokasi"]); ?></p></div>
                        <div class="grid__item grid__item_item13 inputan"><p><?= strtoupper($data["installasi"]); ?></p></div>
                        <div class="grid__item grid__item_item14 inputan border_right"><input type="datetime-local" value="<?= date('Y-m-d\TH:i:s', strtotime($data['report_date'])); ?>" name="report_date" id="report_date" required></div>
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
                                                    <td><input type="text" name="lokasiPembebasan[]" value="<?= isset($row['lokasiPembebasan'][$j]) ? $row['lokasiPembebasan'][$j] : '' ?>" readonly></td>
                                                    <td><input type="text" name="peng_pekerjaan[]" value="<?= isset($row['peng_pekerjaan'][$j]) ? $row['peng_pekerjaan'][$j] : '' ?>" placeholder='nama pengawas' required></td>
                                                    <td><input type="text" name="peng_manuver[]" value="<?= isset($row['peng_manuver'][$j]) ? $row['peng_manuver'][$j] : '' ?>" placeholder='nama pengawas' required></td>
                                                    <td><input type="text" name="peng_k3[]" value="<?= isset($row['peng_k3'][$j]) ? $row['peng_k3'][$j] : '' ?>" placeholder='nama pengawas' required></td>
                                                    <td><input type="text" name="spv[]" value="<?= isset($row['spv'][$j]) ? $row['spv'][$j] : '' ?>" placeholder='nama SPV' required></td>
                                                    <td><input type="text" name="opr[]" value="<?= isset($row['opr'][$j]) ? $row['opr'][$j] : '' ?>" placeholder='nama Operator' required></td>
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
                       
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item20 inputan border_right">
                        <?php $cekbok = explode(",", $data["document"]); ?> 
                        <div class="col">
                            <br>
                                    <div action="">
                                        <input type="checkbox" id="wp" name="document[]" value="wp" <?php in_array('wp', $cekbok) ? print 'checked' : ' '; ?> required>
                                        <label for="wp">Working Permit</label><br>
                                        <input type="checkbox" id="ik" name="document[]" value="ik" <?php in_array('ik', $cekbok) ? print 'checked' : ' '; ?> >
                                        <label for="ik"> IK</label><br>
                                        <input type="checkbox" id="k3" name="document[]" value="k3" <?php in_array('k3', $cekbok) ? print 'checked' : ' '; ?> >
                                        <label for="k3"> K3</label><br>
                                    </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item21 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DIBEBASKAN</div>
                        <div class="grid__item grid__item_item22 titel border_right">ALIRAN DAYA PADA INSTALLASI MENJELANG DINORMALKAN</div>
                        <div class="grid__item grid__item_item23 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item24 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item25 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item26 titel border_right">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item27 inputan"><input type="text" name="scada_awal_before" value="<?= $data["scada_awal_before"]; ?>" style="font-style:italic;width:300px;" placeholder="Fill in Mw MVar Amper Volt" required></div>
                        <div class="grid__item grid__item_item28 inputan"><input type="text" name="dpf_awal" value="<?= $data["dpf_awal"]; ?>" style="font-style:italic;width:300px;" placeholder="Fill in Mw MVar Amper Volt" required><input type="file" id="foto1" name="dpfFile_awal" required><p><?= $data["foto_dpf1"] ? '<button type="button" data-modal="modal1" class="modal-open"><i class="fa fa-eye"></i></button>' : '<span style="color:red">Belum upload</span>'; ?></p>
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
                        <div class="grid__item grid__item_item29 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item30 inputan border_right"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item31 titel">ALIRAN DAYA SETELAH DIBEBASKAN</div>
                        <div class="grid__item grid__item_item32 titel border_right">ALIRAN DAYA SETELAH DINORMALKAN</div>
                        <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item34 titel border_right">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item35 inputan"><input type="text" name="scada_awal_after" value="<?= $data["scada_awal_after"]; ?>" style="width:300px; font-style:italic;" placeholder="Fill in Mw MVar Amper Volt" required></div>
                        <div class="grid__item grid__item_item36 inputan border_right"><h6 class="pt-4 pl-2" disabled><?= $data["scada_akhir_after"]; ?></h6></div>
                        <div class="grid__item grid__item_item37 titel border_right">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel border_right">Catatan Pra Pembebasan</div>
                        <div class="grid__item grid__item_item39 inputan border_right"><textarea name="catatan_pra_bebas" class="textarea" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_pembebasan"];?></textarea></div>
                        <div class="grid__item grid__item_item40 titel border_right">Tahapan Manuver Pembebasan</div>
                        <div class="grid__item grid__item_item41 inputan">
                            <div class="form-group ml-2">
                                <img src="img/<?= $data["foto"];?>" id="output1" height="auto" width="900px" style="padding-top:.50rem;padding-right:.50rem"><br>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item42 inputan border_right">
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
                                                for($j = 0; $j < count($row["lokasiManuverBebas"]); $j++){
                                        ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><input type="text" name="lokasiManuverBebas[]" value="<?= $row['lokasiManuverBebas'][$j] ?>" readonly></td>
                                    <td><input type="time" name="remote_bebas[]" value="<?= isset($row['remote_bebas'][$j]) ? $row['remote_bebas'][$j] : '' ?>"></td>
                                    <td><input type="time" name="real_bebas[]" value="<?= isset($row['real_bebas'][$j]) ? $row['real_bebas'][$j] : '' ?>"></td>
                                    <td><input type="time" name="ads_bebas[]" value="<?= isset($row['ads_bebas'][$j]) ? $row['real_bebas'][$j] : '' ?>"></td>
                                    <td><input type="text" name="installManuverBebas[]" value="<?= $row['installManuverBebas'][$j] ?>" readonly></td>
                                    
                                </tr>
                                        <?php 
                                            $i++;
                                            }
                                            endforeach
                                        ?>
                                </table>
                        </div>
                        <div class="grid__item grid__item_item43 titel border_right">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item44 inputan border_right"><textarea name="catatan_pasca_bebas" class="textarea" cols="232" rows="3" style="" placeholder="Masukan Catatan..." required><?= $data["catatan_pasca_pembebasan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item45 titel border_right">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel border_right">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan border_right"><textarea name="catatan_pra_normal" class="textarea" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_penormalan"];?></textarea></div>
                        <div class="grid__item grid__item_item48 titel border_right">Tahapan Manuver Penormalan :</div>
                        <div class="grid__item grid__item_item49 inputan">
                            <div class="form-group ml-2">
                                <img src="img/<?= $data["foto2"];?>" id="output2" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
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
                                            for($j = 0; $j < count((is_countable($row["lokasiManuverNormal"])?$row["lokasiManuverNormal"]:[])); $j++){
                                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><input type="text" name="lokasiManuverNormal[]" value="<?= $row['lokasiManuverNormal'][$j] ?>" readonly></td>
                                    <td><input type="time" name="remote_Normal[]" value="<?= $row['remote_bebas'][$j] ?>" readonly></td>
                                    <td><input type="time" name="real_Normal[]" value="<?= $row['real_bebas'][$j] ?>" readonly></td>
                                    <td><input type="time" name="ads_Normal[]" value="<?= $row['ads_bebas'][$j] ?>" readonly></td>
                                    <td><input type="text" name="installManuverNormal[]" value="<?= $row['installManuverNormal'][$j] ?>" readonly></td>
                                    
                                </tr>
                                    <?php 
                                        $i++;
                                        }
                                        endforeach
                                    ?>

                                
                            </table>
                        </div>
                        <div class="grid__item grid__item_item51 titel border_right">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan border_right border_bottom"><textarea name="catatan_pasca_normal" class="textarea" cols="232" rows="3" disabled><?= $data["catatan_pasca_penormalan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item53 titel catatan" >Catatan AMN Dispa Awal</div>
                        <div class="grid__item grid__item_item54 titel catatan border_right" >Catatan AMN Dispa Akhir</div>
                        <div class="grid__item grid__item_item55 inputan catatan" ><textarea name="catatan_amndis_awal" class="textarea" cols="113" rows="5" style="" disabled><?= $data["catatan_amnDispa_awal"]; ?></textarea></div>
                        <div class="grid__item grid__item_item56 inputan catatan border_right " ><textarea name="catatan_amndis_akhir" class="textarea" cols="113" rows="5" style="" disabled></textarea></div>
                    </div><br>
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
    var catatan =  document.getElementsByClassName("catatan");
    var status = document.getElementById("status").value;
    var isiFoto = document.getElementById("fotoLama").value;
    var foto = document.getElementById("foto1")

    if (isiFoto != "") {
        foto.required= false;
    }

    if (status == 'dispaAwal'){
        for (var i = 0; i<catatan.length; i++)
        catatan[i].style.display = 'none';
    }

    const jumRowstabel1 = document.querySelector('#table1').rows.length;
    let tabel2 =document.querySelector('#table2')
    //let status = document.getElementById('status').value;
    
    let dataArray = ['amnUbah','amn','msb','msbUbah','dispa','dispaAwalUbah','dispaAwal']

    if(dataArray.indexOf(status) !== -1){
        for(i=0; i<jumRowstabel1; i++){
            const newRow = document.createElement('tr');
            newRow.innerHTML = `<td></td><td></td>`;
            tabel2.appendChild(newRow);
        }
    } else{
        console.log("Value does not exists!")
    }
</script>
</body>
</html>
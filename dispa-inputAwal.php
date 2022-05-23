<?php
require 'functions.php';
$sql_manuver_petugas=mysqli_query($conn,"SELECT * FROM db_table_pengawas WHERE id_form='$_GET[id]'");
$sql_manuver_petugas2=mysqli_query($conn,"SELECT * FROM db_table_pengawas WHERE id_form='$_GET[id]'");
$tahapan_manuver_pembebasan=mysqli_query($conn,"SELECT * FROM db_table_tahapan WHERE id_form='$_GET[id]' AND tahapan = 'pembebasan'");
$tahapan_manuver_penormalan=mysqli_query($conn,"SELECT * FROM db_table_tahapan WHERE id_form='$_GET[id]' AND tahapan = 'penormalan'");
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
                    <dive class="hiden">
                        <label for="id" class="control-label">id</label>
                        <input type="text" name="idTask" id="idTask" class="form-control" value="<?= $data["id"]; ?>" readonly>
                        <label>Aproval date</label>
                        <input type="text" name="dateAprove" class="form-control" value="<?= date('d-M-Y H:i:s'); ?>" readonly>
                        <label>User Dispa :</label>
                        <input type="text" name="userdispa" placeholder="" value="<?= $_SESSION['username'];?>" class="form-control" readonly>  
                        <label for="fotoLama" class="control-label">foto</label>
                        <input type="text" name="fotoLama" id="fotoLama" class="form-control" value="<?= $data["foto_dpf1"]; ?>" readonly> <!--untuk menyimpan foto lama, jika user tidak ganti foto maka foto ini yg digunakan-->
                        <input type="text" name="status" id="status" value="<?= $data["status"]; ?>">
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
                        <div class="grid__item grid__item_item6 inputan"><p><?= date('l, d-F-Y', strtotime($data["date"])); ?></p></div>
                        <div class="grid__item grid__item_item7 inputan"><?= date('d-F-Y\ H:i:s', strtotime($data['start'])); ?>   WIB</div>
                        <div class="grid__item grid__item_item8 inputan"><?= date('d-F-Y\ H:i:s', strtotime($data['end'])); ?> WIB</div>
                        <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                        <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                        <div class="grid__item grid__item_item11 titel">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan"><p><?= $data["lokasi"]; ?></p></div>
                        <div class="grid__item grid__item_item13 inputan"><p><?= $data["installasi"]; ?></p></div>
                        <div class="grid__item grid__item_item14 inputan"><input type="datetime-local" value="<?= date('Y-m-d\TH:i:s', strtotime($data['report_date'])); ?>" name="report_date" id="report_date" required></div>
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
                                        <?php while ($manuverBebas = mysqli_fetch_array($sql_manuver_petugas)) { ?>
                                                <tr>
                                                    <td><?= $manuverBebas["lokasi"]  ?></td>
                                                    <td><input type="text" name="peng_pekerjaan[]" value="<?= $manuverBebas["pengawas_pekerjaan"]  ?>" required><input type="text" name="sampel[]" value="<?= $manuverBebas["id"]  ?>" hidden></td>
                                                    <td><input type="text" name="peng_manuver[]" value="<?= $manuverBebas["pengawas_manuver"]  ?>" required></td>
                                                    <td><input type="text" name="peng_k3[]" value="<?= $manuverBebas["pengawas_k3"]  ?>" required></td>
                                                    <td><input type="text" name="spv[]" value="<?= $manuverBebas["spv_gitet"]  ?>" required></td>
                                                    <td><input type="text" name="opr[]" value="<?= $manuverBebas["opr_gitet"]  ?>" required></td>
                                                </tr>
                                        <?php } ?> 
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
                                            <?php while ($manuverNormal = mysqli_fetch_array($sql_manuver_petugas2)) { ?>
                                                    <tr>
                                                        <td><?= $manuverNormal["spv_gitet_normal"]  ?></td>
                                                        <td><?= $manuverNormal["opr_gitet_normal"]  ?></td>
                                                    </tr>
                                            <?php } ?> 

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
                                        <input type="checkbox" id="wp" name="document[]" value="wp" <?php in_array('wp', $cekbok) ? print 'checked' : ' '; ?> required>
                                        <label for="wp">wp</label><br>
                                        <input type="checkbox" id="ik" name="document[]" value="ik" <?php in_array('ik', $cekbok) ? print 'checked' : ' '; ?> >
                                        <label for="ik"> IK</label><br>
                                        <input type="checkbox" id="k3" name="document[]" value="k3" <?php in_array('k3', $cekbok) ? print 'checked' : ' '; ?> >
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
                        <div class="grid__item grid__item_item27 inputan"><input type="text" name="scada_awal_before" value="<?= $data["scada_awal_before"]; ?>" style="font-style:italic;width:300px;" placeholder="Fill in Mw MVar Amper Volt" required></div>
                        <div class="grid__item grid__item_item28 inputan"><input type="text" name="dpf_awal" value="<?= $data["dpf_awal"]; ?>" style="font-style:italic;width:300px;" placeholder="Fill in Mw MVar Amper Volt" required><input type="file" id="foto1" name="dpfFile_awal" required><p><?= $data["foto_dpf1"]; ?></p></div>
                        <div class="grid__item grid__item_item29 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item30 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item31 titel">ALIRAN DAYA SETELAH DIBEBASKAN</div>
                        <div class="grid__item grid__item_item32 titel">ALIRAN DAYA SETELAH DINORMALKAN</div>
                        <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item34 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item35 inputan"><input type="text" name="scada_awal_after" value="<?= $data["scada_awal_after"]; ?>" style="width:300px; font-style:italic;" placeholder="Fill in Mw MVar Amper Volt" required></div>
                        <div class="grid__item grid__item_item36 inputan"><h6 class="pt-4 pl-2" disabled><?= $data["scada_akhir_after"]; ?></h6></div>
                        <div class="grid__item grid__item_item37 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel">Catatan Pra Pembebasan</div>
                        <div class="grid__item grid__item_item39 inputan"><textarea name="catatan_pra_bebas" id="" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_pembebasan"];?></textarea></div>
                        <div class="grid__item grid__item_item40 titel">Tahapan Manuver Pembebasan</div>
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
                                    <?php while ($pembebasan = mysqli_fetch_assoc($tahapan_manuver_pembebasan) ) : ?>
                                <tr id="">
                                    <td><?= $i ?></td>
                                    <td><?= $pembebasan["lokasi"]  ?></td>
                                    <td><?= $pembebasan["remote_"] == "00:00:00" ? "<input type='time' value='<?= time(); ?>' name='remote_bebas[]'>" : "<input type='time' value='". $pembebasan['remote_']."' name='remote_bebas[]'>" ?> <input type="text" name="sampel_manuver[]" value="<?= $pembebasan["id"]  ?>" hidden> WIB</td>
                                    <td><?= $pembebasan["real_"] == "00:00:00" ? "<input type='time' value='<?= time(); ?>' name='real_bebas[]'>" : "<input type='time' value='". $pembebasan['real_']."' name='real_bebas[]'>" ?> WIB</td>
                                    <td><?= $pembebasan["ads"] == "00:00:00" ? "<input type='time' value='<?= time(); ?>' name='ads_bebas[]'>" : "<input type='time' value='". $pembebasan['ads']."' name='ads_bebas[]'>" ?> WIB</td>                  <!--  <input type="time" value="<?= time(); ?>" name="ads_bebas[]"> -->
                                    <td style="width:10px"><?= $pembebasan["installasi"]  ?></td>
                                </tr>
                                    <?php $i++ ?>
                                    <?php endwhile; ?>
                                </table>
                        </div>
                        <div class="grid__item grid__item_item43 titel">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item44 inputan"><textarea name="catatan_pasca_bebas" id="" cols="232" rows="3" style="" placeholder="Masukan Catatan..."><?= $data["catatan_pasca_pembebasan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item45 titel">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan"><textarea name="catatan_pra_normal" id="" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_penormalan"];?></textarea></div>
                        <div class="grid__item grid__item_item48 titel">Tahapan Manuver Penormalan :</div>
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
                                <?php while ($penormalan = mysqli_fetch_assoc($tahapan_manuver_penormalan) ) : ?>
                                    <tr id="redDua">
                                        <td><?= $i ?></td>
                                        <td><?= $penormalan["lokasi"]  ?></td>
                                        <td><?= $penormalan["remote_"] == "00:00:00" ? "" : $penormalan["remote"] ; ?></td>
                                        <td><?= $penormalan["real_"] == "00:00:00" ? "" : $penormalan["real_"] ; ?></td>
                                        <td><?= $penormalan["ads"] == "00:00:00" ? "" : $penormalan["ads"] ; ?></td>
                                        <td><?= $penormalan["installasi"]  ?></td>
                                    </tr>
                                <?php $i++ ?>
                                <?php endwhile; ?>
                            </table>
                        </div>
                        <div class="grid__item grid__item_item51 titel">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan"><textarea name="catatan_pasca_normal" id="" cols="232" rows="3" disabled><?= $data["catatan_pasca_penormalan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item53 titel catatan" >Catatan AMN Dispa Awal</div>
                        <div class="grid__item grid__item_item54 titel catatan" >Catatan AMN Dispa Akhir</div>
                        <div class="grid__item grid__item_item55 inputan catatan" ><textarea name="catatan_amndis_awal" id="" cols="113" rows="5" style="" disabled><?= $data["catatan_amnDispa_awal"]; ?></textarea></div>
                        <div class="grid__item grid__item_item56 inputan catatan" ><textarea name="catatan_amndis_akhir" id="" cols="113" rows="5" style="" disabled></textarea></div>
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

</script>
<script src="js/script.js"></script>
</body>
</html>
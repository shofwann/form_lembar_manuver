<?php


if (!isset($_SESSION["username"])) {
	echo "<script>Anda Belum Login</script>";
  header("location:index.php");
	exit;
}

if ($_SESSION["level"] != "dispa") {
    echo "<script>Mohon Logout dahulu !!</script>";
    header("location:index.php");
    exit;

}



require "functions.php";

$petugas_gitet_bebas = mysqli_query($conn,"SELECT * FROM db_ajax_table_pengawas WHERE id_lokasi_detail = '$_GET[idz]'");
$petugas_gitet_normal = mysqli_query($conn,"SELECT * FROM db_ajax_table_pengawas WHERE id_lokasi_detail = '$_GET[idz]'");
$tahapan_manuver_pembebasan = mysqli_query($conn, "SELECT * FROM db_ajax_table_tahapan WHERE id_lokasi_detail='$_GET[idz]' AND tahapan ='pembebasan'");
$tahapan_manuver_penormalan=mysqli_query($conn,"SELECT * FROM db_ajax_table_tahapan WHERE id_lokasi_detail='$_GET[idz]' AND tahapan ='penormalan' "); //table4

$query2 = mysqli_query($conn,"SELECT id FROM db_form ORDER BY id DESC LIMIT 1");
$idnext = mysqli_fetch_array($query2);

$sql_data1 = mysqli_query($conn, "SELECT * FROM db_ajax_lokasi WHERE id_lokasi= '$_GET[idy]'");
$data1=mysqli_fetch_assoc($sql_data1);

$sql_data2 = mysqli_query($conn, "SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi_detail= '$_GET[idz]'");
$data2=mysqli_fetch_assoc($sql_data2);


// $dataAjax = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis=$_GET[idx] AND db_ajax_lokasi.id_lokasi= $_GET[idy] AND db_ajax_lokasi_detail.id_lokasi_detail=$_GET[idz]");
// $cekData = mysqli_num_rows($dataAjax);

// if ($cekData == 1 ) {
//     $isiajax = mysqli_fetch_assoc($dataAjax);
//     $query = mysqli_query($conn,"SELECT * FROM db_ajax_table_pengawas WHERE id_lokasi_detail=35");
//     $query2 = mysqli_query($conn,"SELECT * FROM db_ajax_table_tahapan WHERE id_lokasi_detail=$_GET[idz] AND tahapan='pembebasan'");
//     $query3 = mysqli_query($conn,"SELECT * FROM db_ajax_table_tahapan WHERE id_lokasi_detail=$_GET[idz] AND tahapan='penormalan'");
// }





if( isset($_POST["submit"]) ){

    if( tambahEmergency($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                //document.location.href = 'home.php';
                </script>
                ";  
                
    } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                //document.location.href = 'home.php';
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
  <title>Document</title>
</head>
<body>
  <div class="card">
    <div class="card-header">
        Form Auto-1
    </div>
    <div class="container-wrap">
      <div class="container">
        <form action="" method="post" enctype="multipart/form-data" id="form_id" >
                        <div class="additional">
                            <div class="default">
                                <label>ID Task:</label>
                                <input type="text" name="idTask" value="<?= $idnext['id']+1; ?>" class="form-control" readonly>
                                <label>User :</label>
                                <input type="text" name="user" placeholder="" value="<?= $_SESSION['username'];?>" class="form-control" readonly>
                                <label class="" style="width: 150px;">Create Date:</label>
                                <input type="text" name="create_date" value="<?= date('d-M-Y H:i:s');?>" class="form-control" readonly>
                                <input type="text" value="<?= $_SESSION['level'];?>" id="level">
                                <input type="text" value="" id="statusJob">
                            </div>
                            <div class="chose">
                                <!-- <label for="" style="">Pilih jenis pekerjaan :</label>
                                <select name="jenis_pekerjaan" id="jenis" style="margin-right: 30px;" required>
                                    <option value="">-SELECT-</option>
                                    <option value="1" <?php // if ($_GET["idx"]== 1 ) echo 'selected="selected"'; ?>>SUTET</option>
                                    <option value="3" <?php //if ($_GET["idx"]== 3 ) echo 'selected="selected"'; ?>>IBT</option>
                                    <option value="4" <?php //if ($_GET["idx"]== 4 ) echo 'selected="selected"'; ?>>BUSBAR</option>
                                    <option value="5" <?php //if ($_GET["idx"]== 5 ) echo 'selected="selected"'; ?>>REACTOR</option>
                                </select>
                                <label for="">Apakah anda mau MERUBAH form ke DB?</label>
                                <input id="toggle-on" class="toggle toggle-left" name="chose_db" value="0" type="radio" >
                                <label for="toggle-on" class="btnn">No</label>
                                <input id="toggle-off" class="toggle toggle-right" name="chose_db" value="2" type="radio" checked>
                                <label for="toggle-off" class="btnn">Yes</label> -->
                            </div>
                            
                        </div>
                        <div class="grid">
                            <div class="grid__item grid__item_item1 titel">pekerjaan<span>*</span></div>
                            <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan<span>*</span></div>
                            <div class="grid__item grid__item_item3 titel">mulai<span>*</span></div>
                            <div class="grid__item grid__item_item4 titel" >selesai<span>*</span></div>
                            <div class="grid__item grid__item_item5 inputan"><input type="text" name="pekerjaan" id="pekerjaan" class="form-control" placeholder="masukkan judul pekerjaan"></div>
                            <div class="grid__item grid__item_item6 inputan"><input type="date" name="date" id="start_date" class="form-control" ></div>
                            <div class="grid__item grid__item_item7 inputan"><input type="datetime-local" name="start" id="end_date"  ></div>
                            <div class="grid__item grid__item_item8 inputan"><input type="datetime-local" name="end" id="report_date"  ></div>
                            <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                            <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                            <div class="grid__item grid__item_item11 titel">permintaan pembebanan diterima</div>
                            <div class="grid__item grid__item_item12 inputan"><input type="text" value="<?= strtoupper($data1["nama"]); ?>" name="lokasi" id="lokasi" class="form-control"></div>
                            <div class="grid__item grid__item_item13 inputan"><input type="text" value="<?= strtoupper($data2["nama"]) ?>"name="instal" id="instal" class="form-control"></div>
                            <div class="grid__item grid__item_item14 inputan"><input type="datetime-local" name="report_date" id="report_date" class="form-control" disabled></div>
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
                                                <?php while ($manuverBebas = mysqli_fetch_assoc($petugas_gitet_bebas)) {?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="lokasiPembebasan[]" value="<?= $manuverBebas["lokasi"]; ?>">
                                                        </td>
                                                        <td><input type='text' name='peng_pekerjaan[]' placeholder='nama pengawas' class='disabled' autocomplete='off'></td>
                                                        <td><input type='text' name='peng_manuver[]' placeholder='nama pengawas' class='disabled' autocomplete='off'></td>
                                                        <td><input type='text' name='peng_k3[]' class='disabled' placeholder='nama pengawas' autocomplete='off'></td>
                                                        <td><input type='text' name='spv[]' class='disabled' placeholder='nama SPV' autocomplete='off'></td>
                                                        <td><input type='text' name='opr[]' class='disabled' placeholder='nama Operator' autocomplete='off'></td>
                                                    </tr>
                                                <?php }?>
                                            </tbody>
                                            <tfoot>
                                                
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
                                            <?php while ($manuverNormal = mysqli_fetch_array($petugas_gitet_normal)) { ?>
                                                <tr>
                                                    <td><?= $manuverNormal["opr_gitet_normal"]  ?></td>
                                                    <td></td>
                                                </tr>
                                                <?php } ?> 

                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="grid__item grid__item_item20 inputan">
                                <br>
                                <div action="">
                                    <input type="checkbox" name="surat" value="" > 
                                    <label for="surat">Surat Emergency</label> <input type="file" name="pdf"><br>
                                    <input type="checkbox" name="wp" value="wp" >
                                    <label for="wp"> WP</label><br>
                                    <input type="checkbox" name="ik" value="ik" >
                                    <label for="ik"> IK</label><br>
                                    <input type="checkbox" name="k3" value="k3" >
                                    <label for="k3"> K3</label><br>
                                </div>
                            </div>
                            <div class="grid__item grid__item_item21 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DIBEBASKAN</div>
                            <div class="grid__item grid__item_item22 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DINORMALKAN</div>
                            <div class="grid__item grid__item_item23 titel">Pembacaan SCADA</div>
                            <div class="grid__item grid__item_item24 titel">Hasil Studi DPF</div>
                            <div class="grid__item grid__item_item25 titel">Pembacaan SCADA</div>
                            <div class="grid__item grid__item_item26 titel">Hasil Studi DPF</div>
                            <div class="grid__item grid__item_item27 inputan"><input type="text" name="scada_awal_before" placeholder="Fill in Mw MVar Amper Volt"></div>
                            <div class="grid__item grid__item_item28 inputan"><input type="text" name="dpf_awal" placeholder="Fill in Mw MVar Amper Volt" required><input type="file" name="dpfFile_awal" id="foto1"></div>
                            <div class="grid__item grid__item_item29 inputan"><input type="text" disabled></div>
                            <div class="grid__item grid__item_item30 inputan"><input type="text" disabled></div>
                            <div class="grid__item grid__item_item31 titel">ALIRAN DAYA SETELAH DIBEBASKAN</div>
                            <div class="grid__item grid__item_item32 titel">ALIRAN DAYA SETELAH DINORMALKAN</div>
                            <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                            <div class="grid__item grid__item_item34 titel">Pembacaan SCADA</div>
                            <div class="grid__item grid__item_item35 inputan"><input type="text" name="scada_awal_after" style="width:300px; font-style:italic;" placeholder="Fill in Mw MVar Amper Volt" required></div>
                            <div class="grid__item grid__item_item36 inputan"><input type="text" ></div>
                            <div class="grid__item grid__item_item37 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                            <div class="grid__item grid__item_item38 titel">Catatan Pra Pembebasan<span>*</span></div>
                            <div class="grid__item grid__item_item39 inputan"><textarea name="catatan_pra_bebas" id="" cols="232" rows="3"></textarea></div>
                            <div class="grid__item grid__item_item40 titel">Tahapan Manuver Pembebasan<span>*</span></div>
                            <div class="grid__item grid__item_item41 inputan">
                                <div class="form-group ml-2">
                                    <img id="output1" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                    <input type="file" accept="image/*" onchange="" name="foto" required="required">
                                </div>
                            </div>
                            <div class="grid__item grid__item_item42 inputan">
                                <table class="table table-bordered mt-2" id="dynamic_field1" style="">
                                    
                                        <tr>
                                            <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                            <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                            <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                            <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                            <th rowspan="2"><button type="button" name="add3" id="add3" class="btn green" onclick="tambahManuver('dynamic_field1','lokasiManuverBebas[]','installManuverBebas[]','id_update_bebas[]',jumlah_baris)">Add More</button></th>
                                        </tr>
                                        <tr>
                                            <th style="width:9rem;">Remote</th>
                                            <th style="width:9rem;">Real (R/L)</th>
                                            <th style="width:9rem;">ADS</th>
                                        </tr>
                                    
                                    
                                            <?php $i=1; ?>
                                            <?php while ($pembebasan = mysqli_fetch_assoc($tahapan_manuver_pembebasan) ) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><input type="text" name="lokasiManuverBebas[]" value="<?= $pembebasan["lokasi"] ?>" style="width:8rem;padding:0rem;" required></td>
                                            <td><?= $pembebasan["remote_"] == "00:00:00" ? "<input type='time' value='<?= time(); ?>' name='remote_bebas[]'>" : "<input type='time' value='". $pembebasan['remote_']."' name='remote_bebas[]'>" ?></td>
                                            <td><?= $pembebasan["real_"] == "00:00:00" ? "<input type='time' value='<?= time(); ?>' name='real_bebas[]'>" : "<input type='time' value='". $pembebasan['real_']."' name='real_bebas[]'>" ?></td>
                                            <td><?= $pembebasan["ads"] == "00:00:00" ? "<input type='time' value='<?= time(); ?>' name='ads_bebas[]'>" : "<input type='time' value='". $pembebasan['ads']."' name='ads_bebas[]'>" ?></td>
                                            <td><input type="text" name="installManuverBebas[]" value="<?= $pembebasan["installasi"] ?>" style="width:8rem;padding:0rem;" required></td>
                                            <td>
                                                <button type="button" onclick="hapus_baris(this,'id_ajax_hapus_bebas[]')" class="btn btn-danger btn_remove">X</button> 
                                                <input type="text" name="id_update_bebas[]" value="<?= $pembebasan["id"] ?>" >
                                            </td>
                                        </tr>
                                            <?php $i++ ?>
                                            <?php endwhile; ?>
                                    
                                </table>
                            </div>
                            <div class="grid__item grid__item_item43 titel">Catatan Pasca Pembebasan :</div>
                            <div class="grid__item grid__item_item44 inputan"><textarea name="catatan_pasca_bebas" id="" cols="232" rows="3" disabled></textarea></div>
                            <div class="grid__item grid__item_item45 titel">MANUVER PENORMALAN INSTALLASI</div>
                            <div class="grid__item grid__item_item46 titel">Catatan Pra Penormalan :</div>
                            <div class="grid__item grid__item_item47 inputan"><textarea name="catatan_pra_normal" id="" cols="232" rows="3"></textarea></div>
                            <div class="grid__item grid__item_item48 titel">Tahapan Manuver Penormalan :</div>
                            <div class="grid__item grid__item_item49 inputan">
                                <div class="form-group ml-2">
                                    <img id="output2" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                    <input type="file" accept="image/*" onchange="" name="foto2" required="required">
                                </div>
                            </div>
                            <div class="grid__item grid__item_item50 inputan">
                                <table class="table table-bordered mt-2" id="dynamic_field2" style="">
                                    <tr>
                                        <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                        <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                        <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                        <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                        <th rowspan="2"><button type="button" name="add4" id="add4" class="btn btn-success green" onclick="tambahManuver('dynamic_field2','lokasiManuverNormal[]','installManuverNormal[]','id_update_normal[]',jumlah_baris2)">Add More</button></th>
                                    </tr>
                                    <tr>
                                        <th style="width:9rem;">Remote</th>
                                        <th style="width:9rem;">Real (R/L)</th>
                                        <th style="width:9rem;">ADS</th>
                                    </tr>
                                        <?php $i=1; ?>
                                        <?php while ($penormalan = mysqli_fetch_assoc($tahapan_manuver_penormalan) ) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><input type="text" name="lokasiManuverNormal[]" value="<?= $penormalan["lokasi"] ?>" style="width:8rem;padding:0rem;" required></td>
                                        <td><?= $penormalan["remote_"] == "00:00:00" ? "<input type='time' value='<?= time(); ?>' class='disableManuver' name='remote_normal[]'>" : "<input type='time' value='". $penormalan['remote_']."' class='disableManuver' name='remote_normal[]'>" ?></td>
                                        <td><?= $penormalan["real_"] == "00:00:00" ? "<input type='time' value='<?= time(); ?>' class='disableManuver' name='real_normal[]'>" : "<input type='time' value='". $penormalan['real_']."' class='disableManuver' name='real_normal[]'>" ?></td>
                                        <td><?= $penormalan["ads"] == "00:00:00" ? "<input type='time' value='<?= time(); ?>' class='disableManuver' name='ads_normal[]'>" : "<input type='time' value='". $penormalan['ads']."' class='disableManuver' name='ads_normal[]'>" ?></td>
                                        <td><input type="text" name="installManuverNormal[]" value="<?= $penormalan["installasi"] ?>" style="width:8rem;padding:0rem;" required></td>
                                        <td>
                                            <button type="button" onclick="hapus_baris(this,'id_ajax_hapus_normal[]')" class="btn btn-danger btn_remove2">X</button>
                                            <input type="text" name="id_update_normal[]" value="<?= $penormalan["id"] ?>" >
                                        </td>
                                    </tr>
                                        <?php $i++ ?>
                                        <?php endwhile; ?>
                                </table>
                            </div>
                            <div class="grid__item grid__item_item51 titel">Catatan Pasca Penormalan :</div>
                            <div class="grid__item grid__item_item52 inputan"><textarea name="catatan_pasca_normal" id="" cols="232" rows="3" disabled></textarea></div>
                        </div><br>
                            <button type="submit" name="submit" >Simpan Form</button>

        </form>
      </div>
    </div>
  </div>
  <script src="js/script.js"></script>
  <script>
      const disableManuverBebas = document.querySelectorAll('#dynamic_field2 tr td .disableManuver');
        if(statusJob == '') {
            for (i=0; i<disableManuverBebas.length; i++){
                disableManuverBebas[i].style.display = 'none';
            }

        }
  </script>
  
</body>
</html>






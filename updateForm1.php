<?php 
require 'functions.php';
$sql_manuver_petugas=mysqli_query($conn,"SELECT * FROM db_table_pengawas WHERE id_form='$_GET[id]'");
$sql_manuver_petugas2=mysqli_query($conn,"SELECT * FROM db_table_pengawas WHERE id_form='$_GET[id]'");
$tahapan_manuver_pembebasan=mysqli_query($conn,"SELECT * FROM db_table_tahapan WHERE id_form='$_GET[id]' AND tahapan = 'pembebasan'");
$tahapan_manuver_penormalan=mysqli_query($conn,"SELECT * FROM db_table_tahapan WHERE id_form='$_GET[id]' AND tahapan = 'penormalan'");
$sql=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
$data=mysqli_fetch_assoc($sql);



if( isset($_POST["submit"]) ){

    if( ubah($_POST) > 0){
        //var_dump(ubah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                document.location.href = 'home.php?url=inbox';
                </script>
                ";  
                
    } else {
        //var_dump(ubah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                document.location.href = 'home.php?url=inbox';
                </script>"; 
                die;
                
    }
}

$dataAjax = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis=$data[jenis_pekerjaan] AND db_ajax_lokasi.nama= '$data[lokasi]' AND db_ajax_lokasi_detail.nama='$data[installasi]'");
$cekData = mysqli_num_rows($dataAjax);

if($cekData == 1){
    $isiajax = mysqli_fetch_assoc($dataAjax);
    $query = mysqli_query($conn,"SELECT * FROM db_ajax_table_pengawas WHERE id_lokasi_detail='{$isiajax['id_lokasi_detail']}'");
    $query2 = mysqli_query($conn,"SELECT * FROM db_ajax_table_tahapan WHERE id_lokasi_detail='{$isiajax['id_lokasi_detail']}' AND tahapan='pembebasan'");
    $query3 = mysqli_query($conn,"SELECT * FROM db_ajax_table_tahapan WHERE id_lokasi_detail='{$isiajax['id_lokasi_detail']}' AND tahapan='penormalan'");
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
    <title>LMO - Change</title>
    <style>
        span {
            color: red;
        }

       
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Change Document
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="" method="post" id="form_id" enctype="multipart/form-data">
                    <div class="hiden">
                        <div class="additional">
                            <div class="default">
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
                                <input type="text" name="chose_db" value="<?= $data["chose_db"] ?>">
                            </div>
                            <div class="chose">
                                <label for="" style="">Pilih jenis pekerjaan :</label>
                                <select name="jenis_pekerjaan" id="jenis" style="" required>
                                    <option value="">-SELECT-</option>
                                    <option value="1" <?php if ($data["jenis_pekerjaan"] == 1 ) echo 'selected="selected"'; ?>>SUTET</option>
                                    <option value="3" <?php if ($data["jenis_pekerjaan"] == 3 ) echo 'selected="selected"'; ?>>IBT</option>
                                    <option value="4" <?php if ($data["jenis_pekerjaan"] == 4 ) echo 'selected="selected"'; ?>>BUSBAR</option>
                                    <option value="5" <?php if ($data["jenis_pekerjaan"] == 5 ) echo 'selected="selected"'; ?>>REACTOR</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item_item1 titel">pekerjaan<span>*</span></div>
                        <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan<span>*</span></div>
                        <div class="grid__item grid__item_item3 titel">mulai<span>*</span></div>
                        <div class="grid__item grid__item_item4 titel" >selesai<span>*</span></div>
                        <div class="grid__item grid__item_item5 inputan"><input type="text" name="pekerjaan" id="pekerjaan" value="<?= $data["pekerjaan"]; ?>"></div>
                        <div class="grid__item grid__item_item6 inputan"><input type="date" name="date" id="start_date"  value="<?= $data["date"]; ?>"></div>
                        <div class="grid__item grid__item_item7 inputan"><input type="datetime-local" name="start" id="end_date" class="" value="<?= date('Y-m-d\TH:i:s', strtotime($data['start'])); ?>">   WIB</div>
                        <div class="grid__item grid__item_item8 inputan"><input type="datetime-local" name="end" id="report_date" class="" value="<?= date('Y-m-d\TH:i:s', strtotime($data['end'])); ?>"> WIB</div>
                        <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                        <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                        <div class="grid__item grid__item_item11 titel">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan"><input type="text" name="lokasi" value="<?= $data["lokasi"]; ?>" id="lokasi" ></div>
                        <div class="grid__item grid__item_item13 inputan"><input type="text" name="instal" value="<?= $data["installasi"]; ?>"id="instal" ></div>
                        <div class="grid__item grid__item_item14 inputan"><input type="datetime-local" name="report_date" id="report_date"  disabled></div>
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
                                        <?php if ($data["chose_db"] == 0) {?>
                                            <?php while ($manuverBebas = mysqli_fetch_array($sql_manuver_petugas)) { ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="lokasiPembebasan[]" value="<?= $manuverBebas["lokasi"]  ?>" style="">
                                                            <input type="text" name="id_bebas_update[]" value="<?= $manuverBebas["id"]  ?>" style="border:1px solid #fff;width:50px;" >
                                                            
                                                        </td>
                                                        <td><?= $manuverBebas["pengawas_pekerjaan"]  ?></td>
                                                        <td><?= $manuverBebas["pengawas_manuver"]  ?></td>
                                                        <td><?= $manuverBebas["pengawas_manuver"]  ?></td>
                                                        <td><?= $manuverBebas["spv_gitet"]  ?></td>
                                                        <td><?= $manuverBebas["opr_gitet"]  ?></td>
                                                    </tr>
                                        <?php }} ?>
                                        <?php if($data["chose_db"] == 1 || $data["chose_db"] == 2  ) { ?>
                                            <?php while ($manuverBebas = mysqli_fetch_array($sql_manuver_petugas)) : ?>
                                            
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="lokasiPembebasan[]" value="<?= $manuverBebas["lokasi"]  ?>" style="">
                                                            <input type="text" name="id_bebas_update[]" value="<?= $manuverBebas["id"]  ?>" style="border:1px solid #fff;width:50px;" >
                                                            
                                                        </td>
                                                        <td><?= $manuverBebas["pengawas_pekerjaan"]  ?></td>
                                                        <td><?= $manuverBebas["pengawas_manuver"]  ?></td>
                                                        <td><?= $manuverBebas["pengawas_manuver"]  ?></td>
                                                        <td><?= $manuverBebas["spv_gitet"]  ?></td>
                                                        <td><?= $manuverBebas["opr_gitet"]  ?></td>
                                                    </tr>
                                            <?php endwhile ?>
                                        <?php }?>
                                                
                                      
                                        </tbody>
                                    </table> 
                                        <button type="button" id="add1" class="btn green" onclick="addRow()" ><i class='fa fa-plus'></i></button>
                                        <button type="button" id="remove1" class="btn red" onclick="removeRow()"><i class="fa fa-minus" aria-hidden="true"></i></button> 
                                        
                                
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
                        <div class="grid__item grid__item_item27 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item28 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item29 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item30 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item31 titel">ALIRAN DAYA SETELAH DIBEBASKAN</div>
                        <div class="grid__item grid__item_item32 titel">ALIRAN DAYA SETELAH DINORMALKAN</div>
                        <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item34 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item35 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item36 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item37 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel">Catatan Pra Pembebasan<span>*</span></div>
                        <div class="grid__item grid__item_item39 inputan"><textarea name="catatan_pra_bebas" id="" cols="232" rows="3" ><?= $data["catatan_pra_pembebasan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item40 titel">Tahapan Manuver Pembebasan<span>*</span></div>
                        <div class="grid__item grid__item_item41 inputan">
                            <img src="img/<?= $data["foto"];?>" id="output1" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                            <input type="file" name="foto" accept="image/*" onchange="loadFile1(event)">
                        </div>
                        <div class="grid__item grid__item_item42 inputan">
                            <table class="table table-bordered mt-2" style="">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                        <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                        <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                        <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                        <th rowspan="2"><button type="button" name="add3" id="add3" class="btn green" onclick="tambah()">Add More</button></th>
                                    </tr>
                                    <tr>
                                        <th style="width:9rem;">Remote</th>
                                        <th style="width:9rem;">Real (R/L)</th>
                                        <th style="width:9rem;">ADS</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamic_field1">
                                        <?php $i=1; ?>
                                        <?php while ($pembebasan = mysqli_fetch_assoc($tahapan_manuver_pembebasan) ) : ?>    
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><input type="text" name="lokasiManuverBebas[]" value="<?= $pembebasan["lokasi"] ?>" style="width:8rem;padding:0rem;" required></td>
                                        <td><?= $pembebasan["remote_"] == "00:00:00" ?"": $pembebasan["remote_"] ?></td>
                                        <td><?= $pembebasan["real_"] == "00:00:00" ?"": $pembebasan["real_"] ?></td>
                                        <td><?= $pembebasan["ads"]== "00:00:00" ?"": $pembebasan["ads"] ?></td>
                                        <td><input type="text" name="installManuverBebas[]" value="<?= $pembebasan["installasi"] ?>" style="width:8rem;padding:0rem;" required></td>
                                        <td>
                                            <button type="button" onclick="hapus_baris(this, <?= $i ?>,'id_hapus1[]','id_ajax_hapus1[]')" class="btn btn-danger btn_remove">X</button>  <!--  -->
                                            <input type="text" name="id_bebas_update2[]" value="<?= $pembebasan["id"] ?>">
                                        </td>
                                        <td ><input type="text" value="<?php //$j; ?>"></td>
                                    </tr>
                                        <?php $i++ ?>
                                       
                                        <?php endwhile; ?>
                                </tbody >
                                <tfoot id="sub_dynamic_field1" >
                                        <?php $i=1; ?>
                                        <?php while ($ajaxPembebasan = mysqli_fetch_assoc($query2)) : ?>
                                    <tr id="row-<?= $i?>">
                                        <td><input type="text" value="<?= $ajaxPembebasan['id'] ?>"></td>
                                        
                                    </tr>
                                    <?php $i++ ?>
                                        <?php endwhile; ?>

                                </tfoot>
                                

                                

                                </table>
                        </div>
                        <div class="grid__item grid__item_item43 titel">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item44 inputan"><textarea name="catatan_pasca_bebas" id="" cols="232" rows="3" disabled></textarea></div>
                        <div class="grid__item grid__item_item45 titel">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan"><textarea name="catatan_pra_normal" id="" cols="232" rows="3" ><?= $data["catatan_pra_penormalan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item48 titel">Tahapan Manuver Penormalan :</div>
                        <div class="grid__item grid__item_item49 inputan">             
                                <img src="img/<?= $data["foto2"];?>" id="output2" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                <input type="file" accept="image/*" onchange="loadFile2(event)" name="foto2">
                        </div>
                        <div class="grid__item grid__item_item50 inputan">
                            <table class="table table-bordered mt-2"  style="">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                        <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                        <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                        <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                        <th rowspan="2"><button type="button" name="add4" id="add4" class="btn btn-success green" onclick="tambah2()">Add More</button></th>
                                    </tr>
                                    <tr>
                                        <th>Remote</th>
                                        <th>Real (R/L)</th>
                                        <th>ADS</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamic_field2">
                                    <?php $i=1; ?>
                                    <?php while ($penormalan = mysqli_fetch_assoc($tahapan_manuver_penormalan) ) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><input type="text" name="lokasiManuverNormal[]" value="<?= $penormalan["lokasi"] ?>" style="width:8rem;padding:0rem;" required></td>
                                    <td><?= $penormalan["remote_"] == "00:00:00" ?"": $penormalan["remote"] ?></td>
                                    <td><?= $penormalan["real_"] == "00:00:00" ?"": $penormalan["real_"] ?></td>
                                    <td><?= $penormalan["ads"] == "00:00:00" ?"": $penormalan["ads"] ?></td>
                                    <td><input type="text" name="installManuverNormal[]" value="<?= $penormalan["installasi"] ?>" style="width:8rem;padding:0rem;" required></td>
                                    <td>
                                        <button type="button" onclick="hapus_baris2(this)" class="btn btn-danger btn_remove2">X</button>
                                        <input type="text" name="id_normal_update3[]" value="<?= $penormalan["id"] ?>" hidden>
                                    </td>
                                </tr>
                                    <?php $i++ ?>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="grid__item grid__item_item51 titel">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan"><textarea name="catatan_pasca_normal" id="" cols="232" rows="3" disabled></textarea></div>
                        <div class="grid__item grid__item_item53 titel">Masukan AMN jika ada kekeliruan</div>
                        <div class="grid__item grid__item_item54 titel">Masukan MSB Jika ada kekeliruan</div>
                        <div class="grid__item grid__item_item55 inputan"><textarea name="catatan_amn" id="" cols="113" rows="5" style="" disabled><?= $data["catatan_amn"];?></textarea></div>
                        <div class="grid__item grid__item_item56 inputan"><textarea name="catatan_msb" id="" cols="113" rows="5" style="" disabled><?= $data["catatan_msb"];?></textarea></textarea></div>
                    </div><br>
                        <button type="submit" name="submit" >Simpan Form</button>
                    </div>

                </form>
                <?php  } ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">



    function addRow() {
        table = document.getElementById('table1');
        row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);

        cell1.innerHTML = "<input type='text' name='lokasiPembebasan[]' id='' style='width:140px;border:1px solid #fff;'><input type='text' name='id_bebas_update[]' style='width:8rem;padding:0rem;' value='0' hidden>";
        cell2.innerHTML = "<input type='text' name='pKerjaPembebasan[]' id='' style='width:140px;border:1px solid #fff;' disabled>";
        cell3.innerHTML = "<input type='text' name='pManuverPembebasan[]' id='' style='width:140px;border:1px solid #fff;' disabled>";
        cell4.innerHTML = "<input type='text' name='pK3Pembebasan[]' id='' style='width:140px;border:1px solid #fff;' disabled>";
        cell5.innerHTML = "<input type='text' name='spvPembebasan[]' id='' style='width:140px;border:1px solid #fff;' disabled>";
        cell6.innerHTML = "<input type='text' name='oprPembebasan[]' id='' style='width:140px;border:1px solid #fff;' disabled>";

        table1 = document.getElementById('table2');
        var row1 = table1.insertRow(-1);
        var cell7 = row1.insertCell(0);
        var cell8 = row1.insertCell(1);

        cell7.innerHTML = "<input type='text' name=spvPenormalan[] id='' style='width:140px;border:1px solid #fff;'>";
        cell8.innerHTML = "<input type='text' name=oprPenormalan[] id='' style='width:140px;border:1px solid #fff;'>";
    }

    jumlahRow = document.getElementById('table1').rows.length-1;
    function removeRow() {
        table = document.getElementById('table1').children[jumlahRow--].children[0].children[1];
        if (table.value != "0"){
        id_hapus = table.cloneNode(true);
            id_hapus.setAttribute("name","id_hapus0[]");
            document.getElementById("form_id").appendChild(id_hapus);
        }
        
        table.parentElement.parentElement.remove();
    }
    

    table = document.getElementById('dynamic_field1');
    jumlah_baris = table.rows.length-1;
    table2 = document.getElementById('dynamic_field2');
    jumlah_baris2 = table2.rows.length-1;
    
    function tambah() {
        table = document.getElementById('dynamic_field1');
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        var cell7 = row.insertCell(6);

        cell1.innerHTML = jumlah_baris++;
        cell2.innerHTML = "<input type='text' name='lokasiManuverBebas[]' style='width:8rem;padding:0rem;' required>";
        cell3.innerHTML = "";
        cell4.innerHTML = "";
        cell5.innerHTML = "";
        cell6.innerHTML = "<input type='text' name='installManuverBebas[]' style='width:8rem;padding:0rem;' required>";
        cell7.innerHTML = "<button type='button' onclick='hapus_baris_new1(this)' class='btn btn-danger btn_remove'>X</button><input type='text' name='id_bebas_update2[]' value='0' hidden>";

        footTable = document.getElementById('sub_dynamic_field1');
        var baris = footTable.insertRow(-1);
        var cell8 = baris.insertCell(0);

        cell8.innerHTML = "<input type='text' value='0'>"

    }

    function tambah2() {
        table2 = document.getElementById('dynamic_field2');
        var row = table2.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        var cell7 = row.insertCell(6);

        cell1.innerHTML = jumlah_baris2++;
        cell2.innerHTML = "<input type='text' name='lokasiManuverNormal[]' style='width:8rem;padding:0rem;' required>";
        cell3.innerHTML = "";
        cell4.innerHTML = "";
        cell5.innerHTML = "";
        cell6.innerHTML = "<input type='text' name='instalManuverNormal[]' style='width:8rem;padding:0rem;' required>";
        cell7.innerHTML = "<button type='button' onclick='hapus_baris_new2(this)' class='btn btn-danger btn_remove'>X</button><input type='text' name='id_normal_update3[]' value='0' hidden>";

    }

    // nextBaris = document.getElementById("sub_dynamic_field1").children[0];
    function hapus_baris(tombol,a,b,c) {
        baris = tombol.parentElement.parentElement
        if (baris.children[6].children[1].value != "0"){
            id_hapus = baris.children[6].children[1].cloneNode(true);
            id_hapus.setAttribute("name", b);
            document.getElementById("form_id").appendChild(id_hapus);
        }

        // nextnya = baris.children[7].children[0].value;

        barisNext = document.getElementById("row-"+a+"");
        if (barisNext.children[0].children[0].value != "0"){
            id_hapus = barisNext.children[0].children[0].cloneNode(true);
            id_hapus.setAttribute("name",c);
            document.getElementById("form_id").appendChild(id_hapus);
        }
        
        baris.remove();
        barisNext.remove();

        
    }
    //hapus row kondisi id masih 0
    function hapus_baris_new1(tombol) {
        baris = tombol.parentElement.parentElement
        baris.remove();
    }

    function hapus_baris2(tombol) {
        baris = tombol.parentElement.parentElement
        if (baris.children[6].children[1].value != "0"){
            id_hapus = baris.children[6].children[1].cloneNode(true);
            id_hapus.setAttribute("name", "id_hapus2[]");
            document.getElementById("form_id").appendChild(id_hapus);
        }
        baris.remove();
    }

    function hapus_baris_new2(tombol) {
        baris = tombol.parentElement.parentElement
        baris.remove();
    }

     //---image_upload_&_show 1---//
     var loadFile1 = function(event) {
        var output1 = document.getElementById('output1');
        output1.src = URL.createObjectURL(event.target.files[0]);
    };
    //---image_upload_&_show 2---//
    var loadFile2 = function(event) {
        var output2 = document.getElementById('output2');
        output2.src = URL.createObjectURL(event.target.files[0]);
    };

    </script>
</body>
</html>
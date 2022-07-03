<?php


if (!isset($_SESSION["username"])) {
	echo "<script>Anda Belum Login</script>";
  header("location:index.php");
	exit;
}



require "functions.php";

$query2 = mysqli_query($conn,"SELECT id FROM db_form ORDER BY id DESC LIMIT 1");
$idnext = mysqli_fetch_array($query2);

$sql_data1 = mysqli_query($conn, "SELECT * FROM db_ajax_lokasi WHERE id_lokasi= '$_GET[idy]'");
$data1=mysqli_fetch_assoc($sql_data1);

$sql_data2 = mysqli_query($conn, "SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi_detail= '$_GET[idz]'");
$data2=mysqli_fetch_assoc($sql_data2);



if( isset($_POST["submit"]) ){

    if( insertForm($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                document.location.href = 'home.php';
                </script>
                ";  
                
    } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                document.location.href = 'home.php';
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
                            <div class="default" hidden>
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
                                <label for="" style="">Pilih jenis pekerjaan :</label>
                                <select name="jenis_pekerjaan" id="jenis" style="margin-right: 30px;" required>
                                    <option value="">-SELECT-</option>
                                    <option value="1" <?php if ($_GET["idx"]== 1 ) echo 'selected="selected"'; ?>>SUTET</option>
                                    <option value="2" <?php if ($_GET["idx"]== 2 ) echo 'selected="selected"'; ?>>ENERGIZE</option>
                                    <option value="3" <?php if ($_GET["idx"]== 3 ) echo 'selected="selected"'; ?>>IBT</option>
                                    <option value="4" <?php if ($_GET["idx"]== 4 ) echo 'selected="selected"'; ?>>BUSBAR</option>
                                    <option value="5" <?php if ($_GET["idx"]== 5 ) echo 'selected="selected"'; ?>>REACTOR</option>
                                </select>
                                <label for="">Apakah anda mau MERUBAH form ke DB?</label>
                                <input id="toggle-on" class="toggle toggle-left" name="chose_db" value="0" type="radio" >
                                <label for="toggle-on" class="btnn">No</label>
                                <input id="toggle-off" class="toggle toggle-right" name="chose_db" value="1" type="radio" checked>
                                <label for="toggle-off" class="btnn">Yes</label>
                            </div>
                            
                        </div>
                        <div class="grid">
                            <div class="grid__item grid__item_item1 titel">pekerjaan<span>*</span></div>
                            <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan<span>*</span></div>
                            <div class="grid__item grid__item_item3 titel">mulai<span>*</span></div>
                            <div class="grid__item grid__item_item4 titel border_right" >selesai<span>*</span></div>
                            <div class="grid__item grid__item_item5 inputan"><input type="text" name="pekerjaan" id="pekerjaan" class="form-control" placeholder="masukkan judul pekerjaan" required></div>
                            <div class="grid__item grid__item_item6 inputan"><input type="date" name="date" id="start_date" class="form-control" required></div>
                            <div class="grid__item grid__item_item7 inputan"><input type="datetime-local" name="start" id="end_date"  required></div>
                            <div class="grid__item grid__item_item8 inputan border_right"><input type="datetime-local" name="end" id="report_date"  required></div>
                            <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                            <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                            <div class="grid__item grid__item_item11 titel border_right">permintaan pembebanan diterima</div>
                            <div class="grid__item grid__item_item12 inputan" id="lokasinya">
                                <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                    <input type="text" name="lokasi" id="lokasi" value="<?= strtoupper($data1["nama"]); ?>"  autocomplete="off" placeholder="Sebelum input lokasi pilih jenis pekerjaan dahulu...!" style="width: 400px;">
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
                            <div class="grid__item grid__item_item13 inputan">
                                <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                    <input type="text" name="instal" id="lokasiDetail" value="<?= strtoupper($data2["nama"]); ?>"autocomplete="off" placeholder="Inputkan detail pekerjaan" style="width: 400px;">
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
                            <div class="grid__item grid__item_item14 inputan border_right"><input type="datetime-local" name="report_date" id="report_date" class="form-control" disabled></div>
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
                                          

                                                <?php foreach (unserialize($data2["pengawas"]) ?: [] as $row) :
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
                            <div class="grid__item grid__item_item33 inputan"><input type="text" disabled></div>
                            <div class="grid__item grid__item_item34 inputan border_right"><input type="text" disabled></div>
                            <div class="grid__item grid__item_item35 inputan"><input type="text" disabled></div>
                            <div class="grid__item grid__item_item36 inputan border_right"><input type="text" disabled></div>
                            <div class="grid__item grid__item_item37 titel border_right">MANUVER PEMBEBASAN INSTALLASI</div>
                            <div class="grid__item grid__item_item38 titel border_right">Catatan Pra Pembebasan<span>*</span></div>
                            <div class="grid__item grid__item_item39 inputan border_right"><textarea name="catatan_pra_bebas" class="textarea" placeholder="Masukkan catatan sebelum pembebasan" cols="232" rows="3"></textarea></div>
                            <div class="grid__item grid__item_item40 titel border_right">Tahapan Manuver Pembebasan<span>*</span></div>
                            <div class="grid__item grid__item_item41 inputan">
                                <div class="form-group ml-2">
                                    <img id="output1" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                    <input type="file" accept="image/*" onchange="" name="foto" required="required">
                                </div>
                            </div>
                            <div class="grid__item grid__item_item42 inputan border_right">
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
                                            <?php 
                                                foreach (unserialize($data2["manuver_bebas"])  ? : []  as $row) :
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
                                </table>
                            </div>
                            <div class="grid__item grid__item_item43 titel border_right">Catatan Pasca Pembebasan :</div>
                            <div class="grid__item grid__item_item44 inputan border_right"><textarea name="catatan_pasca_bebas" class="textarea" cols="232" rows="3" disabled></textarea></div>
                            <div class="grid__item grid__item_item45 titel border_right">MANUVER PENORMALAN INSTALLASI</div>
                            <div class="grid__item grid__item_item46 titel border_right">Catatan Pra Penormalan :</div>
                            <div class="grid__item grid__item_item47 inputan border_right"><textarea name="catatan_pra_normal" class="textarea" placeholder="Masukkan catatan sebelum penormalan" cols="232" rows="3"></textarea></div>
                            <div class="grid__item grid__item_item48 titel border_right">Tahapan Manuver Penormalan :</div>
                            <div class="grid__item grid__item_item49 inputan">
                                <div class="form-group ml-2">
                                    <img id="output2" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                    <input type="file" accept="image/*" onchange="" name="foto2" required="required">
                                </div>
                            </div>
                            <div class="grid__item grid__item_item50 inputan border_right">
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
                                    <?php 
                                        foreach (unserialize($data2["manuver_normal"])  ? : []  as $row) :
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
                                </table>
                            </div>
                            <div class="grid__item grid__item_item51 titel border_right">Catatan Pasca Penormalan :</div>
                            <div class="grid__item grid__item_item52 inputan border_right border_bottom"><textarea name="catatan_pasca_normal" class="textarea" cols="232" rows="3" disabled></textarea></div>
                        </div><br>
                            <button type="submit" name="submit" >Simpan Form</button>

        </form>
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






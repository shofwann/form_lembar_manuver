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

    if( insertForm2($_POST) > 0){
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
            Form Auto-2
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
                                <option value="9" <?php if ($_GET["idx"]== 8 ) echo 'selected="selected"'; ?>>SUTET</option>
                                <option value="9" <?php if ($_GET["idx"]== 9 ) echo 'selected="selected"'; ?>>ENERGIZE</option>
                                <option value="10" <?php if ($_GET["idx"]== 10 ) echo 'selected="selected"'; ?>>IBT</option>
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
                        <div class="grid__item grid__item_item5 inputan"><input type="text" name="pekerjaan" id="pekerjaan" class="" placeholder="Masukkan judul pekerjaan" required="required"></div>
                        <div class="grid__item grid__item_item6 inputan"><input type="date" name="date" id="start_date" class="" ></div>
                        <div class="grid__item grid__item_item7 inputan"><input type="datetime-local" name="start" id="end_date"  ></div>
                        <div class="grid__item grid__item_item8 inputan border_right"><input type="datetime-local" name="end" id="report_date"  ></div>
                        <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                        <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                        <div class="grid__item grid__item_item11 titel border_right">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan" id="lokasinya">
                            <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                <input type="text" name="lokasi" id="lokasi" class="inputi" autocomplete="off" placeholder="Sebelum input lokasi pilih jenis pekerjaan dahulu...!" style="width: 400px;" required="required">
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
                                <input type="text" name="instal" id="lokasiDetail" class="" autocomplete="off" placeholder="Inputkan detail pekerjaan" style="width: 400px;" required="required">
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
                        <div class="grid__item grid__item_item14 inputan border_right"><input type="datetime-local" name="report_date" id="report_date" class="" disabled></div>
                        <div class="grid__item grid__item_item15 titel">MANUVER PEMBEBASAN INSTALLASI<span>*</span></div>
                        <div class="grid__item grid__item_item16 titel">MANUVER PENORMALAN INSTALLASI<span>*</span></div>
                        <div class="grid__item grid__item_item17 titel border_right">kelengkapan dokumen</div>
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
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
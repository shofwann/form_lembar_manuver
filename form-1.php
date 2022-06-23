<?php
   if (!isset($_SESSION["username"])) {
	    echo "<script>Anda Belum Login</script>";
        header("location:index.php");
	exit;
    }

    if ($_SESSION["level"] != "initiator") {
        echo "<script>Mohon Logout dahulu !!</script>";
        // header("location:index.php");
        exit;
    
    }

    require "functions.php";

    // skript auto number for ID
   
    $query = "SELECT id FROM db_form ORDER BY id DESC LIMIT 1";

    $query2 = mysqli_query($conn,"SELECT id FROM db_form ORDER BY id DESC LIMIT 1");
    $idnext = mysqli_fetch_array($query2);


    $idLokasi = mysqli_query($conn,"SELECT id_lokasi FROM db_ajax_lokasi ORDER BY id_lokasi DESC LIMIT 1");
    $bacaIdLokasi = mysqli_fetch_assoc($idLokasi);

    $idLokasiDetail = mysqli_query($conn,"SELECT id_detail_lokasi FROM db_ajax_lokasi_detail ORDER BY id_detail_lokasi DESC LIMIT 1");

    
   

    if( isset($_POST["submit"]) ){
        if( insertForm1($_POST) > 0){
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
    <title>LMO-FORM1</title>
    <link rel="stylesheet" href="css/style.css">
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
            Form-1
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="additional">
                        <div class="default" hidden>
                            <label>ID Task:</label>
                            <input type="text" name="idTask" value="<?= $idnext['id']+1; ?>" class="" readonly>
                            <label for="">ID Lokasi :</label>
                            <input type="text" value="<?= $bacaIdLokasi["id_lokasi"]+1; ?>">
                            <label>Create Date:</label>
                            <input type="text" name="create_date" value="<?= date('d-M-Y H:i:s');?>" class="" readonly>
                            <label>User :</label>
                            <input type="text" name="user" placeholder="" value="<?= $_SESSION['username'];?>" class="" readonly>
                            <input type="text" value="<?= $_SESSION['level'];?>" id="level">
                            <input type="text" value="" id="statusJob">
                            <input type="text" name="form" value="1">
                        </div>
                        <div class="chose">
                            <label for="" style="">Pilih jenis pekerjaan :</label>
                            <select name="jenis_pekerjaan" id="jenis" style="margin-right: 30px;" required>
                                <option value="">-SELECT-</option>
                                <option value="1">SUTET</option>
                                <option value="2">ENERGIZE</option>
                                <option value="3">IBT</option>
                                <option value="4">BUSBAR</option>
                                <option value="5">REACTOR</option>
                                <option value="6">PMT</option>
                                <option value="7">PMS</option>
                            </select>
                            <label for="">Apakah anda mau MENYIMPAN form ke DB?</label>
                            <input id="toggle-on" class="toggle toggle-left" name="chose_db" value="0" type="radio" checked>
                            <label for="toggle-on" class="btnn">No</label>
                            <input id="toggle-off" class="toggle toggle-right" name="chose_db" value="1" type="radio">
                            <label for="toggle-off" class="btnn">Yes</label>
                        </div>

                    </div>
                    
                    <div class="grid">
                        <div class="grid__item grid__item_item1 titel">pekerjaan<span>*</span></div>
                        <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan<span>*</span></div>
                        <div class="grid__item grid__item_item3 titel">mulai<span>*</span></div>
                        <div class="grid__item grid__item_item4 titel border_right" >selesai<span>*</span></div>
                        <div class="grid__item grid__item_item5 inputan"><input type="text" name="pekerjaan" id="pekerjaan" class="" placeholder="Masukkan judul pekerjaan" required="required"></div>
                        <div class="grid__item grid__item_item6 inputan"><input type="date" name="date" id="start_date" class="" required="required"></div>
                        <div class="grid__item grid__item_item7 inputan"><input type="datetime-local" name="start" id="end_date" required="required" ></div>
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
                
                                        </tbody>
                                    </table> 
                                        <button type="button" id="add1" class="btn green" onclick="tambah()" ><i class='fa fa-plus'></i></button>
                                        <button type="button" id="remove1" class="btn red" onclick="kurang()"><i class="fa fa-minus" aria-hidden="true"></i></button> 
                                        
                                
                                <br>  
                            </div>
                        </div>
                        <div class="grid__item grid__item_item19 inputan">
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
                        <div class="grid__item grid__item_item20 inputan border_right">
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
                        <div class="grid__item grid__item_item39 inputan border_right"><textarea name="catatan_pra_bebas" class="textarea" cols="232" rows="3" placeholder="masukkan catatan sebelum pembebasan" required="required"></textarea></div>
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
                                    <th rowspan="2"><button type="button" name="add3" id="add3" onclick="tambahBaris('dynamic1','lokasiManuverBebas[]','installManuverBebas[]')" class="btn green">Add More</button></th>
                                </tr>
                                <tr>
                                    <th style="width:9rem;">Remote</th>
                                    <th style="width:9rem;">Real (R/L)</th>
                                    <th style="width:9rem;">ADS</th>
                                </tr>
                                <tfoot id="dynamic1" >

                                </tfoot>
                                </table>
                        </div>
                        <div class="grid__item grid__item_item43 titel border_right">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item44 inputan border_right"><textarea name="catatan_pasca_bebas" class="textarea" cols="232" rows="3" disabled></textarea></div>
                        <div class="grid__item grid__item_item45 titel border_right">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel border_right">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan border_right"><textarea name="catatan_pra_normal" class="textarea" cols="232" rows="3" placeholder="masukkan catatan sebelum penormalan" required="required"></textarea></div>
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
                                    <th rowspan="2"><button type="button" name="add4" id="add4" onclick="tambahBaris('dynamic2','lokasiManuverNormal[]','installManuverNormal[]')" class="btn btn-success green">Add More</button></th>
                                </tr>
                                <tr>
                                    <th>Remote</th>
                                    <th>Real (R/L)</th>
                                    <th>ADS</th>
                                </tr>
                                <tfoot id="dynamic2">

                                </tfoot>
                            </table>
                        </div>
                        <div class="grid__item grid__item_item51 titel border_right">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan border_right border_bottom"><textarea name="catatan_pasca_normal" class="textarea" cols="232" rows="3" disabled></textarea></div>
                    </div><br>
                        <button type="submit" name="submit" >Simpan Form</button>
                </form>
            </div>
            <div>
                <!-- <label for="input">Input</label> -->
                <input type="text" id="input" />
                <ul class="bullet" id="suggestions"></ul>
            </div>
        </div>

       
    </div>

    

    <script type="text/javascript">
    
       
    
     //--table-jquery--//
        $(document).ready(function(){
            //--table_add/remove w/ number1--/

                // ======================================autocomplete lokasi==========================================
                $("#lokasi").keyup(function(){               
                var query = $("#lokasi").val();
                if (query.length > 3) {
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
                    if (queryDetail.length > 3) {
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
  
    </script>


<script src="js/script.js"></script>
</body>

</html>
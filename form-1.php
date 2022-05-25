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
        if( tambah($_POST) > 0){
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

        ul.auto {
            float: left;
            list-style: none;
            padding: 0px;
            border: 1px solid #fff;
            margin-top: 0px;
        }

        .inputi, ul.auto {
            width: 250px;
        }

        #response li:hover, #responseDetail li:hover {
            color: silver;
            background: #0088cc;
            cursor: pointer;
            position: absolute;
        }

        input[type=text] + span {
            display: none;
        }
        input[type=text]:focus + span {
            display: inline;
            color: blue;
            position: relative;
            
        }

        ul.info-list {
            list-style-type: none;
            
        }
        ul.info-list li b {
            position: relative;
            display: inline-block;
            min-width: 100px;
            margin-right: 4px;
            
        }
        ul.info-list li b:after {
            content: ":";
            position: absolute;
            right: 0;
            
            
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
                        <div class="default" >
                            <label>ID Task:</label>
                            <input type="text" name="idTask" value="<?= $idnext['id']+1; ?>" class="" readonly>
                            <label for="">ID Lokasi :</label>
                            <input type="text" value="<?= $bacaIdLokasi["id_lokasi"]+1; ?>">
                            <label>Create Date:</label>
                            <input type="text" name="create_date" value="<?= date('d-M-Y H:i:s');?>" class="" readonly>
                            <label>User :</label>
                            <input type="text" name="user" placeholder="" value="<?= $_SESSION['username'];?>" class="" readonly>
                            <label for=""></label>
                        </div>
                        <div class="chose">
                            <label for="" style="">Pilih jenis pekerjaan :</label>
                            <select name="jenis_pekerjaan" id="jenis" style="margin-right: 30px;" required>
                                <option value="">-SELECT-</option>
                                <option value="1">SUTET</option>
                                <option value="3">IBT</option>
                                <option value="4">BUSBAR</option>
                                <option value="5">REACTOR</option>
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
                        <div class="grid__item grid__item_item4 titel" >selesai<span>*</span></div>
                        <div class="grid__item grid__item_item5 inputan"><input type="text" name="pekerjaan" id="pekerjaan" class="" placeholder="Masukkan judul pekerjaan"></div>
                        <div class="grid__item grid__item_item6 inputan"><input type="date" name="date" id="start_date" class="" ></div>
                        <div class="grid__item grid__item_item7 inputan"><input type="datetime-local" name="start" id="end_date"  ></div>
                        <div class="grid__item grid__item_item8 inputan"><input type="datetime-local" name="end" id="report_date"  ></div>
                        <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                        <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                        <div class="grid__item grid__item_item11 titel">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan" id="lokasinya">
                            <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                <input type="text" name="lokasi" id="lokasi" class="inputi" autocomplete="off" placeholder="Sebelum input lokasi pilih jenis pekerjaan dahulu...!" style="width: 400px;">
                                <div class="tool-tip  slideIn">
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
                            <input type="text" name="instal" id="lokasiDetail" class="" autocomplete="off" placeholder="Inputkan detail pekerjaan" style="width: 400px;">
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
                        <div class="grid__item grid__item_item14 inputan"><input type="datetime-local" name="report_date" id="report_date" class="" disabled></div>
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
                        <div class="grid__item grid__item_item20 inputan">
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
                        <div class="grid__item grid__item_item33 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item34 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item35 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item36 inputan"><input type="text" disabled></div>
                        <div class="grid__item grid__item_item37 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel">Catatan Pra Pembebasan<span>*</span></div>
                        <div class="grid__item grid__item_item39 inputan"><textarea name="catatan_pra_bebas" id="" cols="232" rows="3"></textarea></div>
                        <div class="grid__item grid__item_item40 titel">Tahapan Manuver Pembebasan<span>*</span></div>
                        <div class="grid__item grid__item_item41 inputan">
                            <div class="form-group ml-2">
                                <img id="output1" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                                <input type="file" accept="image/*" onchange="loadFile1(event)" name="foto" required="required">
                            </div>
                        </div>
                        <div class="grid__item grid__item_item42 inputan">
                            <table class="table table-bordered mt-2" id="dynamic_field1" style="">
                                <tr>
                                    <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                    <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                    <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                    <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                    <th rowspan="2"><button type="button" name="add3" id="add3" class="btn green">Add More</button></th>
                                </tr>
                                <tr>
                                    <th style="width:9rem;">Remote</th>
                                    <th style="width:9rem;">Real (R/L)</th>
                                    <th style="width:9rem;">ADS</th>
                                </tr>
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
                                <input type="file" accept="image/*" onchange="loadFile2(event)" name="foto2" required="required">
                            </div>
                        </div>
                        <div class="grid__item grid__item_item50 inputan">
                            <table class="table table-bordered mt-2" id="dynamic_field2" style="">
                                <tr>
                                    <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                    <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                    <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                    <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                    <th rowspan="2"><button type="button" name="add4" id="add4" class="btn btn-success green">Add More</button></th>
                                </tr>
                                <tr>
                                    <th>Remote</th>
                                    <th>Real (R/L)</th>
                                    <th>ADS</th>
                                </tr>
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

    <script type="text/javascript">
    
    



    function tambah(){
        table = document.getElementById("table1");
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);

       cell1.innerHTML = "<input type='text' name='lokasiPembebasan[]' id=''>";
       cell2.innerHTML = "<input type='text' name='pKerjaPembebasan[]' id='' disabled>";
       cell3.innerHTML = "<input type='text' name='pManuverPembebasan[]' id='' disabled>";
       cell4.innerHTML = "<input type='text' name='pK3Pembebasan[]' id='' disabled>";
       cell5.innerHTML = "<input type='text' name='spvPembebasan[]' id='' disabled>";
       cell6.innerHTML = "<input type='text' name='oprPembebasan[]' id='' disabled>";

       table1 = document.getElementById("table2");
       var row1 = table1.insertRow(-1);
       var cell7 = row1.insertCell(0);
       var cell8 = row1.insertCell(1);

       cell7.innerHTML = "<input type='text' name=spvPenormalan[] id='' disabled>";
       cell8.innerHTML = "<input type='text' name=oprPenormalan[] id='' disabled>";
    }

    function kurang(){
        table = document.getElementById("table1");
        row = table.getElementsByTagName('tr');
        if (row.length!='0'){
            row[row.length - 1].outerHTML='';
        }
        table = document.getElementById("table2");
        row = table.getElementsByTagName('tr');
        if (row.length!='0'){
            row[row.length - 1].outerHTML='';
        }

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
    
    
     //--table-jquery--//
        $(document).ready(function(){
            //--table_add/remove w/ number1--/
                var k=0;
                lenghtRows = $('#dynamic_field1 tr').length-1;
                generateIndex = () => {
                    lenghtRows = $('#dynamic_field1 tr').length-1;
                    return lenghtRows;
                }
                UpdateIndex = () => {
                    lengthRows = $('#dynamic_field1 tr').length-1;
                    for (k=0; k<lenghtRows; k++){
                        $('#dynamic_field1 tr td.cont-item')[k].textContent = k+1;
                    }
                } 
                $('#add3').click(function(){
                    k=generateIndex();
                    $('#dynamic_field1').append('<tr id="row'+k+'"><td class="cont-item" >'+k+'</td><td><input type="text" name="lokasiManuverBebas[]" ></td><td><input type="time" name="jamRemoteBebas[]" disabled></td><td><input type="time" name="jamRealBebas[]" disabled></td><td><input type="time" name="jamAdsBebas[]" disabled></td><td><input type="text" name="installManuverBebas[]" ></td><td class="manuver"style=""><button type="button" name="remove" id="'+k+'" class="btn btn-danger btn_remove"><i class="fa fa-times" aria-hidden="true"></i></button></td></tr>');
                });

                $(document).on('click', '.btn_remove', function(){ 
                    k-=1; 
                    var button_id = $(this).attr("id");   
                    $('#row'+button_id+'').remove();  
                    UpdateIndex();
                }); 

            //--table_add/remove w/ number2--/
                var l=0;
                generateIndex1 = () => {
                    lenghtRows1 = $('#dynamic_field2 tr').length-1;
                    return lenghtRows1;
                }
                UpdateIndex1 = () => {
                    lengthRows = $('#dynamic_field2 tr').length-1;
                    for (l=0; l<lenghtRows1; l++){
                        $('#dynamic_field2 tr td.cont-item')[l].textContent = l+1;
                    }
                }
                $('#add4').click(function(){
                    l=generateIndex1();
                    $('#dynamic_field2').append('<tr id="row1'+l+'"><td class="cont-item">'+l+'</td><td><input type="text" name="lokasiManuverNormal[]" ></td><td><input type="time" name="jamRemoteNormal[]" disabled></td><td><input type="time" name="jamRealNormal[]" disabled></td><td><input type="time" name="jamAdsNormal[]" disabled></td><td><input type="text" name="installManuverNormal[]"></td><td class="manuver"><button type="button" name="remove" id="'+l+'" class="btn btn-danger btn_remove2"><i class="fa fa-times" aria-hidden="true"></i></button></td></tr>');
                });

                $(document).on('click', '.btn_remove2', function(){ 
                    l-=1; 
                    var button_id1 = $(this).attr("id");   
                    $('#row1'+button_id1+'').remove();  
                    UpdateIndex1();
                }); 


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
  
    </script>



</body>

</html>
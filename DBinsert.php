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
include 'functions.php';

$query = mysqli_query($conn,"SELECT id_lokasi FROM db_ajax_lokasi ORDER BY id_lokasi DESC LIMIT 1");
$idNext = mysqli_fetch_assoc($query);
if ($query) {

if( isset($_POST["submit"]) ){

    if( insertDB($_POST) > 0){
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
    <title>LMO - DB INSERT</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Insert Database
        </div>
        <div class="container-wrap">
            <div class="container">
            <form action="" method="post" id="form_id">
                    <div class="grid">
                        <div class="grid__item grid__item_item001">Pilih Form</div>
                        <div class="grid__item grid__item_item002">Pilih Jenis Pekerjaan</div>
                        <div class="grid__item grid__item_item003">Pilih Lokasi</div>
                        <div class="grid__item grid__item_item004 border_right">Pilih detail Lokasi</div>
                        <div class="grid__item grid__item_item005">
                            <select name="form" id="form">
                                <option value="">-SELECT-</option>
                                <option value="1">form-1</option>
                                <option value="2">form-2</option>
                            </select>
                        </div>
                        <div class="grid__item grid__item_item006">
                            <select name="jenis" id="jenis">
                                <option value="">-SELECT-</option>
                            </select>
                        </div>
                        <div class="grid__item grid__item_item007" id="lokasinya">
                            <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                <input type="text" name="lokasi" id="lokasi" class="inputi" autocomplete="off" placeholder="Sebelum input lokasi pilih jenis pekerjaan dahulu...!" style="width: 400px;">
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
                        <div class="grid__item grid__item_item008 border_right" id="detailnya">
                           <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
                                <input type="text" name="detailLokasi" id="lokasiDetail" class="" autocomplete="off" placeholder="Inputkan detail pekerjaan" style="width: 400px;">
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
                        
                        <div class="grid__item grid__item_item009 titel">Lokasi Pekerjaan</div>
                        <div class="grid__item grid__item_item0010 titel">Manuver Pembebasan</div>
                        <div class="grid__item grid__item_item0011 titel border_right">Manuver Penormalan</div>
                        <div class="grid__item grid__item_item0013  border_bottom" >
                            <table class="table table-bordered">
                                <thead>
                                    <tr id="tableHead">
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody1">
                                    
                                </tbody>
                            </table>
                                <button type="button" id="add1" class="btn btn-success" onclick="tambah1()">+</button>
                                <button type="button" id="remove1" class="btn btn-danger" onclick="kurang1()">-</button> 
                        </div>
                        <div class="grid__item grid__item_item0014 border_bottom" >
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lokasi</th>
                                        <th>Installasi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody2">
                                    
                                </tbody>
                            </table>
                                <button type="button" id="add2" class="btn btn-success" onclick="tambah2()">+</button>
                                <button type="button" id="remove2" class="btn btn-danger" onclick="kurang2()">-</button> 
                        </div>
                        <div class="grid__item grid__item_item0015 border_right border_bottom" >
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lokasi</th>
                                        <th>Installasi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody3">
                                    
                                </tbody>
                            </table>
                                <button type="button" id="add3" class="btn btn-success" onclick="tambah3()">+</button>
                                <button type="button" id="remove3" class="btn btn-danger" onclick="kurang3()">-</button> 
                        </div>
                        
                    </div>  
                            
                    <button type="submit" name="submit">Simpan</button>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#form').on('change',function(){
                var form  = $(this).val();
                $.ajax({
                    url: 'get_data_jenis.php',
                    type: "POST",
                    data: {
                        modul: 'jenis',
                        id:form
                    },
                    success: function(respond){
                        $('#jenis').html(respond);
                    },
                    error:function(){
                        alert('gagal mengambil data');
                    }
                })
            })
            
        })

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

        function tambah1() {
            table = document.getElementById('tableBody1');
            var row = table.insertRow(-1);
            cell1 = row.insertCell(0);
            cell1.innerHTML = "<input name='lokasiPembebasan[]' type='text'>";
        }
        function kurang1() {
            table = document.getElementById('tableBody1');
            row = table.getElementsByTagName('tr');
            if (row.length !='0') {
                row[row.length-1].outerHTML='';
            }
        }
        no = 1;
        function tambah2() {
            table = document.getElementById('tableBody2');
            var row = table.insertRow(-1);
            cell1 = row.insertCell(0);
            cell2 = row.insertCell(1);
            cell3 = row.insertCell(2);
            cell1.innerHTML = no++;
            cell2.innerHTML = "<input name='lokasiManuverBebas[]' type='text'>";
            cell3.innerHTML = "<input name='installManuverBebas[]' type='text'>";
        }
        function kurang2() {
            table = document.getElementById('tableBody2');
            row = table.getElementsByTagName('tr');
            if (row.length !='0') {
                row[row.length-1].outerHTML='';
            }
            no--;
        }
        no2 = 1;
        function tambah3() {
            table = document.getElementById('tableBody3');
            var row = table.insertRow(-1);
            cell1 = row.insertCell(0);
            cell2 = row.insertCell(1);
            cell3 = row.insertCell(2);
            cell1.innerHTML = no2++;
            cell2.innerHTML = "<input name='lokasiManuverNormal[]' type='text'>";
            cell3.innerHTML = "<input name='installManuverNormal[]' type='text'>";
        }
        function kurang3() {
            table = document.getElementById('tableBody3');
            row = table.getElementsByTagName('tr');
            if (row.length !='0') {
                row[row.length-1].outerHTML='';
            }
            no2--;
        }

    </script>
</body>
</html>
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

    if( tambahDB($_POST) > 0){
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
                        <div class="grid__item grid__item_item004">Pilih detail Lokasi</div>
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
                        <div class="grid__item grid__item_item007">
                            <input name="lokasi" type="text" id="lokasi">   
                        </div>
                        <div class="grid__item grid__item_item008">
                           <input name="detailLokasi" type="text">
                        </div>
                        
                        <div class="grid__item grid__item_item009 titel">Lokasi Pekerjaan</div>
                        <div class="grid__item grid__item_item0010 titel">Manuver Pembebasan</div>
                        <div class="grid__item grid__item_item0011 titel">Manuver Penormalan</div>
                        <div class="grid__item grid__item_item0013" >
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
                        <div class="grid__item grid__item_item0014" >
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
                        <div class="grid__item grid__item_item0015" >
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

        function tambah1() {
            table = document.getElementById('tableBody1');
            var row = table.insertRow(-1);
            cell1 = row.insertCell(0);
            cell1.innerHTML = "<input name='lokasiGitet[]' type='text'>";
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
            cell2.innerHTML = "<input name='lokasiOpen[]' type='text'>";
            cell3.innerHTML = "<input name='installasiOpen[]' type='text'>";
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
            cell2.innerHTML = "<input name='lokasiClose[]' type='text'>";
            cell3.innerHTML = "<input name='installasiClose[]' type='text'>";
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
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
if( isset($_POST["submit"]) ){

    if( ubahDB($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                document.location.href = 'home.php?url=updateDB';
                </script>
                ";  
                
    } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                document.location.href = 'home.php?url=updateDB';
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
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="card">
        <div class="card-header">
            Update Database
        </div>
        <div class="container-wrap">
            <div class="container" style="height: 905px;">
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
                            <select name="idx" id="jenis">
                                <option value="">-SELECT-</option>
                            </select>
                        </div>
                        <div class="grid__item grid__item_item007">
                            <select name="idy" id="lokasi">
                                <option style="white-space: nowrap;" value="">-SELECT-</option>
                            </select>
                        </div>
                        <div class="grid__item grid__item_item008">
                            <select name="idz" id="detail_lokasi" onChange="pilihanDetailLokasi()">
                                <option value="">-SELECT-</option>
                            </select>
                        </div>
                        
                        <div class="grid__item grid__item_item009 titel">Lokasi Pekerjaan</div>
                        <div class="grid__item grid__item_item0010 titel">Manuver Pembebasan</div>
                        <div class="grid__item grid__item_item0011 titel">Manuver Penormalan</div>
                        <div class="grid__item grid__item_item0012 grid" id="table" ">
                            <div  >

                            </div>
                        </div>
                    </div>  
                            
                    <button type="submit" name="submit">Ubah</button>
                </form>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script type="text/javascript">


$(document).ready(function(){
            $('#form').on('change',function(){
                var form  = $(this).val();
                $.ajax({
                    url: "get_data_jenis.php",
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

            $('#jenis').on('change',function(){
                var form = $(this).val();
                $.ajax({
                    url: "get_data_jenis.php",
                    type: "POST",
                    data: {
                        modul: 'lokasi',
                        id:form
                    },
                    success: function(respond){
                        $('#lokasi').html(respond);
                    },
                    error:function(){
                        alert('gagal mengambil data');
                    }
                })
            })

            $('#lokasi').on('change',function(){
                var form = $(this).val();
                $.ajax({
                    url: 'get_data_jenis.php',
                    type: "POST",
                    data: {
                        modul: 'detail_lokasi',
                        id:form
                    },
                    success: function(respond){
                        $('#detail_lokasi').html(respond);
                    },
                    error:function(){
                        alert('gagal mengambil data');
                    }
                })
            })

            $(document).ready(function() {
                    $('#lokasi').select2({dropdownAutoWidth: 'true'});
                });
            

        });

        function pilihanDetailLokasi() {
                var y = document.getElementById('detail_lokasi').value;
                $.ajax({
                    url:'get_data_db.php',
                    method:'POST',
                    data: {
                        idDetailLokasi : y
                    },
                    success:function(data){
                        $('#table').html(data);
                    }
                })

        }

        function tambah1() {
        table = document.getElementById('tableBody1n');
        var row = table.insertRow(-1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell1.innerHTML = "<input name='lokasi1[]' type='text'>";
        cell2.innerHTML = "<button type='button' onclick='hapus1new(this)' class='btn btn-danger btn_remove'>X</button><input type='text' name='id1[]' value='0' hidden>";
        }

        function hapus1(ini) {
            row = ini.parentElement.parentElement
            if (row.children[1].children[1].value != "0"){
                id_hapus = row.children[1].children[1].cloneNode(true);
                id_hapus.setAttribute("name","id1_hapus[]");
                document.getElementById("form_id").appendChild(id_hapus);
            }
            row.remove();
        }

        function hapus1new(ini) {
            row = ini.parentElement.parentElement
            row.remove();
        }


        
        no = 1;
        function tambah2() {
            table = document.getElementById('tableBody2n');
            var row = table.insertRow(-1);
            cell1 = row.insertCell(0);
            cell2 = row.insertCell(1);
            cell3 = row.insertCell(2);
            cell4 = row.insertCell(3);
            cell1.innerHTML = no++;
            cell2.innerHTML = "<input name='lokasi2[]' type='text' style='width:60px;'>";
            cell3.innerHTML = "<input name='installasi2[]' type='text'>";
            cell4.innerHTML = "<button type='button' onclick='hapus2new(this)' class='btn btn-danger btn_remove'>X</button><input type='text' name='id2[]' value='0' hidden>"
        }

        function hapus2(ini) {
            row = ini.parentElement.parentElement
            if (row.children[3].children[1].value != "0"){
                id_hapus = row.children[3].children[1].cloneNode(true);
                id_hapus.setAttribute("name","id2_hapus[]");
                document.getElementById("form_id").appendChild(id_hapus);
            }
            row.remove();
        }

        function hapus2new(ini) {
            row = ini.parentElement.parentElement
            row.remove();
        }

        no2 = 1;
        function tambah3() {
            table = document.getElementById('tableBody3n');
            var row = table.insertRow(-1);
            cell1 = row.insertCell(0);
            cell2 = row.insertCell(1);
            cell3 = row.insertCell(2);
            cell4 = row.insertCell(3);
            cell1.innerHTML = no2++;
            cell2.innerHTML = "<input name='lokasi3[]' type='text' style='width:60px;'>";
            cell3.innerHTML = "<input name='installasi3[]' type='text'>";
            cell4.innerHTML = "<button type='button' onclick='hapus3new(this)' class='btn btn-danger btn_remove'>X</button><input type='text' name='id3[]' value='0' hidden>"
        }

        function hapus3(ini) {
            row = ini.parentElement.parentElement
            if (row.children[3].children[1].value != "0"){
                id_hapus = row.children[3].children[1].cloneNode(true);
                id_hapus.setAttribute("name","id3_hapus[]");
                document.getElementById("form_id").appendChild(id_hapus);
            }
            row.remove();
        }

        function hapus3new(ini) {
            row = ini.parentElement.parentElement
            row.remove();
        }

     
        </script>
    
</body>
</html>
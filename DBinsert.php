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

    // if( insertDB($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                //document.location.href = 'home.php';
                </script>
                ";  
                
    // } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                //document.location.href = 'home.php';
                </script>
                "; die;
                
    // }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO - DB INSERT</title>
    <script src="js/jquey.js"></script>
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
                            <select name="form" id="form" onChange=pilihForm()>
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
                        <div class="grid__item grid__item_item008 border_right " id="detailnya">
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
                        
                    </div>
                    
                    <div id=table></div>
                            
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

        function pilihForm() {
            var x =document.getElementById("form").value;
            $.ajax({
                url:  'get_data_form.php',
                method:'POST',
                data: {
                    idForm : x
                },
                success:function(data){
                    $('#table').html(data);
                }
            })
        }

        function tambah1() {
            table = document.getElementById('tableBody1');
            var row = table.insertRow(-1);
            cell1 = row.insertCell(0);
            cell1.innerHTML = "<input name='lokasiPembebasan[]' type='text' size='10'>";
        }
        function kurang1() {
            table = document.getElementById('tableBody1');
            row = table.getElementsByTagName('tr');
            if (row.length !='0') {
                row[row.length-1].outerHTML='';
            }
        }
              
        function tambahRow(g,h,i,j) {
            console.log(j)
            const idx = g === 0 ? j : `${j}${g}`;
            if(j != 'tableBody2'){
                console.log('tidak')
            } 
            let table = document.getElementById(idx);
            const newRow = document.createElement('tr');
            const existingRows = table.querySelectorAll('tr');
            // console.log(existingRows)
            newRow.innerHTML = `<td>${existingRows.length + 1}</td><td><input name='${h}' type='text'></td><td><input name='${i}' type='text'><input type='text' name='' id='hide' value='${g}'></td>`;
            table.appendChild(newRow);
            
  
        }
       
        function tambahForm(g,h,i,j,k,l) {   //0,'copyForm1','titelBebas[]','lokasiManuverNormal[]','installManuverNormal[]','tableBody2'
            const id = g === 0 ? `${h}` : `${h}${g}`;
            let table = document.getElementById(id);
            const form = document.createElement('div');
            const exist = table.querySelectorAll('div .flex-container-sub');
            // console.log(exist.length + 1);
            form.innerHTML = `<div class="flex-container-sub"><div class="grid-item " style=""><input type="" name="${i}" id=""><table class="table table-bordered" ><thead><tr><th style="width:33%">No</th><th style="width:33%">Lokasi</th><th style="width:33%">Installasi</th></tr></thead><tbody id="${l}${exist.length+1}"></tbody></table><button type="button" id="add2" class="btn btn-success" onclick="tambahRow(${exist.length+1},'${j}','${k}','${l}')">+</button><button type="button" class="btn btn-danger" onclick="kurangRow('${l}${exist.length+1}')">-</button></div><div class="grid-item form2" ><button type="button" class='btn reed open' onclick="kurangForm(this)">-</button></div><div id="${h}${exist.length+1}"></div></div>`;
            table.appendChild(form);
            
            let btnRed =  document.querySelectorAll('.open');
            const JumBtn = btnRed.length;

            // var last = btnRed[btnRed.length- 1];
            // last.style.backgroundColor = 'black';

            for(l=0; l<JumBtn-1; l++){
                btnRed[l].style.display = 'none';
            }
            // JumBtn[JumBtn-1].style.display = '';
            //console.log(JumBtn);
        }
 
        function kurangRow(a) {
            table = document.getElementById(a);
            row = table.getElementsByTagName('tr');
            if (row.length !='0') {
                row[row.length-1].outerHTML='';
            }
        }

        function kurangForm(ini) {

            
            var cek = ini.parentElement.parentElement.parentElement.previousElementSibling;
            var form = ini.parentElement.parentElement;

            if (cek == null){
                form.remove()
            } else{
                ini.parentElement.parentElement.parentElement.previousElementSibling.children[0].children[1].children[0].style.display='' ;
                form.remove()
            }
            // console.log(inilah);
            

        }

        
        


      
        

    </script>
</body>
</html>
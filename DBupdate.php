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

    if( updateDB($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                //document.location.href = 'home.php?url=updateDB';
                </script>
                ";  
                
    } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                //document.location.href = 'home.php?url=updateDB';
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
    <link href="select2/dist/css/select2.css" rel="stylesheet" />  
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
                        <div class="grid__item grid__item_item004 border_right">Pilih detail Lokasi</div>
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
                            <select name="idy" id="lokasi" >
                                <option style="white-space: nowrap;" value="" >-SELECT-</option>
                            </select>
                        </div>
                        <div class="grid__item grid__item_item008 border_right">
                            <select name="idz" id="detail_lokasi" onChange="pilihanDetailLokasi()">
                                <option value="">-SELECT-</option>
                            </select>
                        </div>
                        
                        <!-- <div class="grid__item grid__item_item009 titel">Lokasi Pekerjaan</div>
                        <div class="grid__item grid__item_item0010 titel">Manuver Pembebasan</div>
                        <div class="grid__item grid__item_item0011 titel border_right">Manuver Penormalan</div>
                        <div class="grid__item grid__item_item0012 grid border_right border_bottom" id="table" ">
                           
                        </div> -->
                    </div> 
                    <div id=table></div> 
                            
                    <button type="submit" name="submit">Ubah</button>
                </form>

            </div>
        </div>
    </div>
   
    <script src="js/jquey.js"></script>
    <script src="select2/dist/js/select2.full.js"></script>
    
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
                var form = $(this).find('option:selected').val()
                // console.log(form)
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
            
        });

        // $('#lokasi').select2({dropdownAutoWidth: 'true'});
               
        function pilihanDetailLokasi() {
            var y = document.getElementById('detail_lokasi').value;
            var x = document.getElementById('form').value;
            // console.log(x);
            $.ajax({
                url: 'get_data_db.php',
                method:'POST',
                data: {
                    idDetailLokasi : y,
                    idForm : x
                },
                success:
                function(data){
                    $('#table').html(data);

                    let jumBotBas = $('.bottonBebas'); //document.querySelectorAll('.bottonBebas');

                    // console.log(jumBotBas.length)

                    for(i=1; i<=jumBotBas.length; i++) {
                        var itu = $('.bottonBebas').children().eq(i).css('display','none');
                        // var ini = $('.bottonBebas').children().eq(jumBotBas.length-1).html(`<button type="button" id="openBebasOld" class='btn reed' onclick="kurangFormEx(this)">-</button>`);
                        jumBotBas[jumBotBas.length-1].innerHTML = `<button type="button" id="openBebasOld" class='btn reed' onclick="kurangFormEx(this,'#add2')">-</button>` ;
                        // console.log(itu)
                    }
                    // for (i=1; i<=jumBotBas.length; i++) {
                    //     jumBotBas[i].children[0].style.display = 'none';
                    //     jumBotBas[jumBotBas.length-1].innerHTML = `<button type="button" id="openBebasOld" class='btn reed' onclick="kurangFormEx(this)">-</button>` ;
                    // };

                    let jumBotMal = $('.bottonNormal')//document.querySelectorAll('.bottonNormal');
                    for(i=1; i<=jumBotMal.length; i++) {
                        var itu = $('.bottonNormal').children().eq(i).css('display','none');
                        // var ini = $('.bottonBebas').children().eq(jumBotBas.length-1).html(`<button type="button" id="openBebasOld" class='btn reed' onclick="kurangFormEx(this)">-</button>`);
                        jumBotMal[jumBotMal.length-1].innerHTML = `<button type="button" id="closeNormalOld" class='btn reed' onclick="kurangFormEx(this,'#add3')">-</button>` ;
                    }
                    // for (j=1; j<=jumBotMal.length; j++) {
                    //     jumBotMal[j].children[0].style.display = 'none';
                    //     jumBotMal[jumBotMal.length-1].innerHTML = `<button type="button" id="openBebasOld" class='btn reed' onclick="kurangFormEx(this)">-</button>` ;
                    // };
                }
                
                
            })

        }

        function kurang1() {
            table = document.getElementById('tableBody1');
            row = table.getElementsByTagName('tr');
            if (row.length !='0') {
                row[row.length-1].outerHTML='';
            }
        }

        function tambah1() {
            table = document.getElementById('tableBody1');
            var row = table.insertRow(-1);
            cell1 = row.insertCell(0);
            cell1.innerHTML = "<input name='lokasiPembebasan[]' type='text' size='10'>";
        }

        function tambahForm(g,h,i,j,k,l,m,n,o) {   //0,'copyForm1','titelBebas[]','lokasiManuverNormal[]','installManuverNormal[]','tableBody2',idBebas[],openBebas
            const id = g === 0 ? `${h}` : `${h}${g}`;
            let table = document.getElementById(id);
            const form = document.createElement('div');
            const exist = table.querySelectorAll('div .flex-container-sub');
            const existData = document.querySelectorAll(`input[name="${i}"]`)
            const totalRow = existData.length-1;
            form.innerHTML = `<div class="flex-container-sub"><div class="grid-item " style=""><input type="" name="${i}" required><table class="table table-bordered" ><thead><tr><th style="width:33%">No</th><th style="width:33%">Lokasi</th><th style="width:33%">Installasi</th></tr></thead><tbody id="${l}${totalRow+1}"></tbody></table><button type="button" id="add2" class="btn btn-success" onclick="tambahRow(${totalRow+1},'${j}','${k}','${l}','${m}')">+</button><button type="button" class="btn btn-danger" onclick="kurangRow('${l}${totalRow+1}')">-</button></div><div class="grid-item form2" ><button type="button" class='btn reed ${n}' onclick="kurangForm(this,'${n}')">-</button></div><div id="${h}${totalRow+1}"></div></div>`;
            table.appendChild(form);
            
            var rencHiden = document.getElementById(o)
            if (rencHiden){
                rencHiden.style.display = 'none';
            }

            let btnRed =  document.querySelectorAll(`.${n}`);
            const JumBtn = btnRed.length;

                

            for(l=0; l<JumBtn-1; l++){
                btnRed[l].style.display = 'none';
            }
           
        }

       

        function tambahRow(g,h,i,j,k) { //0,'lokasiBebas[]','installManuverBebas[]','tableBody20','idBebas[]'
            const idx = g === 0 ? `${j}0` : `${j}${g}`;
            console.log(idx)
            let table = document.getElementById(idx);
            const newRow = document.createElement('tr');
            const existingRows = table.querySelectorAll('tr');
            // console.log(existingRows)
            newRow.innerHTML = `<td>${existingRows.length + 1}</td><td><input name='${h}' type='text'></td><td><input name='${i}' type='text'><input type='text' name='${k}' id='hide' value='${g}'></td>`;
            table.appendChild(newRow);
        }

        function kurangRow(a) {
            table = document.getElementById(a);
            row = table.getElementsByTagName('tr');
            if (row.length !='0') {
                row[row.length-1].outerHTML='';
            }
        }

        function kurangForm(ini,a) {
            let btnRed =  document.querySelectorAll(`.${a}`);
            const JumBtn = btnRed.length;
            console.log(JumBtn)
            var cek = ini.parentElement.parentElement.parentElement.previousElementSibling;
            var form = ini.parentElement.parentElement;
            
            //var cek2 = ini.parentElement.parentElement.parentElement.parentElement.previousElementSibling.children[1].innerHTML = `<button type="button" id="openBebasOld" class='btn reed' onclick="kurangFormEx(this)">-</button>`;

            if (JumBtn == 1){
                // console.log('no')
                ini.parentElement.parentElement.parentElement.parentElement.previousElementSibling.children[1].innerHTML = `<button type="button" id="openBebasOld" class='btn reed' onclick="kurangFormEx(this,'#add2')">-</button>`;
                form.remove()
            } else if (JumBtn == 2) {
                form.remove()
            }else {
                ini.parentElement.parentElement.parentElement.previousElementSibling.children[0].children[1].children[0].style.display= '' ;
                form.remove()
                // console.log('yes')
            } 
        }

        function kurangFormEx(ini,a){
            jumBtn = document.querySelectorAll(a).length;
            console.log(jumBtn)
            var form = ini.parentElement.parentElement;

            if (jumBtn == 2){
                // console.log('no')
                form.remove()
            } else {
                var show = ini.parentElement.parentElement.previousElementSibling.children[1].innerHTML= `<button type="button" id="openBebasOld" class='btn reed' onclick="kurangFormEx(this,'#add2')">-</button>` ;
                form.remove()
                // console.log('yes')
            } 

        
        }
        // function hapus1(ini) {
        //     row = ini.parentElement.parentElement
        //     if (row.children[1].children[1].value != "0"){
        //         id_hapus = row.children[1].children[1].cloneNode(true);
        //         id_hapus.setAttribute("name","id1_hapus[]");
        //         document.getElementById("form_id").appendChild(id_hapus);
        //     }
        //     row.remove();
        // }

        // function hapus1new(ini) {
        //     row = ini.parentElement.parentElement
        //     row.remove();
        // }


        
        // no = 1;
        // function tambah2(a) {
        //     table = document.getElementById(a);
        //     var row = table.insertRow(-1);
        //     cell1 = row.insertCell(0);
        //     cell2 = row.insertCell(1);
        //     cell3 = row.insertCell(2);
        //     cell4 = row.insertCell(3);
        //     cell1.innerHTML = no++;
        //     cell2.innerHTML = "<input name='lokasiManuverBebas[]' type='text' style='width:60px;'>";
        //     cell3.innerHTML = "<input name='installManuverBebas[]' type='text'>";
        //     cell4.innerHTML = "<button type='button' onclick='hapus2new(this)' class='btn btn-danger btn_remove'>X</button><input type='text' name='id2[]' value='0' hidden>"
        // }

        // function hapus2(ini) {
        //     row = ini.parentElement.parentElement
           
        //     row.remove();
        // }

        // function hapus2new(ini) {
        //     row = ini.parentElement.parentElement
        //     row.remove();
        // }

        
        

     
        </script>
    
</body>
</html>
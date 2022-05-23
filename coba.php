<?php

require "coba2.php";



if( isset($_POST["submit"]) ){
    var_dump($_POST); die;

    if( coba($_POST) > 0){
        
        echo "<script>
                alert('data berhasil disubmit'); 
                document.location.href = 'main-dashboard.php';
                </script>
                ";  
                
    } else {
        var_dump(coba($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                document.location.href = 'main-dashboard.php';
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <link rel="stylesheet" href="css/style.css">
  <style type="text/css">
            ul {
                float: left;
                list-style: none;
                padding: 0px;
                border: 1px solid black;
                margin-top: 0px;
            }

            .inputi, ul {
                width: 250px;
            }

            li:hover {
                color: silver;
                background: #0088cc;
            }
        </style>
    
</head>
<body>
    <form action="" method="post" onSubmit="show_alert()">
    <!-- <label for="1">nama</label>
        <input id="1" type="text" name="masukan1">
        <label for="2"></label>
        <input id="2"type="checkbox" name="cek" value="ini" id="">
        <input type="text" id="pilihan" name="pilihan"> 
    -->
        <label for="">Pilih pulau</label>
        <select name="pulau" id="pulau">
            <option value="">-SELECT-</option>
            <option value="1">Sumatra</option>
            <option value="2">Jawa</option>
            <option value="3">Bali</option>
            <option value="4">Nusat Tenggara</option>
            <option value="5">Kalimantan</option>
            <option value="6">Sulawesi</option>
        </select><br>
        <label for="">masukkan Nama provinsi</label>
        <input class="inputi" type="text" nama="provinsi" id="provinsi" autocomplete="off">
        <div for=""id="response"></div>
        <label for="">Masukkan Nama Kota</label>
        <input type="text" nama="kota">
<br><br>

<div style="border: 1px solid black; width:50%;">
    <div>
        <input type="file">
    </div>
    <div>
        <input type="text">
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Komposisi</th>
                    <th>takaran</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
    
</div>
        <button type="submit" name="submit" confirm="">Goo....!</button><br>

        
    </form>
    <button data-modal="modal1" class="modal-open">image1</button>
            <div class="modal" id="modal1">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button class="modal-close">X</button>
                    </div>
                    <div class="modal-body">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis necessitatibus quisquam ipsum odio, est commodi autem eius aspernatur nulla corrupti cum dolorum vero dicta incidunt inventore facilis officiis facere doloribus!
                    </div>
                    <div class="modal-footer">
                        <button>Close bottom</button>
                    </div>
                </div>
            </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     -->
    <script type="text/javascript">
        var modalBtn = document.querySelectorAll(".modal-open");

        modalBtn.forEach(function (btn){
            btn.onclick = function() {
                var modal = btn.getAttribute("data-modal");
                document.getElementById(modal).style.display="block";
            };
        });

        var closeBtn = document.querySelectorAll(".modal-close");

        closeBtn.forEach(function (btn){
            btn.onclick = function(){
                var modal= btn.closest(".modal").style.display="none";
            }
        })

        $(document).ready(function(){
            // $("#pulau").on('change', function(){
                
            //     var pulauId = $(this).val();
            //     $.ajax({
            //         url: "coba3.php",
            //         type: "POST",
            //         data: {
            //             id: pulauId,
            //             modul: 'provinsi'
            //         },
            //         success: function(data) {
            //             $("#response").html(data);
            //         },
            //         datatype: 'text'
            //     });
            // }); 

            

            $("#provinsi").keyup(function(){
                
                var query = $("#provinsi").val();
                
                
                if (query.length > 3) {
                        $.ajax(
                            {
                                url: 'coba3.php',
                                type: 'POST',
                                data: {
                                    //search: 1,
                                    q: query,
                                    id: $("#pulau").val()
                                },
                                success: function (data) {
                                    $("#response").html(data);
                                },
                                dataType: 'text'
                            }
                        );
                    }
            });

            $(document).on('click', 'li', function () {
                    var provinsi = $(this).text();
                    $("#provinsi").val(provinsi);
                    $("#response").html("");
            });








        });

        



        // $(function() {
        //         $("#search").autocomplete({
        //             source: 'coba3.php'
        //         });
        //     });



        //  $(document).ready(function(){
        //     $("#search").on("keyup", function(){
        //         var search = $(this).val();
        //         if (search !=="") {
        //         $.ajax({
        //             url:"coba3.php",
        //             type:"POST",
        //             cache:false,
        //             data:{term:search},
        //             success:function(data){
        //             $("#search-result").html(data);
        //             $("#search-result").fadeIn();
        //             }  
        //         });
        //         }else{
        //         $("#search-result").html("");  
        //         $("#search-result").fadeOut();
        //         }
        //         });
        //         // click one particular search name it's fill in textbox
        //         $(document).on("click","li", function(){
        //         $('#search').val($(this).text());
        //         $('#search-result').fadeOut("fast");
        //     });
        // });

//         $( function() {

// $( "#search" ).autocomplete({
//   source: "coba3.php"
// });
// });


        // function show_alert() {
        //     if(!confirm("Do you really want to do this?")) {
        //         $(#pilihan).val(0);
        //         return false;
        //     }
        // this.form.submit();
        // }
    </script>
    
</body>
</html>
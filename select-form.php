<?php
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO - Pilih Form</title>
    <link rel="stylesheet" href="icons/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <form action="proses.php" method="get">
        <div class="card">
            <div class="card-header">
                Pilih Form
            </div>
            <div class="container-wrap">
                <div class="container" style="">
                    
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
                            <select name="idz" id="detail_lokasi">
                                <option value="">-SELECT-</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <button class="btn submit" type="submit" name="submit">Next Page</button>
                </div>
            </div>
        </div>
    </form>
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
        </script>
</body>
</html>
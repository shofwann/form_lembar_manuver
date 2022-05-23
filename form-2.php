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

    $query = "SELECT id FROM db_form ORDER BY id DESC LIMIT 1";

    $query2 = mysqli_query($conn,"SELECT id FROM db_form ORDER BY id DESC LIMIT 1");
    $idnext = mysqli_fetch_array($query2);

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO-FORM2</title>
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

        li:hover {
            color: silver;
            background: #0088cc;
        }

        input[type=text] + span {
            display: none;
        }
        input[type=text]:focus + span {
            display: inline;
            color: blue;
            position: relative;
            
        }
    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Form-2
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
                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item_item1 titel">pekerjaan<span>*</span></div>
                        <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan<span>*</span></div>
                        <div class="grid__item grid__item_item3 titel">mulai<span>*</span></div>
                        <div class="grid__item grid__item_item4 titel" >selesai<span>*</span></div>
                        <div class="grid__item grid__item_item5 inputan"><input type="text" name="pekerjaan" id="pekerjaan" class=""></div>
                        <div class="grid__item grid__item_item6 inputan"><input type="date" name="date" id="start_date" class="" ></div>
                        <div class="grid__item grid__item_item7 inputan"><input type="datetime-local" name="start" id="end_date"  ></div>
                        <div class="grid__item grid__item_item8 inputan"><input type="datetime-local" name="end" id="report_date"  ></div>
                        <div class="grid__item grid__item_item9 titel">lokasi<span>*</span></div>
                        <div class="grid__item grid__item_item10 titel">installasi<span>*</span></div>
                        <div class="grid__item grid__item_item11 titel">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan" id="lokasinya">
                            <input type="text" name="lokasi" id="lokasi" class="inputi" autocomplete="off" tittle="select from 1: this &#010; 2: that" placeholder="Masukkan Lokasi" style="width: 400px;">
                            <div for=""id="response"></div>
                        </div>
                        <div class="grid__item grid__item_item13 inputan" id="detailnya">
                            <input type="text" name="instal" id="lokasiDetail" class="" autocomplete="off">
                            <div for=""id="responseDetail"></div>
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
                        <div class="grid__item grid__item_item71 inputan">

                            <div class="container-fluid">
                                <div class="grid-item"> 
                                    
                                    <img id="output0" height="auto" width="800px" style="padding-top:.50rem;"><br>
                                    <input type="file" accept="image/*" name="fotoBebas[]" >
                                    
                                </div>
                                <div class="grid-item">
                                    <label for="">Masukkan Titel</label><br>
                                    <input type="text" name="titelBebas[]" style="font: size 20px; margin-bottom:10px;">
                                    <table style="">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                                <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                                <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                                <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                                <th rowspan="2"><button type="button" name="add3" id="add3" class="btn green" onclick="tambahRowBebas(0)">Add More</button></th>
                                            </tr>
                                            <tr>
                                                <th style="width:9rem;">Remote</th>
                                                <th style="width:9rem;">Real (R/L)</th>
                                                <th style="width:9rem;">ADS</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dynamic_form1">
            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="grid-item">
                                    <button type="button" class="btn-greend" onclick="tambahFormBebas()">+</button>
                                </div>
                            </div>
                            <div id="copy">

                            </div>
                        </div>
                        <div class="grid__item grid__item_item72 titel">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item73 inputan"><textarea name="catatan_pasca_bebas" id="" cols="232" rows="3" disabled></textarea></div>
                        <div class="grid__item grid__item_item74 titel">Tahapan Manuver Pembebasan<span>*</span></div>
                        <div class="grid__item grid__item_item75 inputan">
                            <div class="container-fluid">
                                <div class="grid-item">
                                    <img id="output0" height="auto" width="800px" style="padding-top:.50rem;"><br>
                                    <input type="file" accept="image/*" name="fotoNormal[]" >
                                </div>
                                <div class="grid-item">
                                    <label for="">Masukkan Titel</label><br>
                                    <input type="text" name="titelNormal[]" style="font: size 20px; margin-bottom:10px;">
                                    <table style="">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                                <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                                <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                                <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                                <th rowspan="2"><button type="button" name="add3" id="add3" class="btn green" onclick="tambahRowNormal(0)">Add More</button></th>
                                            </tr>
                                            <tr>
                                                <th style="width:9rem;">Remote</th>
                                                <th style="width:9rem;">Real (R/L)</th>
                                                <th style="width:9rem;">ADS</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dynamic_form2">
            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="grid-item">
                                <button type="button" class="btn-greend" onclick="tambahFormNormal()">+</button>
                                </div>
                            </div>

                        </div>
                      
                        

                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>


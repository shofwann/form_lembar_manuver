<?php
// session_start();
require 'functions.php';
$sql_manuver_petugas=mysqli_query($conn,"SELECT * FROM db_table_pengawas WHERE id_form='$_GET[id]'");
$sql_manuver_petugas2=mysqli_query($conn,"SELECT * FROM db_table_pengawas WHERE id_form='$_GET[id]'");
$tahapan_manuver_pembebasan=mysqli_query($conn,"SELECT * FROM db_table_tahapan WHERE id_form='$_GET[id]' AND tahapan = 'pembebasan'");
$tahapan_manuver_penormalan=mysqli_query($conn,"SELECT * FROM db_table_tahapan WHERE id_form='$_GET[id]' AND tahapan = 'penormalan'");
$sql=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
$data=mysqli_fetch_assoc($sql);



if( isset($_POST["submit"]) ){

    if( amnDispaAproveAwal($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                document.location.href = 'home.php?url=inbox';
                </script>
                ";  
                
    } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                document.location.href = 'home.php?url=inbox';
                </script>
                "; die;
                
    }
}

if ($sql){

    $tanggal = $data["date"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO-Aproval MSB</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="icons/font-awesome-4.7.0/css/font-awesome.min.css">
    <style>
        input[type="checkbox"][disabled] {
            border-color: red;
        }

        
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Aproval AMN
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="" method="post">
                    <div class="hiden" >
                        <label for="id" class="control-label">id</label>
                        <input type="text" name="idTask" id="idTask" class="form-control" value="<?= $data["id"]; ?>" readonly>
                    
                        <label>Time Aproval</label>
                        <input type="text" name="time" data-date="" class="form-control" value="<?= date('d-M-Y H:i:s'); ?>" readonly>
                    
                        <label>Level AMN :</label>
                        <input type="text" name="level" class="form-control" placeholder="" value="<?= $_SESSION['level']; ?>" class="form-control" readonly>
                    
                        <label>User AMN Dispa :</label>
                        <input type="text" name="userAmnDispa" placeholder="" value="<?= $_SESSION['username'];?>" class="form-control" readonly>

                        <label>Status :</label>
                        <input type="text" name="status" placeholder="" value="<?= $data["status"]; ?>" class="form-control" readonly>
                    </div>
                    <div class="grid">
                        <div class="grid__item_item01">
                            <div class="back">
                                <input type="button" value="Kembali" onclick="history.back()" style="">
                            </div>
                        </div>
                        <div class="grid__item grid__item_item02 titel">Creater</div>
                        <div class="grid__item grid__item_item03 titel">Create Form</div>
                        <div class=" grid__item_item04 "></div>
                        <div class="grid__item grid__item_item05 inputan"><p><?= $data['user']; ?></p></div>
                        <div class="grid__item grid__item_item06 inputan"><p><?= $data['create_date']; ?></p></div>
                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item_item1 titel">pekerjaan</div>
                        <div class="grid__item grid__item_item2 titel">tanggal pelaksanaan</div>
                        <div class="grid__item grid__item_item3 titel">mulai</div>
                        <div class="grid__item grid__item_item4 titel" >selesai</div>
                        <div class="grid__item grid__item_item5 inputan"><p class="pt-2 pl-2"><?= $data["pekerjaan"]; ?></p></div>
                        <div class="grid__item grid__item_item6 inputan"><p class="pt-2 pl-2"><?= date("d F Y", strtotime($tanggal)); ?></p></div>
                        <div class="grid__item grid__item_item7 inputan"><p class="pt-2 pl-2"><?= $data["start"]; ?> WIB</p></div>
                        <div class="grid__item grid__item_item8 inputan"><p class="pt-2 pl-2"><?= $data["end"]; ?> WIB</p></div>
                        <div class="grid__item grid__item_item9 titel">lokasi</div>
                        <div class="grid__item grid__item_item10 titel">installasi</div>
                        <div class="grid__item grid__item_item11 titel">permintaan pembebanan diterima</div>
                        <div class="grid__item grid__item_item12 inputan"><p class="pt-2 pl-2"><?= $data["lokasi"]; ?></p></div>
                        <div class="grid__item grid__item_item13 inputan"><p class="pt-2 pl-2"><?= $data["installasi"]; ?></p></div>
                        <div class="grid__item grid__item_item14 inputan"><p class="pt-4 pl-2"><?= $data["report_date"]; ?></p></div>
                        <div class="grid__item grid__item_item15 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item16 titel">MANUVER PENORMALAN INSTALLASI</div>
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
                                                    <?php while ($manuverBebas = mysqli_fetch_array($sql_manuver_petugas)) { ?>
                                                <tr>
                                                    <td><?= $manuverBebas["lokasi"]; ?></td>
                                                    <td><?= $manuverBebas["pengawas_pekerjaan"]  ?></td>
                                                    <td><?= $manuverBebas["pengawas_manuver"]  ?></td>
                                                    <td><?= $manuverBebas["pengawas_manuver"]  ?></td>
                                                    <td><?= $manuverBebas["spv_gitet"]  ?></td>
                                                    <td><?= $manuverBebas["opr_gitet"]  ?></td>
                                                </tr>
                                                <?php } ?>
                                        </tbody>
                                    </table>                                        
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
                                        <tbody id="bodyTable2">
                                            <?php while ($manuverBebas2 = mysqli_fetch_array($sql_manuver_petugas2)) { ?>
                                                <tr>
                                                    <td style=""><?= $manuverBebas2["spv_gitet_normal"]  ?></td>
                                                    <td><?= $manuverBebas2["opr_gitet_normal"]  ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item20 inputan">
                        <div class="col">
                            <br>
                            <?php $cekbok = explode(",", $data["document"]); ?> 
                                    <div action="" style="">
                                        <input type="checkbox" id="" name="" value="wp" <?php in_array('wp', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="vehicle1"> Working Permit</label><br>
                                        <input type="checkbox" id="" name="" value="ik" <?php in_array('ik', $cekbok) ? print 'checked' : ' '; ?> disabled>
                                        <label for="vehicle2"> IK</label><br>
                                        <input type="checkbox" id="" name="" value="k3" <?php in_array('k3', $cekbok) ? print 'checked' : ' '; ?>  disabled>
                                        <label for="vehicle3"> K3</label><br>
                                    </div>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item21 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DIBEBASKAN</div>
                        <div class="grid__item grid__item_item22 titel">ALIRAN DAYA PADA INSTALLASI MENJELANG DINORMALKAN</div>
                        <div class="grid__item grid__item_item23 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item24 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item25 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item26 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item27 inputan"><p><?= $data["scada_awal_before"]; ?></p></div>
                        <div class="grid__item grid__item_item28 inputan"><p><?= $data["dpf_awal"]; ?><?= ($data['foto_dpf1'] == null) ? 'belum upload foto DPF' : '<a href="dpf/' . $data['foto_dpf1'] . '" class="" download><i style="margin-left:10px;margin-right:10px;"class="fa fa-download"></i></a><button type="button" data-modal="modal1" class="modal-open"><i class="fa fa-eye"></i></button>'; ?></p>
                            
                            <div class="modal" id="modal1">
                                <div class="modal-content" >
                                    <div class="modal-header">
                                        <button type="button" class="modal-close">X</button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="dpf/<?= $data["foto_dpf1"];?>" >
                                    </div>
                                   
                                </div>
                            </div>
                           
                        </div>
                        <div class="grid__item grid__item_item29 inputan"><input type="text" style="" disabled></div>
                        <div class="grid__item grid__item_item30 inputan"><input type="text" style="" disabled></div>
                        <div class="grid__item grid__item_item31 titel">ALIRAN DAYA SETELAH DIBEBASKAN</div>
                        <div class="grid__item grid__item_item32 titel">ALIRAN DAYA SETELAH DINORMALKAN</div>
                        <div class="grid__item grid__item_item33 titel">Pembacaan SCADA</div>
                        <div class="grid__item grid__item_item34 titel">Hasil Studi DPF</div>
                        <div class="grid__item grid__item_item35 inputan"><p><?= $data["scada_awal_after"]; ?></p></div>
                        <div class="grid__item grid__item_item36 inputan"><h6 class="pt-4 pl-2" disabled><?= $data["scada_akhir_after"]; ?></h6></div>
                        <div class="grid__item grid__item_item37 titel">MANUVER PEMBEBASAN INSTALLASI</div>
                        <div class="grid__item grid__item_item38 titel">Catatan Pra Pembebasan</div>
                        <div class="grid__item grid__item_item39 inputan"><textarea name="catatan_pra_bebas" id="" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_pembebasan"];?></textarea></div>
                        <div class="grid__item grid__item_item40 titel">Tahapan Manuver Pembebasan</div>
                        <div class="grid__item grid__item_item41 inputan">
                            <div class="form-group ml-2">
                                <img src="img/<?= $data["foto"];?>" id="output1" height="auto" width="900px" style="padding-top:.50rem;padding-right:.50rem"><br>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item42 inputan">
                            <table class="table table-bordered mt-2" id="dynamic_field1" style="">
                                <tr>
                                    <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                    <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                    <th colspan="3"style="width:9rem;text-align:center">Jam Manuver Buka</th>
                                    <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                </tr>
                                <tr>
                                    <th style="width:9rem;">Remote</th>
                                    <th style="width:9rem;">Real (R/L)</th>
                                    <th style="width:9rem;">ADS</th>
                                </tr>
                                <?php $i=1; ?>
                                    <?php while ($pembebasan = mysqli_fetch_assoc($tahapan_manuver_pembebasan) ) : ?>
                                <tr id="">
                                    <td><?= $i ?></td>
                                    <td><?= $pembebasan["lokasi"]  ?></td>
                                    <td><?= $pembebasan["remote_"] == "00:00:00" ? "" : $pembebasan["remote_"] ; ?></td>
                                    <td><?= $pembebasan["real_"] == "00:00:00" ? "" : $pembebasan["real_"] ; ?></td>
                                    <td><?= $pembebasan["ads"] == "00:00:00" ? "" : $pembebasan["ads"] ; ?></td>
                                    <td style="width:10px"><?= $pembebasan["installasi"]  ?></td>
                                </tr>
                                    <?php $i++ ?>
                                    <?php endwhile; ?>
                                </table>
                        </div>
                        <div class="grid__item grid__item_item43 titel">Catatan Pasca Pembebasan :</div>
                        <div class="grid__item grid__item_item44 inputan"><textarea name="catatan_pasca_bebas" id="" cols="232" rows="3" style="" placeholder="Masukan Catatan..." disabled><?= $data["catatan_pasca_pembebasan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item45 titel">MANUVER PENORMALAN INSTALLASI</div>
                        <div class="grid__item grid__item_item46 titel">Catatan Pra Penormalan :</div>
                        <div class="grid__item grid__item_item47 inputan"><textarea name="catatan_pra_normal" id="" cols="232" rows="3" style="color:red;" disabled><?= $data["catatan_pra_penormalan"];?></textarea></div>
                        <div class="grid__item grid__item_item48 titel">Tahapan Manuver Penormalan :</div>
                        <div class="grid__item grid__item_item49 inputan">
                            <div class="form-group ml-2">
                                <img src="img/<?= $data["foto2"];?>" id="output2" height="auto" width="780px" style="padding-top:.50rem;padding-right:.50rem"><br>
                            </div>
                        </div>
                        <div class="grid__item grid__item_item50 inputan">
                            <table class="table table-bordered mt-2" id="dynamic_field2" style="">
                                <tr>
                                    <th rowspan="2" style="padding-top:35px;width:4rem">No.</th>
                                    <th rowspan="2" style="width:7rem;text-align:center;padding-top:35px">Lokasi</th>
                                    <th colspan="3"style="width:7rem;text-align:center">Jam Manuver Tutup</th>
                                    <th rowspan="2"style="padding-top:35px;width:9rem;">Installasi</th>
                                </tr>
                                <tr>
                                    <th>Remote</th>
                                    <th>Real (R/L)</th>
                                    <th>ADS</th>
                                </tr>
                                <?php $i=1; ?>
                                <?php while ($penormalan = mysqli_fetch_assoc($tahapan_manuver_penormalan) ) : ?>
                                    <tr id="redDua">
                                        <td><?= $i ?></td>
                                        <td><?= $penormalan["lokasi"]  ?></td>
                                        <td><?= $penormalan["remote_"] == "00:00:00" ? "" : $penormalan["remote_"] ; ?></td>
                                        <td><?= $penormalan["real_"] == "00:00:00" ? "" : $penormalan["real_"] ; ?></td>
                                        <td><?= $penormalan["ads"] == "00:00:00" ? "" : $penormalan["ads"] ; ?></td>
                                        <td><?= $penormalan["installasi"]  ?></td>
                                    </tr>
                                <?php $i++ ?>
                                <?php endwhile; ?>
                            </table>
                        </div>
                        <div class="grid__item grid__item_item51 titel">Catatan Pasca Penormalan :</div>
                        <div class="grid__item grid__item_item52 inputan"><textarea name="catatan_pasca_normal" id="" cols="232" rows="3" disabled><?= $data["catatan_pasca_penormalan"]; ?></textarea></div>
                        <div class="grid__item grid__item_item53 titel">Catatan AMN Dispa Awal</div>
                        <div class="grid__item grid__item_item54 titel">Catatan AMN Dispa Akhir</div>
                        <div class="grid__item grid__item_item55 inputan"><textarea name="catatan_amndis_awal" id="" cols="113" rows="5" style=""><?= $data["catatan_amnDispa_awal"]; ?></textarea></div>
                        <div class="grid__item grid__item_item56 inputan"><textarea name="catatan_amndis_akhir" id="" cols="113" rows="5" style="" disabled></textarea></div>
                    </div>
                        <div class="grid__item grid__item_item57 inputan">
                            <div class="aproval">
                                <input type="radio" id="aprove" name="aproval" value="approve">
                                <label for="aprove">Approve</label>
                                <input type="radio" id="disapprove" name="aproval" value="disapprove">
                                <label for="disapprove">Disapprove</label>
                            </div>
                            <br>
                            <button type="submit" name="submit" >Simpan Form</button>
                        </div>
                    </div>

                </form>
                <?php  } ?>
            </div>

        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
      
        
    </script>
</body>
</html>
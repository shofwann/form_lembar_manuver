<?php
include 'functions.php';

// sumber:
// initiator-updateDB.php
// shofwan.js
error_reporting(E_ALL ^ E_NOTICE); 
$idForm = $_POST["idForm"];
$idnya = $_POST["idDetailLokasi"];
$idnya = trim($idnya);
$query = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi_detail='{$idnya}'");
$data = mysqli_fetch_assoc($query);

$sql = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi_detail = '{$idnya}'"); 
$data4 = mysqli_fetch_assoc($sql);

$data_lokasi = mysqli_query($conn,"SELECT nama FROM db_ajax_lokasi WHERE id_lokasi = $data4[id_lokasi]");
$ambil = mysqli_fetch_assoc($data_lokasi);

?>
<!-- <link rel="stylesheet" href="css/style.css"> -->
<?php  ?>

<?php if ($idForm == 1 ) { ?>
  
        <br>
        <div class="flex-container">
            <div class="grid-item titel">Lokasi</div>
            <div class="grid-item titel">Manuver Pembebasan</div>
            <div class="grid-item titel">Manuver Penormalan</div>
            <div class="grid-item flex" style="border-right:none;">
                <a href="?url=hapusAjaxParent&id=<?= $data4['id_lokasi'];?>" onclick="return confirm('anda yakin menghapus parent dari <?= $data4['nama']?>?')">
                    <button type="button" class="btn red">Delete Parent</button>
                </a>

                <a href="?url=hapusAjax&id=<?= $data4['id_lokasi_detail'];?>" onclick="return confirm('anda yakin menghapus <?= $data4['nama']?>?')">
                        <button type="button" class="btn red">Delete</button>
                </a>

                <div style="display:flex;">
                    <label for="">Lokasi</label><br>
                    <input type="text" name="nama_lokasi" value="<?= $ambil["nama"]; ?>">
                </div>
                
                <div style="display:flex">
                    <label for="">Detail Lokasi</label><br>
                    <input type="text" name="nama_lokasi_detail" value="<?= $data4['nama']?>">
                </div>
                
            </div>
            <div class="grid-item" style="border-left:none;border-right:none">
                
            </div>
            <div class="grid-item" style="border-left:none;"></div>
            <div class="grid-item">
                <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th >Lokasi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody1">
                    <?php
                        foreach (unserialize($data["pengawas"]) ? : [] as $row) : 
                        for($j=0; $j<count(is_countable($row["lokasiPembebasan"]) ? $row["lokasiPembebasan"] : []); $j++) {
                    ?>
                        <tr >
                            <td><input type="text" name="lokasiPembebasan[]" value="<?= $row['lokasiPembebasan'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                            <!-- <td><button type="button" class="btn red" onclick="hapus1(this)">x</button><input type="text" name="id1[]" value="<?= $data['id']; ?>" hidden></td> -->
                        </tr>
                    <?php } endforeach ?>
                    </tbody>
                </table>
                <div class="form-button">
                    <button type="button" id="add1" class="btn btn-success" onclick="tambah1()">+</button>
                    <button type="button" id="remove1" class="btn red" onclick="kurang1()">-</button> 
                </div>
            </div>
            <div class="grid-item">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Installasi</th>
                        </tr>
                    </thead>
                
                    <?php $i=1; ?>
                <tbody id="tableBody2">
            <?php
            foreach (unserialize($data["manuver_bebas"]) ? : [] as $row) : 
                for($j=0; $j<count(is_countable($row["lokasiManuverBebas"]) ? $row["lokasiManuverBebas"] : [] ); $j++) {
            ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><input type="text" name="lokasiManuverBebas[]" value="<?= $row['lokasiManuverBebas'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td><input type="text" name="installManuverBebas[]" value="<?= $row['installManuverBebas'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <!-- <td>
                        <button type="button" class="btn red" onclick="hapus2(this)">x</button>
                        <input type="text" name="id2[]" value="<?= $data2['id']; ?>" hidden>
                    </td> -->
                </tr>
                <?php  $i++; ?>
                <?php } endforeach?>
                </tbody>
         
                        
                   
                </table>
                    <button type="button" id="add2" class="btn " onclick="tambahRow(0,'lokasiBebas[]','installManuverBebas[]','tableBody2',0)">+</button>
                    <button type="button" id="remove2" class="btn red" onclick="kurangRow('tableBody2')">-</button> 
            </div>
            <div class="grid-item">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Installasi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody3">
                    <?php $i=1; ?>
            <?php
            foreach (unserialize($data["manuver_normal"]) ? : [] as $row) : 
                for($j=0; $j<count(is_countable($row["lokasiManuverNormal"]) ? $row["lokasiManuverNormal"] : [] ); $j++) {
            ?>
                        
                        <tr>
                            <td><?= $i; ?></td>
                            <td><input type="text" name="lokasiManuverNormal[]" value="<?= $row['lokasiManuverNormal'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                            <td><input type="text" name="installManuverNormal[]"value="<?= $row['installManuverNormal'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                            <!-- <td>
                                <button type="button" class="btn red" onclick="hapus3(this)">x</button>
                                <input type="text" name="id3[]" value="<?= $data3['id']; ?>" hidden>
                            </td> -->
                        </tr>  
                        <?php  $i++; ?>
            <?php } endforeach?>

                    </tbody>
                </table>
                    <button type="button" id="add3" class="btn btn-success" onclick="tambahRow(0,'lokasiManuverNormal[]','installManuverNormal[]','tableBody3',0)">+</button>
                    <button type="button" id="remove3" class="btn red" onclick="kurangRow('tableBody3')">-</button> 
            </div>  
            
            
        </div> <br>
                   
<?php } else { ?>

    <br>
    <div class="flex-container">
        <div class="grid-item titel">Lokasi</div>
        <div class="grid-item titel">Manuver Pembebasan</div>
        <div class="grid-item titel">Manuver Penormalan</div>
        <div class="grid-item flex" style="border-right:none;">
            <a href="?url=hapusAjaxParent&id=<?= $data4['id_lokasi'];?>" onclick="return confirm('anda yakin menghapus parent dari <?= $data4['nama']?>?')">
                <button type="button" class="btn red">Delete Parent</button>
            </a>

            <a href="?url=hapusAjax&id=<?= $data4['id_lokasi_detail'];?>" onclick="return confirm('anda yakin menghapus <?= $data4['nama']?>?')">
                    <button type="button" class="btn red">Delete</button>
            </a>

            <div style="display:flex;">
                <label for="">Lokasi</label><br>
                <input type="text" name="nama_lokasi" value="<?= $ambil["nama"]; ?>">
            </div>
            
            <div style="display:flex">
                <label for="">Detail Lokasi</label><br>
                <input type="text" name="nama_lokasi_detail" value="<?= $data4['nama']?>">
            </div>
                
        </div>
        <div class="grid-item" style="border-left:none;border-right:none"></div>
        <div class="grid-item" style="border-left:none;"></div>
        <div class="grid-item">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th >Lokasi</th>
                    </tr>
                </thead>
                <tbody id="tableBody1">
                    <?php
                        foreach (unserialize($data["pengawas"]) ? : [] as $row) : 
                        for($j=0; $j<count(is_countable($row["lokasiPembebasan"]) ? $row["lokasiPembebasan"] : []); $j++) {
                    ?>
                        <tr >
                            <td><input type="text" name="lokasiPembebasan[]" value="<?= $row['lokasiPembebasan'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                            <!-- <td><button type="button" class="btn red" onclick="hapus1(this)">x</button><input type="text" name="id1[]" value="<?= $data['id']; ?>" hidden></td> -->
                        </tr>
                    <?php } endforeach ?>
                </tbody>
            </table>
            <div class="form-button">
                <button type="button" id="add1" class="btn btn-success" onclick="tambah1('tableBody1',i)">+</button>
                <button type="button" id="remove1" class="btn red" onclick="kurang1()">-</button> 
            </div>
        </div>


        <div class="grid-item">
            <?php 
                foreach (unserialize($data["manuver_bebas"]) as $row ) :  
                    $maxIndex = intval(end($row["idBebas"]));
                    for ($i=0; $i<=$maxIndex; $i++) {  
            ?>
            <div class="flex-container-sub">
                <div class="grid-item " style="">
                    <?= $i ?>
                    <input type="text" name="titelBebas[]" value="<?= $row["titelBebas"][$i] ?>">
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th style="width:33%">No</th>
                                <th style="width:33%">Lokasi</th>
                                <th style="width:33%">Installasi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody2<?= $i ?>">
                        <?php $k=1; for($j=0; $j< count($row["lokasiManuverBebas"]); $j++) { 
                            if ($row["idBebas"][$j] == $i) {
                                ?>
                            <tr>
                                <td><?= $k ?></td>
                                <td><input type="text" name="" value="<?= $row["lokasiManuverBebas"][$j] ?>"></td> <!--0 belakang row hilang-->
                                <td><input type="text" name="" value="<?= $row["installManuverBebas"][$j] ?>"><input type="text" name="idBebas[]" value="<?= $row["idBebas"][$j] ?>"></td> 
                            </tr>

                            <?php $k++; } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php //} ?>
                        <button type="button" id="add2" class="btn btn-success" onclick="tambahRow(<?= $i ?>,'lokasiBebas[]','installManuverBebas[]','tableBody2','idBebas[]')">+</button>
                        <button type="button" id="remove2" class="btn btn-danger" onclick="kurangRow('tableBody2<?= $i ?>')">-</button>
                    
                </div>
                <div class="grid-item form2 bottonBebas" id="bottonBebas">
                    <button type="button" onclick="tambahForm(0,'copyForm1','titelBebas[]','lokasiManuverBebas[]','installManuverBebas[]','tableBody2<?= $i ?>','idBebas[]','openBebas','openBebasOld')">+</button> <!--class="bottonBebas"--> 
                </div>
            </div>
            <?php  } endforeach; ?>  
            
            <div id="copyForm1">

            </div>
     
        </div>
        <div class="grid-item">
            <?php 
                foreach (unserialize($data["manuver_normal"]) as $row ) :  
                    $maxIndex = intval(end($row["idNormal"]));
                    for ($i=0; $i<=$maxIndex; $i++) {  
            ?>
            <div class="flex-container-sub">
                <div class="grid-item " style="">
                <?= $i ?>
                    <input type="text" name="titelNormal[]" value="<?= $row["titelNormal"][$i] ?>">
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th style="width:33%">No</th>
                                <th style="width:33%">Lokasi</th>
                                <th style="width:33%">Installasi</th>
                            </tr>
                        </thead>
                        <?php $k=1; for($j=0; $j< count($row["lokasiManuverNormal"]); $j++) { 
                            if ($row["idNormal"][$j] == $i) {
                                ?>
                        <tbody id="tableBody3">
                            <tr>
                                <td><?= $k ?></td>
                                <td><input type="text" name="" value="<?= $row["lokasiManuverNormal"][$j] ?>"></td> <!--0 belakang row hilang-->
                                <td><input type="text" name="" value="<?= $row["installManuverNormal"][$j] ?>"><input type="text" name="idNormal[]" value="<?= $row["idNormal"][$j] ?>"></td> 
                            </tr>

                            <?php $k++; } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                        <button type="button" id="add3" class="btn btn-success" onclick="tambahRow(<?= $i ?>,'lokasiManuverNormal[]','installManuverNormal[]','tableBody3','idNormal[]')">+</button>
                        <button type="button" id="remove3" class="btn btn-danger" onclick="kurangRow('tableBody3<?= $i ?>')">-</button>
                </div>
                <div class="grid-item form2 bottonNormal" id="bottonNormal">
                    <button type="button" onclick="tambahForm(0,'copyForm2','titelNormal[]','lokasiManuverNormal[]','installManuverNormal[]','tableBody3<?= $i ?>','idNormal[]','closeNormal','closeNormalOld')">+</button>
                </div>
            </div> 
            <?php  } endforeach; ?>  
            <div id="copyForm2">

            </div>
        </div>   
    </div>
<?php } ?>
<script>
    
   
</script>


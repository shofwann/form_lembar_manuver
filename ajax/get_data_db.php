<?php
include 'functions.php';

// sumber:
// initiator-updateDB.php
// shofwan.js

$idnya = $_POST["idDetailLokasi"];
$idnya = trim($idnya);
$query = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi_detail='{$idnya}'");
$data = mysqli_fetch_assoc($query);


?>
<!-- <link rel="stylesheet" href="css/style.css"> -->
<?php error_reporting(E_ALL ^ E_NOTICE);  ?>
 
    <div class="grid__item grid__item_item0013 border_right border_bottom" style="margin-right:20px;">
        <table class="table table-bordered" >
            <thead>
                <tr id="tableHead">
                    <th>Lokasi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody1">
            <?php
                foreach (unserialize($data["pengawas"]) ? : [] as $row) : 
                    for($j=0; $j<count(is_countable($row["lokasiPembebasan"]) ? $row["lokasiPembebasan"] : []); $j++) {
            ?>
                <tr >
                    <td><input type="text" name="lokasiPembebasan[]" value="<?= $row['lokasiPembebasan'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td><button type="button" class="btn red" onclick="hapus1(this)">x</button><input type="text" name="id1[]" value="<?= $data['id']; ?>" hidden></td>
                </tr>
                <?php } endforeach ?>
            </tbody>
            <tfoot id="tableBody1n">

            </tfoot>
        </table>
            <button type="button" id="add1" class="btn btn-success" onclick="tambah1()">+</button>
    </div>
    <div class="grid__item grid__item_item0014 border_right border_bottom" style="margin-right:5px;margin-left:5px;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lokasi</th>
                    <th>Installasi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php $i=1; ?>
            <?php
            foreach (unserialize($data["manuver_bebas"]) ? : [] as $row) : 
                for($j=0; $j<count(is_countable($row["lokasiManuverBebas"]) ? $row["lokasiManuverBebas"] : [] ); $j++) {
            ?>
            <tbody id="tableBody2">
                <tr>
                    <td><?= $i; ?></td>
                    <td><input type="text" name="lokasiManuverBebas[]" value="<?= $row['lokasiManuverBebas'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td><input type="text" name="installManuverBebas[]" value="<?= $row['installManuverBebas'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td>
                        <button type="button" class="btn red" onclick="hapus2(this)">x</button>
                        <input type="text" name="id2[]" value="<?= $data2['id']; ?>" hidden>
                    </td>
                </tr>
            </tbody>
            <?php  $i++; ?>
            <?php } endforeach?>
            <tfoot id="tableBody2n">

            </tfoot>
        </table>
            <button type="button" id="add2" class="btn btn-success" onclick="tambah2()">+</button>
    </div>
    <div class="grid__item grid__item_item0015 border_right border_bottom" style="margin-left:10px;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lokasi</th>
                    <th>Installasi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php $i=1; ?>
            <?php
            foreach (unserialize($data["manuver_normal"]) ? : [] as $row) : 
                for($j=0; $j<count(is_countable($row["lokasiManuverNormal"]) ? $row["lokasiManuverNormal"] : [] ); $j++) {
            ?>
            <tbody id="tableBody3">
                <tr>
                    <td><?= $i; ?></td>
                    <td><input type="text" name="lokasiManuverNormal[]" value="<?= $row['lokasiManuverNormal'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td><input type="text" name="installManuverNormal[]"value="<?= $row['installManuverNormal'][$j]; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td>
                        <button type="button" class="btn red" onclick="hapus3(this)">x</button>
                        <input type="text" name="id3[]" value="<?= $data3['id']; ?>" hidden></td>
                </tr>   
            </tbody>
            <?php  $i++; ?>
            <?php } endforeach?>
            <tfoot id="tableBody3n">

            </tfoot>
        </table>
            <button type="button" id="add3" class="btn btn-success" onclick="tambah3()">+</button> 
    </div>

        
    <?php $sql = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi_detail = '{$idnya}'"); 
            while ($data4 = mysqli_fetch_assoc($sql)) {
            $data_lokasi = mysqli_query($conn,"SELECT nama FROM db_ajax_lokasi WHERE id_lokasi = $data4[id_lokasi]");
            $ambil = mysqli_fetch_assoc($data_lokasi);
    ?>
    
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

    
    <?php } ?>

    

                    
                    
               
<script>
    
    
</script>


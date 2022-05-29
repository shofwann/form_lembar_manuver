<?php
include 'functions.php';

// sumber:
// initiator-updateDB.php
// shofwan.js

$idnya = $_POST["idDetailLokasi"];
$idnya = trim($idnya);



?>
<!-- <link rel="stylesheet" href="css/style.css"> -->
 
    <div class="grid__item grid__item_item0013 border_right border_bottom" style="margin-right:20px;">
        <table class="table table-bordered" >
            <thead>
                <tr id="tableHead">
                    <th>Lokasi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
            $query = "SELECT * FROM db_ajax_table_pengawas WHERE id_lokasi_detail='{$idnya}'";
            $result = mysqli_query($conn,$query);
            while ($data = mysqli_fetch_assoc($result)){
            ?>
            <tbody id="tableBody1">
                <tr >
                    <td><input type="text" name="lokasi1[]" value="<?= $data['lokasi']; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td><button type="button" class="btn red" onclick="hapus1(this)">x</button><input type="text" name="id1[]" value="<?= $data['id']; ?>" hidden></td>
                </tr>
            </tbody>
            <?php } ?>
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
            $query2 = "SELECT * FROM db_ajax_table_tahapan WHERE id_lokasi_detail='{$idnya}' AND tahapan='pembebasan'";
            $result2 = mysqli_query($conn,$query2);
            while ($data2 = mysqli_fetch_assoc($result2)){
            ?>
            <tbody id="tableBody2">
                <tr>
                    <td><?= $i; ?></td>
                    <td><input type="text" name="lokasi2[]" value="<?= $data2['lokasi']; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td><input type="text" name="installasi2[]" value="<?= $data2['installasi']; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td>
                        <button type="button" class="btn red" onclick="hapus2(this)">x</button>
                        <input type="text" name="id2[]" value="<?= $data2['id']; ?>" hidden>
                    </td>
                </tr>
            </tbody>
            <?php  $i++; ?>
            <?php } ?>
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
            <?php $j=1; ?>
            <?php
            $query3 = "SELECT * FROM db_ajax_table_tahapan WHERE id_lokasi_detail='{$idnya}' AND tahapan='penormalan'";
            $result3 = mysqli_query($conn,$query3);
            while ($data3 = mysqli_fetch_assoc($result3)){
            ?>
            <tbody id="tableBody3">
                <tr>
                    <td><?= $j; ?></td>
                    <td><input type="text" name="lokasi3[]" value="<?= $data3['lokasi']; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td><input type="text" name="installasi3[]"value="<?= $data3['installasi']; ?>" style="background-color:#fff;outline:none;border-color:#fff;"></td>
                    <td>
                        <button type="button" class="btn red" onclick="hapus3(this)">x</button>
                        <input type="text" name="id3[]" value="<?= $data3['id']; ?>" hidden></td>
                </tr>   
            </tbody>
            <?php  $j++; ?>
            <?php } ?>
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


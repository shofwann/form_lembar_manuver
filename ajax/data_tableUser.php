<?php
require "../functions.php";
$keyword = $_GET["keyword"];
$query = "SELECT * FROM db_user WHERE username LIKE '%$keyword%' OR level LIKE '%$keyword%'";
$folder = query($query);




 

?>

<table class="" cellpadding="5" cellspacing="0" style="width:50%">
        <thead>
            <tr>
                <th rowspan="2" style="width: 50px;">No.</th>
                <th rowspan="2" style="width: 100px;">Nama</th>
                <th rowspan="2"style="width: 100px;">Level</th>
                <th colspan="2">Action</th>
            </tr>
            <tr>
                <th style="width: 50px;">Ubah</th>
                <th style="width: 50px;">Hapus</th>
            </tr>
        </thead>
    <tbody>
        <?php $no=1; ?>
        <?php foreach ( $folder as $data) : ?>
            
                <tr>
                    <td><?= $no+$awalDataUser; ?></td>
                    <td><?= $data["username"]; ?></td>
                    <td><?= $data["level"]; ?></td>
                    <td><a href="?url=userUbah&id=<?= $data["id"]; ?>"><i class="fa fa-pencil"></i></a></td>
                    <td><a href="?url=userHapus&id=<?= $data["id"]; ?>" onclick="return confirm('Apakah anda yakin menghapus <?= $data['username']; ?>?')"><i class="fa fa-trash"></i></a></td>
                </tr>
                <?php $no++; ?>
        <?php endforeach; ?> 

    </tbody>
    
</table> 
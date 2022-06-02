<?php
if (!isset($_SESSION["username"])) {
	echo "<script>Anda Belum Login</script>";
  header("location:index.php");
	exit;
}

require "functions.php";

if( isset($_POST["submit"]) ){

    if( tambahUser($_POST) > 0){
        //var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data berhasil disubmit'); 
                document.location.href = 'home.php?url=users';
                </script>
                ";  
                
    } else {
       // var_dump(tambah($_POST)); die;
        echo "<script>
                alert('data gagal disubmit'); 
                document.location.href = 'home.php?url=users';
                </script>
                "; die;
                
    }
}





$sql = mysqli_query($conn,"SELECT * FROM db_user ORDER By id DESC LIMIT $awalDataUser,$jumlahDataPerHalaman");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="card">
        <div class="card-header">
            Users
        </div>
        <div class="container-wrap">
            <div class="container">
                <form action="" method="post">
                    <table style="width:50%">
                        <tr>
                            <td>nama</td>
                            <td>:</td>
                            <td><input type="text" name="nama" placeholder="Masukkan nama user"></td>
                        </tr>
                        <tr>
                            <td>level</td>
                            <td>:</td>
                            <td>
                                <select name="level" id="">
                                    <option value="">-pilih-</option>
                                    <option value="admin">Admin</option>
                                    <option value="initiator">Initiator</option>
                                    <option value="amn">AMN</option>
                                    <option value="msb">MSB</option>
                                    <option value="dispa">Dispa</option>
                                    <option value="amn_dispa">Amn Dispa</option>
                                    <option value="plh_amn">PLH AMN</option>
                                    <option value="plh_msb">PLH MSB</option>
                                    <option value="plh_amndispa">PLH AMN Dispa</option>
                                    <option value="all">All</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3"><button type="submit" name="submit">Tambah</button></td>
                            <td><input type="text" placeholder="Search name/level..." id="keyword"><button type="button" id="cari"></button></td>
                        </tr>
                    </table>
                </form>
                
                <div class="rubah" id="bungkus">
                    <table class="" style="width:50%" >
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
                            <?php if(mysqli_num_rows($sql) > 0) { ?>
                                <?php while($data = mysqli_fetch_assoc($sql)) { ?>
                                    <tr>
                                        <td><?= $no+$awalDataUser; ?></td>
                                        <td><?= $data["username"]; ?></td>
                                        <td><?= $data["level"]; ?></td>
                                        <td><a href="?url=userUbah&id=<?= $data["id"]; ?>"><i class="fa fa-pencil"></i></a></td>
                                        <td><a href="?url=userHapus&id=<?= $data["id"]; ?>" onclick="return confirm('Apakah anda yakin menghapus <?= $data['username']; ?>?')"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                    <?php if ($halamanAktifUser > 1) :?>
                        <a href="home.php?url=users&page=<?= $halamanAktifUser -1; ?>">&laquo;</a>
                    <?php endif; ?>

                    <?php for($i=1; $i<= $jumlahHalamanUser; $i++) : ?>
                            <?php if( $i == $halamanAktifUser) : ?>
                                <a href="home.php?url=users&page=<?= $i; ?>" style="font-weight:bold;color:red;"><?= $i; ?></a>
                            <?php else : ?>
                                <a href="home.php?url=users&page=<?= $i; ?>"><?= $i; ?></a>
                            <?php endif; ?>
                    <?php endfor?>

                    <?php if ($halamanAktifUser < $jumlahHalamanUser) :?>
                        <a href="home.php?url=users&page=<?= $halamanAktifUser + 1; ?>">&raquo;</a>
                    <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
        var keyword = document.getElementById('keyword');
        var cari = document.getElementById('cari');
        var bungkus = document.getElementById('bungkus');

        keyword.addEventListener('keyup', function()  {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if( xhr.readyState == 4 && xhr.status == 200 ) { 
                    bungkus.innerHTML = xhr.responseText;
                }
            }


        xhr.open('GET','ajax/data_tableUser.php?keyword=' + keyword.value , true);

        xhr.send();


        });

        cari.style.display="none";

    </script>
</body>
</html>
<?php
$conn=mysqli_connect("localhost","root","","db_lm");
date_default_timezone_set('Asia/Jakarta');

$jumlahDataPerHalaman = 10;

// untuk link pekerjaan
$totalData = count(query("SELECT * FROM db_form"));
$jumlahHalaman = ceil($totalData/$jumlahDataPerHalaman);
if (isset($_GET['halaman'])){
    $halamanAktif = $_GET['halaman'];
} else {
    $halamanAktif =1;
}

$dataAwal = ($halamanAktif * $jumlahDataPerHalaman)-$jumlahDataPerHalaman;  //data pertama ditabel
$jumlahLink = 2;

if ($halamanAktif > $jumlahLink) {
    $star_number = $halamanAktif - $jumlahLink;
} else {
    $star_number = 1;
}

if($halamanAktif < ($jumlahHalaman-$jumlahLink)){
    $end_number = $halamanAktif + $jumlahLink;
} else {
    $end_number = $jumlahHalaman;
}

// untuk user list
//$jumlahDataPerHalamanUser = 10;
$jumlahDataUser = count(query("SELECT * FROM db_user"));
$jumlahHalamanUser = ceil($jumlahDataUser / $jumlahDataPerHalaman);
$halamanAktifUser = ( isset($_GET["page"]) ) ? $_GET["page"] : 1;
$awalDataUser = ($jumlahDataPerHalaman * $halamanAktifUser) - $jumlahDataPerHalaman;

$joinLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis= 3 AND db_ajax_lokasi.nama='tambun' AND db_ajax_lokasi_detail.nama='ibt-1'");
$isiJoin = mysqli_fetch_assoc($joinLokasiDetail);

// var_dump($isiJoin);
$jumlah = mysqli_num_rows($joinLokasiDetail);

echo $isiJoin["id_lokasi_detail"];

function query($query){
    global $conn;
    $result = mysqli_query($conn,$query); //kotaknya
    $rows = []; //siapkan wadah kosong
    while($row = mysqli_fetch_assoc($result)){
        $rows [] = $row;
    }
    return $rows; //mengembalikan kotaknya yg dipilih
}

function tambah($post){
    // var_dump($post); die;
    global $conn;
    $create_date = $post["create_date"];//ok
    $user = $post["user"]; ;//ok
    $idTask =$post["idTask"];//ok
    $jenis = $post["jenis_pekerjaan"];// ==================================== newwww
    $pilihanDB = $post["chose_db"];// ===============================newwww
    $pekerjaan = htmlspecialchars($post["pekerjaan"]);//ok
    $date = $post["date"];
    $start = $post["start"];
    $end = $post["end"];
    $lokasi = strtolower(ltrim(rtrim(htmlspecialchars($post["lokasi"]))));//================ke DB
    $instal = strtolower(ltrim(rtrim(htmlspecialchars($post["instal"]))));//================ ke DB
    $catatanPraBebas = htmlspecialchars($post["catatan_pra_bebas"]);
    $catatanPraNormal =htmlspecialchars($post["catatan_pra_normal"]);
    
    //upload gambar
    $foto = upload("foto"); 
     if( !$foto ){
         return false;
     }

    $foto2 = upload("foto2"); 
    if( !$foto2 ){
        return false;
    }
    //print_r($_POST);exit;
    // cara-1
       
    $query = "INSERT INTO db_form (id,create_date,user,pekerjaan,date,start,end,lokasi,installasi,foto,foto2,catatan_pra_pembebasan,catatan_pra_penormalan,status,jenis_pekerjaan,chose_db) VALUES ($idTask,'$create_date','$user','$pekerjaan','$date','$start','$end','$lokasi','$instal','$foto','$foto2','$catatanPraBebas','$catatanPraNormal','amn',$jenis,$pilihanDB)";
    mysqli_query($conn,$query);
    
    if (isset($post["lokasiPembebasan"])){
        $jumlah_baris = count($_POST["lokasiPembebasan"]);
        for ($i=0; $i<$jumlah_baris; $i++) {
            $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
            $query = "INSERT INTO db_table_pengawas (id_form,lokasi) VALUES ($idTask,'$lokasiManuverBebas')";
            mysqli_query($conn,$query);
        }
    } else {
        echo "<script>
        alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
    }

    if (isset($post["lokasiManuverBebas"])){
        $rows_tabel_3 = count($_POST["lokasiManuverBebas"]);
        for ($i=0; $i<$rows_tabel_3; $i++) {
            $lokasiManuverBebas = $_POST["lokasiManuverBebas"][$i];
            $installManuverBebas = $_POST["installManuverBebas"][$i];
            $query = "INSERT INTO db_table_tahapan (id_form,lokasi,installasi,tahapan) VALUES ($idTask,'$lokasiManuverBebas','$installManuverBebas','pembebasan')";
            mysqli_query($conn,$query);
        }
    } else {
        echo "<script>
                alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
    }

    if (isset($post["lokasiManuverNormal"])){
        $rows_tabel_4 = count($_POST["lokasiManuverNormal"]);
        for ($i=0; $i<$rows_tabel_4; $i++) {
            $lokasiManuverNormal = $_POST["lokasiManuverNormal"][$i];
            $installManuverNormal = $_POST["installManuverNormal"][$i];
            $query = "INSERT INTO db_table_tahapan (id_form,lokasi,installasi,tahapan) VALUES ($idTask,'$lokasiManuverNormal','$installManuverNormal','penormalan')";
            mysqli_query($conn,$query);
        }
    } else {
        echo "<script>
        alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
            }
            
 // ==================================digunakan untuk memasukkan database manuver==========================
    $joinLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis=$jenis AND db_ajax_lokasi.nama='$lokasi' AND db_ajax_lokasi_detail.nama='$instal'");
    $isiJoin = mysqli_fetch_assoc($joinLokasiDetail);

    // $query2 = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE id_jenis = $jenis AND nama='$lokasi'");
    // $data2 = mysqli_fetch_assoc($query2);
    
    // $query3 = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi = $data2[id_lokasi] AND nama='$instal' ");
    // $data3 = mysqli_fetch_assoc($query3);
    
    $idLokasi = mysqli_query($conn,"SELECT id_lokasi FROM db_ajax_lokasi ORDER BY id_lokasi DESC LIMIT 1");
    $ambilIdLokasi = mysqli_fetch_assoc($idLokasi);
    
    $idLokasiDetail = mysqli_query($conn,"SELECT id_lokasi_detail FROM db_ajax_lokasi_detail ORDER BY id_lokasi_detail DESC LIMIT 1");
    $ambilIdLokasiDetail = mysqli_fetch_assoc($idLokasiDetail);

    // $list1 = mysqli_num_rows($query2);
    // $list2 = mysqli_num_rows($query3);

    // ============================================digunakan untuk form-1 reguler==============================================================
    if ($pilihanDB == 1) {

        // if (($list1 == 0) && ($list2 == 0)){

        if  (mysqli_num_rows($joinLokasiDetail) == 0) {
            
            mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
            mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama) VALUES ($ambilIdLokasi[id_lokasi]+1,'$instal')");

            if (isset($post["lokasiPembebasan"])){
                $jumlah_baris = count($_POST["lokasiPembebasan"]);
                for ($i=0; $i<$jumlah_baris; $i++) {
                    $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
                    mysqli_query($conn,"INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas')");
                }
            } else {
                echo "<script>
                        alert ('Anda belum memasukkan lokasi GITET');
                        history.back(-1);
                     </script>";
            }

            
            if (isset($post["lokasiManuverBebas"])){
                $rows_tabel_3 = count($_POST["lokasiManuverBebas"]);
                for ($i=0; $i<$rows_tabel_3; $i++) {
                    $lokasiManuverBebas = $_POST["lokasiManuverBebas"][$i];
                    $installManuverBebas = $_POST["installManuverBebas"][$i];
                    mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas','$installManuverBebas','pembebasan')");
                }
            } else {
                echo "<script>
                        alert ('Anda belum memasukkan lokasi GITET');
                        history.back(-1);
                    </script>";
            }

            
            if (isset($post["lokasiManuverNormal"])){
                $rows_tabel_4 = count($_POST["lokasiManuverNormal"]);
                for ($i=0; $i<$rows_tabel_4; $i++) {
                    $lokasiManuverNormal = $_POST["lokasiManuverNormal"][$i];
                    $installManuverNormal = $_POST["installManuverNormal"][$i];
                    mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverNormal','$installManuverNormal','penormalan')");
                }
            } else {
                echo "<script>
                        alert ('Anda belum memasukkan lokasi GITET');
                        history.back(-1);
                    </script>";
            }
        } 
    
        // =====================================================digunakan untuk form auto-1==========================================================
    } elseif ( $pilihanDB == 2) {

        if ( mysqi_num_rows($joinLokasiDetail) == 1 ) {

            $jumlah_baris1 = count($_POST["lokasiPembebasan"]);
            for ($i=0; $i<$jumlah_baris1; $i++) {
                $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
                $idUpdate = $_POST["id_ajax_update_petugas"][$i];
                if ($idUpdate == '0'){
                    $query = "INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ($isiJoin[id_lokasi_detail],'$lokasiManuverBebas')";
                } else {
                    $query = "UPDATE db_ajax_table_pengawas SET lokasi = '$lokasiManuverBebas' WHERE id=$idUpdate"; //id_form = '$idTask',
                }
                mysqli_query($conn,$query);
    
            }
    
            if(isset($post["id_ajax_hapus_petugas"])){
                $jumlah_hapus = count($post["id_ajax_hapus_petugas"]);
                for ($i=0; $i<$jumlah_hapus; $i++){
                    $id_hapus = $post["id_ajax_hapus_petugas"][$i];
                    $query = "DELETE FROM db_ajax_table_pengawas WHERE id=$id_hapus";
                    
                }
                mysqli_query($conn,$query);
            }

            $jumlah_baris2 = count($post["lokasiManuverBebas"]);
            for ($i=0; $i<$jumlah_baris2; $i++){
                $lokasi = $post["lokasiManuverBebas"][$i];
                $installasi = $post["installManuverBebas"][$i];
                $idUpdate = $post["id_ajax_update_bebas"][$i];
                if ($idUpdate == "0"){
                    $query = "INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($isiJoin[id_lokasi_detail],'$lokasi','$installasi','pembebasan')";
                } else{
                    $query = "UPDATE db_ajax_table_tahapan SET lokasi='$lokasi', installasi='$installasi' WHERE id=$idUpdate";
                }
                mysqli_query($conn,$query);
            }
        
            if(isset($post["id_ajax_hapus_bebas"])){
                $jumlah_hapus = count($post["id_ajax_hapus_bebas"]);
                for ($i=0; $i<$jumlah_hapus; $i++){
                    $id_hapus = $post["id_ajax_hapus_bebas"][$i];
                    $query = "DELETE FROM db_ajax_table_tahapan WHERE id=$id_hapus";
                    
                }
                mysqli_query($conn,$query);
            }

            $jumlah_baris3 = count($post["lokasiManuverNormal"]);
            for ($i=0; $i<$jumlah_baris3; $i++){
                $lokasi = $post["lokasiManuverNormal"][$i];
                $installasi = $post["installManuverNormal"][$i];
                $idUpdate = $post["id_ajax_update_normal"][$i];
                if ($idUpdate == "0"){
                    $query = "INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($isiJoin[id_lokasi_detail],'$lokasi','$installasi','penormalan')";
                } else{
                    $query = "UPDATE db_ajax_table_tahapan SET lokasi='$lokasi', installasi='$installasi' WHERE id=$idUpdate";
                }
                mysqli_query($conn,$query);
            }
        
            if(isset($post["id_ajax_hapus_normal"])){
                $jumlah_hapus = count($post["id_ajax_hapus_normal"]);
                for ($i=0; $i<$jumlah_hapus; $i++){
                    $id_hapus = $post["id_ajax_hapus_normal"][$i];
                    $query = "DELETE FROM db_ajax_table_tahapan WHERE id=$id_hapus";
                    
                }
                mysqli_query($conn,$query);
                return mysqli_affected_rows($conn);
            }
 
        } else {

            mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
            mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama) VALUES ($ambilIdLokasi[id_lokasi]+1,'$instal')");

            if (isset($post["lokasiPembebasan"])){
                $jumlah_baris = count($_POST["lokasiPembebasan"]);
                for ($i=0; $i<$jumlah_baris; $i++) {
                    $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
                    mysqli_query($conn,"INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas')");
                }
            } else {
                echo "<script>
                        alert ('Anda belum memasukkan lokasi GITET');
                        history.back(-1);
                     </script>";
            }

            
            if (isset($post["lokasiManuverBebas"])){
                $rows_tabel_3 = count($_POST["lokasiManuverBebas"]);
                for ($i=0; $i<$rows_tabel_3; $i++) {
                    $lokasiManuverBebas = $_POST["lokasiManuverBebas"][$i];
                    $installManuverBebas = $_POST["installManuverBebas"][$i];
                    mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas','$installManuverBebas','pembebasan')");
                }
            } else {
                echo "<script>
                        alert ('Anda belum memasukkan lokasi GITET');
                        history.back(-1);
                    </script>";
            }

            
            if (isset($post["lokasiManuverNormal"])){
                $rows_tabel_4 = count($_POST["lokasiManuverNormal"]);
                for ($i=0; $i<$rows_tabel_4; $i++) {
                    $lokasiManuverNormal = $_POST["lokasiManuverNormal"][$i];
                    $installManuverNormal = $_POST["installManuverNormal"][$i];
                    mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverNormal','$installManuverNormal','penormalan')");
                }
            } else {
                echo "<script>
                        alert ('Anda belum memasukkan lokasi GITET');
                        history.back(-1);
                    </script>";
            }
        }
    }


    return mysqli_affected_rows($conn);
}

function ubah($post){
    global $conn;
    //var_dump($post); die;
    $idTask =$post["idTask"];
    $fotolama1 = $post["fotoLama1"];
    $fotolama2 = $post["fotoLama2"];
    $pekerjaan = htmlspecialchars($post["pekerjaan"]);
    $date = $post["date"];
    $start = $post["start"];
    $end = $post["end"];
    $lokasi = strtolower(ltrim(rtrim(htmlspecialchars($post["lokasi"]))));
    $instal = strtolower(ltrim(rtrim(htmlspecialchars($post["instal"]))));
    $catatanPraBebas = htmlspecialchars($post["catatan_pra_bebas"]);
    $catatanPraNormal =htmlspecialchars($post["catatan_pra_normal"]);
    $level = $post["level"];
    $potongLevel = substr($level,4);
    $jenis = $post["jenis_pekerjaan"];
    $pilihanDB = $post["chose_db"];

    //var_dump($_FILES['foto']); die;
    //cek apakah user ganti foto1
    if( $_FILES['foto']['error'] === 4){
        $foto = $fotolama1;
    } else {
        $foto = upload("foto");
    }

    //cek apakah user ganti foto2
    if( $_FILES['foto2']['error'] === 4){
        $foto2 = $fotolama2;
    } else {
        $foto2 = upload("foto2");
    }

    if (strlen($level) == 9) {
        mysqli_query($conn,"UPDATE db_form SET level_user = '$level' WHERE id = $idTask");
    } else {
        mysqli_query($conn,"UPDATE db_form SET level_user = '$potongLevel' WHERE id = $idTask");
    }

    $jumlah_baris_pelaksana = count($_POST["lokasiPembebasan"]);
    for($i=0; $i<$jumlah_baris_pelaksana; $i++) {
        $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
        $idUpdate = $_POST["id_update_petugas"][$i];
        if ($idUpdate == '0'){
            $query = "INSERT INTO db_table_pengawas (id_form,lokasi) VALUES ('$idTask','$lokasiManuverBebas')";
        } else {
            $query = "UPDATE db_table_pengawas SET lokasi = '$lokasiManuverBebas' WHERE id=$idUpdate"; //id_form = '$idTask',
        }

        mysqli_query($conn,$query);
        mysqli_affected_rows($conn);

    }

    if (isset($_POST["id_hapus_petugas"])){
        $jumlah_hapus = count($_POST["id_hapus_petugas"]);
        for ($i=0; $i<$jumlah_hapus; $i++) {
            $id_hapus = $_POST["id_hapus_petugas"][$i];
            $query = "DELETE FROM db_table_pengawas WHERE id='$id_hapus'";
            mysqli_query($conn,$query);
        }
        mysqli_affected_rows($conn);
    }

    $jumlah_baris_bebas = count($_POST["lokasiManuverBebas"]);
    for($i=0; $i<$jumlah_baris_bebas; $i++){
        $lokasiPembebasanManuver = $_POST["lokasiManuverBebas"][$i];
        $intallasiPembebasan = $_POST["installManuverBebas"][$i];
        $idUpdateBebas = $_POST["id_update_bebas"][$i];
        if ($idUpdateBebas == '0') {
            $query = "INSERT INTO db_table_tahapan (id_form,lokasi,installasi,tahapan) VALUES ('$idTask','$lokasiPembebasanManuver','$intallasiPembebasan','pembebasan')";
        } else {
            $query = "UPDATE db_table_tahapan SET lokasi = '$lokasiPembebasanManuver', installasi = '$intallasiPembebasan' WHERE id = $idUpdateBebas ";
        }
        mysqli_query($conn,$query);
        mysqli_affected_rows($conn);
    }

    if (isset($_POST["id_hapus_bebas"])){
        $jumlah_hapus = count($_POST["id_hapus_bebas"]);
        for ($i=0; $i<$jumlah_hapus; $i++) {
            $id_hapus = $_POST["id_hapus_bebas"][$i];
            $query = "DELETE FROM db_table_tahapan WHERE id='$id_hapus'";
            mysqli_query($conn,$query);
        }
        mysqli_affected_rows($conn);
    }

    $jumlah_baris_normal = count($_POST["lokasiManuverNormal"]);
    for($i=0; $i<$jumlah_baris_normal; $i++){
        $lokasiPenormalanManuver = $_POST["lokasiManuverNormal"][$i];
        $installasiPenormalan = $_POST["installManuverNormal"][$i];
        $idUpdateNormal = $_POST["id_update_normal"][$i];
        if ($idUpdateNormal == '0') {
            $query = "INSERT INTO db_table_tahapan (id_form,lokasi,installasi,tahapan) VALUE ('$idTask','$lokasiPenormalanManuver','$installasiPenormalan','penormalan')";
        } else {
            $query = "UPDATE db_table_tahapan SET lokasi = '$lokasiPenormalanManuver', installasi = '$installasiPenormalan' WHERE id = $idUpdateNormal ";
        }
        mysqli_query($conn,$query);
        mysqli_affected_rows($conn);
    }

    if (isset($_POST["id_hapus_normal"])){
        $jumlah_hapus = count($_POST["id_hapus_normal"]);
        for ($i=0; $i<$jumlah_hapus; $i++) {
            $id_hapus = $_POST["id_hapus_normal"][$i];
            $query = "DELETE FROM db_table_tahapan WHERE id='$id_hapus'";
            mysqli_query($conn,$query);
        }
        mysqli_affected_rows($conn);

    }

    $query = "UPDATE db_form SET
              pekerjaan = '$pekerjaan',
              date = '$date',
              start = '$start',
              end = '$end',
              lokasi = '$lokasi',
              installasi = '$instal',
              foto = '$foto', 
              foto2 = '$foto2',
              status = 'amnUpdate',
              catatan_pra_pembebasan = '$catatanPraBebas',
              catatan_pra_penormalan = '$catatanPraNormal'
              WHERE id = $idTask ";
    mysqli_query($conn,$query);

    $dataAjax = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis=$jenis AND db_ajax_lokasi.nama= '$lokasi' AND db_ajax_lokasi_detail.nama='$instal'");
    $isiDataAjax = mysqli_fetch_assoc($dataAjax);

    if ($pilihanDB == 1 || $pilihanDB == 2 ) {
        
        if ( mysqli_num_rows($dataAjax) == 1) {

            $jumlah_baris1 = count($_POST["lokasiPembebasan"]);
            for ($i=0; $i<$jumlah_baris1; $i++) {
                $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
                $idUpdate = $_POST["id_ajax_update_petugas"][$i];
                if ($idUpdate == '0'){
                    $query = "INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ('$isiDataAjax[id_lokasi_detail]','$lokasiManuverBebas')";
                } else {
                    $query = "UPDATE db_ajax_table_pengawas SET lokasi = '$lokasiManuverBebas' WHERE id=$idUpdate"; //id_form = '$idTask',
                }
                $event1 = mysqli_query($conn,$query);
    
            }
    
            if(isset($post["id_hapus_petugas"])){
                $jumlah_hapus = count($post["id_hapus_petugas"]);
                for ($i=0; $i<$jumlah_hapus; $i++){
                    $id_hapus = $post["id_hapus_petugas"][$i];
                    $query = "DELETE FROM db_ajax_table_pengawas WHERE id=$id_hapus";
                    
                }
                mysqli_query($conn,$query);
            }

            $jumlah_baris2 = count($post["lokasiManuverBebas"]);
            for ($i=0; $i<$jumlah_baris2; $i++){
                $lokasi = $post["lokasiManuverBebas"][$i];
                $installasi = $post["installManuverBebas"][$i];
                $idUpdate = $post["id_update_petugas"][$i];
                if ($idUpdate == "0"){
                    $query = "INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($idDetailLokasi,'$lokasi','$installasi','pembebasan')";
                } else{
                    $query = "UPDATE db_ajax_table_tahapan SET id_lokasi_detail=$idDetailLokasi, lokasi='$lokasi', installasi='$installasi' WHERE id=$idUpdate";
                }
                mysqli_query($conn,$query);
            }
        
            if(isset($post["id_hapus_bebas"])){
                $jumlah_hapus = count($post["id_hapus_bebas"]);
                for ($i=0; $i<$jumlah_hapus; $i++){
                    $id_hapus = $post["id_hapus_bebas"][$i];
                    $query = "DELETE FROM db_ajax_table_tahapan WHERE id=$id_hapus";
                    
                }
                mysqli_query($conn,$query);
            }

            $jumlah_baris3 = count($post["lokasiManuverNormal"]);
            for ($i=0; $i<$jumlah_baris3; $i++){
                $lokasi = $post["lokasiManuverNormal"][$i];
                $installasi = $post["installManuverNormal"][$i];
                $idUpdate = $post["id_normal_update"][$i];
                if ($idUpdate == "0"){
                    $query = "INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($idDetailLokasi,'$lokasi','$installasi','penormalan')";
                } else{
                    $query = "UPDATE db_ajax_table_tahapan SET id_lokasi_detail=$idDetailLokasi, lokasi='$lokasi', installasi='$installasi' WHERE id=$idUpdate";
                }
                mysqli_query($conn,$query);
            }
        
            if(isset($post["id_hapus_normal"])){
                $jumlah_hapus = count($post["id_hapus_normal"]);
                for ($i=0; $i<$jumlah_hapus; $i++){
                    $id_hapus = $post["id_hapus_normal"][$i];
                    $query = "DELETE FROM db_ajax_table_tahapan WHERE id=$id_hapus";
                    
                }
                mysqli_query($conn,$query);
                return mysqli_affected_rows($conn);
            }

        } else {
            mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
            mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama) VALUES ($ambilIdLokasi[id_lokasi]+1,'$instal')");

            if (isset($post["lokasiPembebasan"])){
                $jumlah_baris = count($_POST["lokasiPembebasan"]);
                for ($i=0; $i<$jumlah_baris; $i++) {
                    $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
                    mysqli_query($conn,"INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas')");
                }
            } else {
                echo "<script>
                        alert ('Anda belum memasukkan lokasi GITET');
                        history.back(-1);
                     </script>";
            }

            
            if (isset($post["lokasiManuverBebas"])){
                $rows_tabel_3 = count($_POST["lokasiManuverBebas"]);
                for ($i=0; $i<$rows_tabel_3; $i++) {
                    $lokasiManuverBebas = $_POST["lokasiManuverBebas"][$i];
                    $installManuverBebas = $_POST["installManuverBebas"][$i];
                    mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas','$installManuverBebas','pembebasan')");
                }
            } else {
                echo "<script>
                        alert ('Anda belum memasukkan lokasi GITET');
                        history.back(-1);
                    </script>";
            }

            
            if (isset($post["lokasiManuverNormal"])){
                $rows_tabel_4 = count($_POST["lokasiManuverNormal"]);
                for ($i=0; $i<$rows_tabel_4; $i++) {
                    $lokasiManuverNormal = $_POST["lokasiManuverNormal"][$i];
                    $installManuverNormal = $_POST["installManuverNormal"][$i];
                    mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverNormal','$installManuverNormal','penormalan')");
                }
            } else {
                echo "<script>
                        alert ('Anda belum memasukkan lokasi GITET');
                        history.back(-1);
                    </script>";
            }
        }
    }

    // hide
        // $query2 = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE id_jenis = $jenis AND nama='$lokasi'");
        // $data2 = mysqli_fetch_assoc($query2); // bisa ambil id_lokasi

        // $query3 = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi = $data2[id_lokasi] AND nama='$instal' ");
        // $data3 = mysqli_fetch_assoc($query3); // bisa diambil id_lokasi_detail

        // $idLokasi = mysqli_query($conn,"SELECT id_lokasi FROM db_ajax_lokasi ORDER BY id_lokasi DESC LIMIT 1");
        // $ambilIdLokasi = mysqli_fetch_assoc($idLokasi);

        // $idLokasiDetail = mysqli_query($conn,"SELECT id_lokasi_detail FROM db_ajax_lokasi_detail ORDER BY id_lokasi_detail DESC LIMIT 1");
        // $ambilIdLokasiDetail = mysqli_fetch_assoc($idLokasiDetail);

        // $list1 = mysqli_num_rows($query2);
        // $list2 = mysqli_num_rows($query3);

        // if ($pilihanDB == 1) {


        //     if ($list1 > 0 && $list2 > 0){


                // if (isset($post["lokasiPembebasan"])){
                //     $jumlah_baris = count($_POST["lokasiPembebasan"]);
                //     for ($i=0; $i<$jumlah_baris; $i++){
                //         $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
                //         $idUpdate = $_POST["id_bebas_update"][$i];
                //         if ($idUpdate == '0'){
                //             $query = "INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ('$data3[id_lokasi_detail]','$lokasiManuverBebas')";
                //         } else {
                //             $query = "UPDATE db_ajax_table_pengawas SET lokasi = '$lokasiManuverBebas' WHERE id=$idUpdate";
                //         }
                //         mysqli_query($conn,$query);
                //     }
                // }

                // if (isset($_POST["id_hapus_petugas"])){
                //     $jumlah_hapus = count($_POST["id_hapus_petugas"]);
                //     for ($i=0; $i<$jumlah_hapus; $i++) {
                //         $id_hapus = $_POST["id_hapus_petugas"][$i];
                //         $query = "DELETE FROM db_ajax_table_pengawas WHERE id='$id_hapus'";
                //         mysqli_query($conn,$query);
                //     }
                // }

                // $jumlah_baris_bebas = count($_POST["lokasiManuverBebas"]);
                // for($i=0; $i<$jumlah_baris_bebas; $i++){
                //     $lokasiPembebasanManuver = $_POST["lokasiManuverBebas"][$i];
                //     $intallasiPembebasan = $_POST["installManuverBebas"][$i];
                //     $idUpdateBebas = $_POST["id_update_bebas"][$i];
                //     if ($idUpdateBebas == '0') {
                //         $query = "INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ('$data3[id_lokasi_detail]','$lokasiPembebasanManuver','$intallasiPembebasan','pembebasan')";
                //     } else {
                //         $query = "UPDATE db_ajax_table_tahapan SET lokasi = '$lokasiPembebasanManuver', installasi = '$intallasiPembebasan' WHERE id = $idUpdateBebas ";
                //     }
                //     mysqli_query($conn,$query);
                // }
            
                // if (isset($_POST["id_hapus_bebas"])){
                //     $jumlah_hapus = count($_POST["id_hapus_bebas"]);
                //     for ($i=0; $i<$jumlah_hapus; $i++) {
                //         $id_hapus = $_POST["id_hapus_bebas"][$i];
                //         $query = "DELETE FROM db_ajax_table_tahapan WHERE id='$id_hapus'";
                //         mysqli_query($conn,$query);
                //     }
                // }

                // $jumlah_baris_normal = count($_POST["lokasiManuverNormal"]);
                // for($i=0; $i<$jumlah_baris_normal; $i++){
                //     $lokasiPenormalanManuver = $_POST["lokasiManuverNormal"][$i];
                //     $installasiPenormalan = $_POST["installManuverNormal"][$i];
                //     $idUpdateNormal = $_POST["id_update_normal"][$i];
                //     if ($idUpdateNormal == '0') {
                //         $query = "INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUE ('$data3[id_lokasi_detail]','$lokasiPenormalanManuver','$installasiPenormalan','penormalan')";
                //     } else {
                //         $query = "UPDATE db_ajax_table_tahapan SET lokasi = '$lokasiPenormalanManuver', installasi = '$installasiPenormalan' WHERE id = $idUpdateNormal ";
                //     }
                //     mysqli_query($conn,$query);
                // }
            
                // if (isset($_POST["id_hapus_normal"])){
                //     $jumlah_hapus = count($_POST["id_hapus_normal"]);
                //     for ($i=0; $i<$jumlah_hapus; $i++) {
                //         $id_hapus = $_POST["id_hapus_normal"][$i];
                //         $query = "DELETE FROM db_ajax_table_tahapan WHERE id='$id_hapus'";
                //         mysqli_query($conn,$query);
                //     }
                // }

        //             mysqli_query($conn,"DELETE FROM db_ajax_lokasi WHERE id_lokasi = $data2[id_lokasi]");
        //             mysqli_query($conn,"DELETE FROM db_ajax_lokasi_detail WHERE id_lokasi_detail = $data3[id_lokasi_detail]");
        //             mysqli_query($conn,"DELETE FROM db_ajax_table_pengawas WHERE id_lokasi_detail = $data3[id_lokasi_detail]");
        //             mysqli_query($conn,"DELETE FROM db_ajax_table_tahapan WHERE id_lokasi_detail = $data3[id_lokasi_detail]");

        //             mysqli_query($conn,"INSERT db_ajax_lokasi (id_jenis, nama) VALUES ($jenis, '$lokasi')");
        //             mysqli_query($conn,"INSERT db_ajax_lokasi_detail (id_lokasi, nama) VALUES ($ambilIdLokasi[id_lokasi]+1,'$instal')");
                    

        //             if (isset($post["lokasiPembebasan"])){
        //                 $jumlah_baris = count($_POST["lokasiPembebasan"]);
        //                 for ($i=0; $i<$jumlah_baris; $i++) {
        //                     $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
        //                     mysqli_query($conn,"INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas')");
        //                 }
        //             } else {
        //                 echo "<script>
        //                         alert ('Anda belum memasukkan lokasi GITET');
        //                         history.back(-1);
        //                      </script>";
        //             }

        //             if (isset($post["lokasiManuverBebas"])){
        //                 $rows_tabel_3 = count($_POST["lokasiManuverBebas"]);
        //                 for ($i=0; $i<$rows_tabel_3; $i++) {
        //                     $lokasiManuverBebas = $_POST["lokasiManuverBebas"][$i];
        //                     $installManuverBebas = $_POST["installManuverBebas"][$i];
        //                     mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas','$installManuverBebas','pembebasan')");
        //                 }
        //             } else {
        //                 echo "<script>
        //                         alert ('Anda belum memasukkan lokasi GITET');
        //                         history.back(-1);
        //                     </script>";
        //             }

        //             if (isset($post["lokasiManuverNormal"])){
        //                 $rows_tabel_4 = count($_POST["lokasiManuverNormal"]);
        //                 for ($i=0; $i<$rows_tabel_4; $i++) {
        //                     $lokasiManuverNormal = $_POST["lokasiManuverNormal"][$i];
        //                     $installManuverNormal = $_POST["installManuverNormal"][$i];
        //                     mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverNormal','$installManuverNormal','penormalan')");
        //                 }
        //             } else {
        //                 echo "<script>
        //                         alert ('Anda belum memasukkan lokasi GITET');
        //                         history.back(-1);
        //                     </script>";
        //             }

        //     } else {

        //         mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
        //         mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama) VALUES ($ambilIdLokasi[id_lokasi]+1,'$instal')");

        //         if (isset($post["lokasiPembebasan"])){
        //             $jumlah_baris = count($_POST["lokasiPembebasan"]);
        //             for ($i=0; $i<$jumlah_baris; $i++) {
        //                 $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
        //                 mysqli_query($conn,"INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas')");
        //             }
        //         } else {
        //             echo "<script>
        //                     alert ('Anda belum memasukkan lokasi GITET');
        //                     history.back(-1);
        //                  </script>";
        //         }

                
        //         if (isset($post["lokasiManuverBebas"])){
        //             $rows_tabel_3 = count($_POST["lokasiManuverBebas"]);
        //             for ($i=0; $i<$rows_tabel_3; $i++) {
        //                 $lokasiManuverBebas = $_POST["lokasiManuverBebas"][$i];
        //                 $installManuverBebas = $_POST["installManuverBebas"][$i];
        //                 mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverBebas','$installManuverBebas','pembebasan')");
        //             }
        //         } else {
        //             echo "<script>
        //                     alert ('Anda belum memasukkan lokasi GITET');
        //                     history.back(-1);
        //                 </script>";
        //         }

                
        //         if (isset($post["lokasiManuverNormal"])){
        //             $rows_tabel_4 = count($_POST["lokasiManuverNormal"]);
        //             for ($i=0; $i<$rows_tabel_4; $i++) {
        //                 $lokasiManuverNormal = $_POST["lokasiManuverNormal"][$i];
        //                 $installManuverNormal = $_POST["installManuverNormal"][$i];
        //                 mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($ambilIdLokasiDetail[id_lokasi_detail]+1,'$lokasiManuverNormal','$installManuverNormal','penormalan')");
        //             }
        //         } else {
        //             echo "<script>
        //                     alert ('Anda belum memasukkan lokasi GITET');
        //                     history.back(-1);
        //                 </script>";
        //         }
        //     }
        

        // } 


    return mysqli_affected_rows($conn);
    
}

function upload($post){
    $namaFile = $_FILES[$post]["name"];
    $ukuranFile = $_FILES[$post]["size"];
    $error = $_FILES[$post]["error"];
    $tmpNama = $_FILES[$post]["tmp_name"];

    //cek apakah tidak ada gambar yg diupload
    if( $error === 4) {     //angka 4 indikasi error tidak ada gambar yg diupload baku
        echo "<script>
                alert ('Anda belum upload gambar!');
                </>";
        return false;
    }
    //cek yang diupload gambar atau bukan
    $ekstensiGambarValid = ['jpg','jpeg','png']; //menentukan format
    $ekstensiGambar = explode('.',$namaFile); //explode untuk delimiter nama file menjadi array contoh shofwan.jpg menjadi ['shofwan'.'jpg']
    $ekstensiGambar = strtolower(end($ekstensiGambar)); // end untuk mengambil array paling belakang dimana paling belakang jpg/png/jpeg strtolower untuk mengecilkan huruf jika format kapital
    if( !in_array($ekstensiGambar,$ekstensiGambarValid)){
        echo "<script>
                alert ('Anda tidak mengupload gambar format jpg, jpeg dan png!');
                </script>";
        return false;

    } 

    //cek ukuran gambar
    if( $ukuranFile > 1000000){
        echo "<script>
                alert ('Anda mengupload gambar ukuran diatas 1MW');
                </script>";
        return false;
    }

    //lolos upload
    //generate nama gambar agar tidak ada yg sama
    $namaFileBaru = uniqid();                               //membuat nama file random
    $namaFileBaru .= '.';                                   //menggabungkan nama file baru dengan ekstensu eksisting
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpNama, 'img/' . $namaFileBaru);
    return  $namaFileBaru;

}

function tambahFormAuto($post){
    global $conn;
    $idTask =$post["idTask"];//ok
    $user = $post["user"]; ;//ok
    $create_date = $post["create_date"];//ok
    $pekerjaan = htmlspecialchars($post["pekerjaan"]);//ok
    $date = $post["date"];
    $start = $post["start"];
    $end = $post["end"];
    $lokasi = htmlspecialchars($post["lokasi"]);
    $instal = htmlspecialchars($post["instal"]);
    $catatanPraBebas = htmlspecialchars($post["catatan_pra_bebas"]);
    $catatanPraNormal =htmlspecialchars($post["catatan_pra_normal"]);

    if (isset($post["lokasiPembebasan"])){
        $jumlah_baris = count($_POST["lokasiPembebasan"]);
        for ($i=0; $i<$jumlah_baris; $i++) {
            $lokasiManuverBebas = $_POST["lokasiPembebasan"][$i];
            $query = "INSERT INTO db_table_pengawas (id_form,lokasi) VALUES ($idTask,'$lokasiManuverBebas')";
            mysqli_query($conn,$query);
        }
    } else {
        echo "<script>
                alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
    }

    $foto = upload(); 
    if( !$foto ){
        return false;
    }

    if (isset($post["lokasiManuverBebas"])){
        $rows_tabel_3 = count($_POST["lokasiManuverBebas"]);
        for ($i=0; $i<$rows_tabel_3; $i++) {
            $lokasiManuverBebas = $_POST["lokasiManuverBebas"][$i];
            $installManuverBebas = $_POST["installManuverBebas"][$i];
            $query = "INSERT INTO db_table_tahapan (id_form,lokasi,installasi,tahapan) VALUES ($idTask,'$lokasiManuverBebas','$installManuverBebas','pembebasan')";
            mysqli_query($conn,$query);
        }
    } else {
        echo "<script>
                alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
    }

    $foto2 = upload2(); 
    if( !$foto2 ){
        return false;
    }

    if (isset($post["lokasiManuverNormal"])){
        $rows_tabel_4 = count($_POST["lokasiManuverNormal"]);
        for ($i=0; $i<$rows_tabel_4; $i++) {
            $lokasiManuverNormal = $_POST["lokasiManuverNormal"][$i];
            $installManuverNormal = $_POST["installManuverNormal"][$i];
            $query = "INSERT INTO db_table_tahapan (id_form,lokasi,installasi,tahapan) VALUES ($idTask,'$lokasiManuverNormal','$installManuverNormal','penormalan')";
            mysqli_query($conn,$query);
        }
    } else {
        echo "<script>
                alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
    }

    $query = "INSERT INTO db_form (id,create_date,user,pekerjaan,date,start,end,lokasi,installasi,foto,foto2,catatan_pra_pembebasan,catatan_pra_penormalan,status) VALUES ($idTask,'$create_date','$user','$pekerjaan','$date','$start','$end','$lokasi','$instal','$foto','$foto2','$catatanPraBebas','$catatanPraNormal','amn')";
    mysqli_query($conn,$query);
    
    return mysqli_affected_rows($conn);

}


function aprovalAmn($post){
    global $conn;
    $idTask =$post["idTask"];
    $userAmn = $post["userAmn"];
    $level = $post["level"];
    //$potongLevel = substr($level,4);
    $time =$post["time"];
    //$statusAE = $post["statusAE"];
    $catatan = $post["catatan_amn"];
    $aproval = $post["aproval"];
    $userMsb = $post["userMSB"];

    // if (strlen($level) == 3) {
    //     mysqli_query($conn,"UPDATE db_form SET level_amn = '$level' WHERE id = $idTask");
    // } else {
    //     mysqli_query($conn,"UPDATE db_form SET level_amn = '$potongLevel' WHERE id = $idTask");
    // }

    // if ($statusAE == 'approve' && $aproval == 'approve' && $userMsb == '') {
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'aproveAMN' WHERE id = $idTask");
    // } elseif ($statusAE == 'approve' && $aproval == 'disapprove' && $userMsb == ''){
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'back' WHERE id = $idTask");
    // } elseif ($statusAE == 'aproveUbah' && $aproval == 'approve' && $userMsb != ''){
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'aproveUbahAMN' WHERE id = $idTask");
    // } elseif ($statusAE == 'aproveUbah' && $aproval == 'disapprove' && $userMsb != ''){
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'back' WHERE id = $idTask");
    // } elseif ($statusAE == 'aproveUbah' && $aproval == 'approve' && $userMsb == ''){
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'aproveAMN' WHERE id = $idTask");
    // } elseif ($statusAE == 'aproveUbah' && $aproval == 'disapprove' && $userMsb == ''){
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'back' WHERE id = $idTask");
    // }

    if ($aproval == 'approve' && $userMsb == ''){
        mysqli_query($conn,"UPDATE db_form SET status = 'msb' WHERE id = $idTask");
    } elseif  ($aproval == 'disapprove' && $userMsb =='') {
        mysqli_query($conn,"UPDATE db_form SET status = 'initiator' WHERE id = $idTask");
    } elseif ($aproval == 'approve' && $userMsb !='') {
        mysqli_query($conn,"UPDATE db_form SET status = 'msbUbah' WHERE id = $idTask");
    } elseif  ($aproval == 'disapprove' && $userMsb !=''){
        mysqli_query($conn,"UPDATE db_form SET status = 'initiator' WHERE id = $idTask");
    }

    $query = "UPDATE db_form SET 
             user_amn = '$userAmn',
             level_amn = '$level',
             time_amn_aprove = '$time',
             catatan_amn = '$catatan'
             WHERE id = $idTask
             ";
    mysqli_query($conn,$query);

    

    return mysqli_affected_rows($conn);

}

function aprovalMsb($post){
    global $conn;
    $idTask =$post["idTask"];
    $userMsb = $post["userMSB"];
    $status = $post["status"];
    $aproval = $post["aproval"];
    $level = $post["level"];
    //$potongLevel = substr($level,4);
    $time = $post["time"];
    $catatan = $post["catatan_msb"];
    //$statusAE = $post["statusAE"];

    // if (strlen($level) == 3) {
    //     mysqli_query($conn,"UPDATE db_form SET level_msb = '$level' WHERE id = $idTask");
    // } else {
    //     mysqli_query($conn,"UPDATE db_form SET level_msb ='$potongLevel' WHERE id = $idTask");
    // }

    // if ($statusAE == 'aproveAMN' && $aproval == 'approve') {
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'aproved', status = 'pembebasan', dispa = 'pembebasan' WHERE id = $idTask");
    // } elseif ($statusAE == 'aproveAMN' && $aproval == 'disapprove'){
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'back' WHERE id = $idTask");
    // } elseif ($statusAE == 'aproveUbahAMN' && $aproval == 'approve'){
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'aproved', status = 'pembebasan', dispa = 'pembebasan' WHERE id = $idTask");
    // } elseif ($statusAE == 'aproveUbahAMN' && $aproval == 'disapprove'){
    //     mysqli_query($conn,"UPDATE db_form SET ae = 'back' WHERE id = $idTask");
    // }

    if ($aproval == 'approve' && $status == 'msb'){
        mysqli_query($conn,"UPDATE db_form SET status = 'dispaAwal' WHERE id = $idTask");
    } elseif ($aproval == 'disapprove' && $status == 'msb'){
        mysqli_query($conn,"UPDATE db_form SET status = 'initiator' WHERE id = $idTask");
    } elseif ($aproval == 'approve' && $status == 'msbUbah') {
        mysqli_query($conn,"UPDATE db_form SET status = 'dispaAwal' WHERE id = $idTask");
    } elseif ($aproval == 'disapprove' && $status == 'msb') {
        mysqli_query($conn,"UPDATE db_form SET status = 'initiator' WHERE id = $idTask");
    }

    // rencana ditambahkan dispa = pembebasan dan status = pembebasan
    $query = "UPDATE db_form SET 
             user_msb = '$userMsb',
             level_msb = '$level',
             time_msb_aprove = '$time',
             msb = '$aproval',
             catatan_msb = '$catatan'
             WHERE id = '$idTask'
             ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);

}

function inputDispaAwal($post) {
    global $conn;
    $idTask = $post["idTask"]; 

    $fotolama = $post["fotoLama"];
    $time = $post["dateAprove"];
    $report = $post["report_date"];
    $scada_awal_before = htmlspecialchars($post["scada_awal_before"]);
    $scada_awal_after = htmlspecialchars($post["scada_awal_after"]);
    $dpf_awal = htmlspecialchars($post["dpf_awal"]);
    $catatan = htmlspecialchars($post["catatan_pasca_bebas"]);
    $userDispa = $post["userdispa"];
    $status = $post["status"];




    $jumlah_baris_nama = count($post["peng_pekerjaan"]);
    for ($i=0; $i<$jumlah_baris_nama; $i++) {
        $nama_pekerja = $post["peng_pekerjaan"][$i];
        $nama_manuver = $post["peng_manuver"][$i];
        $nama_k3 = $post["peng_k3"][$i];
        $nama_spv = $post["spv"][$i];
        $nama_opr = $post["opr"][$i];
        $id_isi = $post["sampel"][$i];
        $query = "UPDATE db_table_pengawas SET
                 pengawas_pekerjaan = '$nama_pekerja',
                 pengawas_manuver = '$nama_manuver',
                 pengawas_k3 = '$nama_k3',
                 spv_gitet = '$nama_spv',
                 opr_gitet = '$nama_opr'
                 WHERE id = $id_isi
                 ";
                 mysqli_query($conn,$query);
    }

    if (isset($_POST["document"])){
        $document = implode(",", $post["document"]);
        mysqli_query($conn,"UPDATE db_form SET document = '$document' WHERE id=$idTask");
    }

    if( $_FILES['dpfFile_awal']['error'] === 4){
        $foto = $fotolama;
    } else {
        $foto = upload3();
    }
    
    $jumlah_manuver_bebas = count($_POST["remote_bebas"]);
    for ($i=0; $i<$jumlah_manuver_bebas; $i++) {
        $remote_bebas = $_POST["remote_bebas"][$i];
        $real_bebas = $_POST["real_bebas"][$i];
        $ads_bebas = $_POST["ads_bebas"][$i];
        $id_isi2 = $_POST["sampel_manuver"][$i];
        $query = "UPDATE db_table_tahapan SET 
                 remote_ = '$remote_bebas',
                 real_ = '$real_bebas',
                 ads = '$ads_bebas'
                 WHERE id = $id_isi2
                 ";
        mysqli_query($conn,$query);
    }

    if($status == 'dispaAwalUbah') {
        mysqli_query($conn,"UPDATE db_form SET status = 'amnDispaAwalUbah' WHERE id =$idTask");
    } else {
        mysqli_query($conn,"UPDATE db_form SET status ='amnDispaAwal' WHERE id=$idTask");
    }

    $query = "UPDATE db_form SET
              user_dispa_awal = '$userDispa',
              scada_awal_before = '$scada_awal_before',
              scada_awal_after = '$scada_awal_after',
              report_date = '$report',
              dpf_awal = '$dpf_awal',
              catatan_pasca_pembebasan = '$catatan',
              time_dispa_awal_aprove = '$time',
              foto_dpf1 = '$foto'
              WHERE id = $idTask
    ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

function upload3() {
    $namaFile = $_FILES["dpfFile_awal"]["name"];
    $ukuranFile = $_FILES["dpfFile_awal"]["size"];
    $error = $_FILES["dpfFile_awal"]["error"];
    $tmpNama = $_FILES["dpfFile_awal"]["tmp_name"];

    // cek apakah tidak ada gambar yg diupload
    // if ($error === 4) {
    //     echo "<script>
    //             alert ('Anda belum upload gambar!');
    //           </script>";
    //     return false;
    // }
    //cek yang diupload gambar atau bukan
    $ekstensiGambarValid = ['jpg','jpeg','png','jfif']; //menentukan format
    $ekstensiGambar = explode('.',$namaFile); //explode untuk delimiter nama file menjadi array contoh shofwan.jpg menjadi ['shofwan'.'jpg']
    $ekstensiGambar = strtolower(end($ekstensiGambar)); // end untuk mengambil array paling belakang dimana paling belakang jpg/png/jpeg strtolower untuk mengecilkan huruf jika format kapital
    if( !in_array($ekstensiGambar,$ekstensiGambarValid)){
        echo "<script>
                alert ('Anda tidak mengupload gambar format jpg, jpeg dan png!');
                </script>";
        return false;

    } 

    //cek ukuran gambar
    if( $ukuranFile > 1000000){
        echo "<script>
                alert ('Anda mengupload gambar ukuran diatas 1MW');
                </script>";
        return false;
    }

    //lolos upload
    //generate nama gambar agar tidak ada yg sama
    $namaFileBaru = uniqid();                               //membuat nama file random
    $namaFileBaru .= '.';                                   //menggabungkan nama file baru dengan ekstensu eksisting
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpNama, 'dpf/' . $namaFileBaru);
    return  $namaFileBaru;
}


function inputDispaAkhir($post) {
    global $conn;
    $idTask = $post["idTask"];
    $fotolama = $post["fotoLama"];
    $scada_akhir_before = htmlspecialchars($post["scada_akhir_before"]);
    $scada_akhir_after = htmlspecialchars($post["scada_akhir_after"]);
    $dpf_akhir = htmlspecialchars($post["dpf_akhir"]);
    $catatan = htmlspecialchars($post["catatan_pasca_normal"]);
    $userDispa = $post["userdispa"]; 
    $timeDispaAproveAkhir = $post["time"];
    $status = $post["status"];

    $jumlah_baris_nama = count($post["spv_gitet_normal"]);
    for ($i=0; $i<$jumlah_baris_nama; $i++){
        $nama_spv = $post["spv_gitet_normal"][$i];
        $nama_opr = $post["opr_gitet_normal"][$i];
        $id_isi = $post["sample"][$i];
        $query = "UPDATE db_table_pengawas SET
                 spv_gitet_normal = '$nama_spv',
                 opr_gitet_normal = '$nama_opr'
                 WHERE id = $id_isi
                 ";
                 mysqli_query($conn,$query);
    }

    if( $_FILES['dpfFile_akhir']['error'] === 4){
        $foto2 = $fotolama;
    } else {
        $foto2 = upload4();
    }

    $jumlah_manuver_normal = count($post["remote_normal"]);
    for ($i=0; $i<$jumlah_manuver_normal; $i++){
        $remote_normal = $post["remote_normal"][$i];
        $real_normal = $post["real_normal"][$i];
        $ads_normal = $post["ads_normal"][$i];
        $id_isi2 = $post["sampel_manuver"][$i];
        $query = "UPDATE db_table_tahapan SET
                 remote_ = '$remote_normal',
                 real_ = '$real_normal',
                 ads = '$ads_normal'
                 WHERE id = $id_isi2
                 ";
        mysqli_query($conn,$query);
    }

    if($status == 'dispaAkhirUbah') {
        mysqli_query($conn,"UPDATE db_form SET status = 'amnDispaAkhirUbah' WHERE id =$idTask");
    } else {
        mysqli_query($conn,"UPDATE db_form SET status ='amnDispaAkhir' WHERE id=$idTask");
    }

    $query = "UPDATE db_form SET
             user_dispa_akhir = '$userDispa',
             scada_akhir_before = '$scada_akhir_before',
             scada_akhir_after = '$scada_akhir_after',
             dpf_akhir = '$dpf_akhir',
             catatan_pasca_penormalan = '$catatan',
             time_dispa_akhir_aprove = '$timeDispaAproveAkhir',
             foto_dpf2 = '$foto2'
             WHERE id = '$idTask'
             ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

function upload4() {
    $namaFile = $_FILES["dpfFile_akhir"]["name"];
    $ukuranFile = $_FILES["dpfFile_akhir"]["size"];
    $error = $_FILES["dpfFile_akhir"]["error"];
    $tmpNama = $_FILES["dpfFile_akhir"]["tmp_name"];

    //cek apakah tidak ada gambar yg diupload
    // if ($error === 4) {
    //     echo "<script>
    //             alert ('Anda belum upload gambar!');
    //           </script>";
    //     return false;
    // }
    //cek yang diupload gambar atau bukan
    $ekstensiGambarValid = ['jpg','jpeg','png']; //menentukan format
    $ekstensiGambar = explode('.',$namaFile); //explode untuk delimiter nama file menjadi array contoh shofwan.jpg menjadi ['shofwan'.'jpg']
    $ekstensiGambar = strtolower(end($ekstensiGambar)); // end untuk mengambil array paling belakang dimana paling belakang jpg/png/jpeg strtolower untuk mengecilkan huruf jika format kapital
    if( !in_array($ekstensiGambar,$ekstensiGambarValid)){
        echo "<script>
                alert ('Anda tidak mengupload gambar format jpg, jpeg dan png!');
                </script>";
        return false;

    } 

    //cek ukuran gambar
    if( $ukuranFile > 1000000){
        echo "<script>
                alert ('Anda mengupload gambar ukuran diatas 1MW');
                </script>";
        return false;
    }

    //lolos upload
    //generate nama gambar agar tidak ada yg sama
    $namaFileBaru = uniqid();                               //membuat nama file random
    $namaFileBaru .= '.';                                   //menggabungkan nama file baru dengan ekstensu eksisting
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpNama, 'dpf/' . $namaFileBaru);
    return  $namaFileBaru;
}

function amnDispaAproveAwal($post) {
    global $conn;
    $idTask = $post["idTask"];
    $userAmnDispa = $post["userAmnDispa"];
    $aproval = $post["aproval"];
    $timaAprovalAmnDispaAwal = $post["time"];
    $catatan = $post["catatan_amndis_awal"];

    if ($aproval == 'approve') {
        mysqli_query($conn,"UPDATE db_form SET status = 'dispaAkhir'  WHERE id='$idTask'");
    } elseif ($aproval == 'disapprove'){
        mysqli_query($conn,"UPDATE db_form SET status = 'dispaAwalUbah'  WHERE id='$idTask'");
    }

    $query = "UPDATE db_form SET
              user_amn_dispa_awal = '$userAmnDispa',
              amn_dispa_awal = '$aproval',
              time_amnDispa_awal_aprove = '$timaAprovalAmnDispaAwal',
              catatan_amnDispa_awal = '$catatan'
              WHERE id = '$idTask'
             ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);

}

function amnDispaAproveAkhir($post) {
    global $conn;
    $idTask = $post["idTask"];
    $userAmnDispa = $post["userAmnDispa"];
    $aproval = $post["aproval"];
    $timeAprovalAmnDispaAkhir = $post["time"];
    $catatan =$post["catatan_amndis_akhir"];
    $level = $post["level"];

    $query = "UPDATE db_form SET
              user_amn_dispa_akhir = '$userAmnDispa',
              amn_dispa_akhir = '$aproval',
              time_amnDispa_akhir_aprove = '$timeAprovalAmnDispaAkhir',
              catatan_amnDispa_akhir = '$catatan',
              level_amn_dispa_akhir = '$level',
              dispa = 'done'
              WHERE id = '$idTask'
             ";
    mysqli_query($conn,$query);

    if ($aproval == 'approve') {
        mysqli_query($conn,"UPDATE db_form SET status = 'done' WHERE id=$idTask");
    } elseif ($aproval == 'disapprove'){
        mysqli_query($conn,"UPDATE db_form SET status = 'dispaAkhirUbah'  WHERE id=$idTask");
    }

    return mysqli_affected_rows($conn);

}

function tambahDB($post) {
    global $conn;
    $form = $post["form"];
    $jenis = $post["jenis"];
    $lokasi = strtolower(str_replace(" ","",htmlspecialchars($post["lokasi"])));
    $detail = strtolower(str_replace(" ","",htmlspecialchars($post["detailLokasi"])));

    $cek_lokasi = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE nama='$lokasi'");
    $ambil_cek_lokasi = mysqli_fetch_assoc($cek_lokasi);
    
    error_reporting(0);
    $cek_detail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE nama='$detail' AND id_lokasi='$ambil_cek_lokasi[id_lokasi]'");
    $jumlah_detail = mysqli_num_rows($cek_detail);
    if($cek_detail->num_rows >0){
        echo "
        <script>
        alert ('data sudah ada dalam database');
        history.back(-1);
        </script>
        ";
        die;
    }
    // var_dump($jumlah_detail);  die;

    $query = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE id_jenis='$jenis' AND nama='$lokasi'");
    $data = mysqli_fetch_assoc($query);
    
    $idNext = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi ORDER BY id_lokasi DESC LIMIT 1");
    $isiIdNext = mysqli_fetch_assoc($idNext);
    
    $idNext2 = mysqli_query($conn, "SELECT * FROM db_ajax_lokasi_detail ORDER BY id_lokasi_detail DESC LIMIT 1");
    $isiIdNext2 = mysqli_fetch_assoc($idNext2);

    

    if ($query->num_rows > 0){
        mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama) VALUES ($data[id_lokasi],'$detail')");
    } else {
        mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
        mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama) VALUES ($isiIdNext[id_lokasi]+1,'$detail')");
    }
    

    $baris_table1 = count($_POST["lokasiGitet"]); 
    
    for($i=0; $i<$baris_table1; $i++){
        $lokasiGitet = $_POST["lokasiGitet"][$i];
        //var_dump($lokasiGitet); die;
        mysqli_query($conn,"INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ($isiIdNext2[id_lokasi_detail]+1,'$lokasiGitet')");
    }

    $baris_table2 = count($post["lokasiOpen"]);
    for($i=0; $i<$baris_table2; $i++) {
        $lokasiOpen = $_POST["lokasiOpen"][$i];
        $installasiOpen = $_POST["installasiOpen"][$i];
        mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($isiIdNext2[id_lokasi_detail]+1,'$lokasiOpen','$installasiOpen','pembebasan')");
    }

    $baris_table3 = count($post["lokasiClose"]);
    for($i=0; $i<$baris_table3; $i++) {
        $lokasiClose = $_POST["lokasiClose"][$i];
        $installasiClose = $_POST["installasiClose"][$i];
        mysqli_query($conn,"INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($isiIdNext2[id_lokasi_detail]+1,'$lokasiClose' ,'$installasiClose','penormalan')");
    }

    return mysqli_affected_rows($conn);

}

function ubahDB($post) {
    global $conn;
    $idLokasi = $post["idy"];
    $idDetailLokasi = $post["idz"];

    $namaLokasi = $post["nama_lokasi"];
    $namaLokasiDetail = $post["nama_lokasi_detail"];
       
    $jumlah_baris1 = count($post["lokasi1"]);
    for ($i=0; $i<$jumlah_baris1; $i++) {
        $lokasi = $post["lokasi1"][$i];
        $idUpdate = $post["id1"][$i];
        if ($idUpdate == "0"){
            $query = "INSERT INTO db_ajax_table_pengawas (id_lokasi_detail,lokasi) VALUES ($idDetailLokasi,'$lokasi')";
        } else {
            $query = "UPDATE db_ajax_table_pengawas SET id_lokasi_detail = $idDetailLokasi, lokasi = '$lokasi' WHERE id=$idUpdate";
        }
        mysqli_query($conn,$query);
    }

    if(isset($post["id1_hapus"])){
        $jumlah_hapus = count($post["id1_hapus"]);
        for ($i=0; $i<$jumlah_hapus; $i++){
            $id_hapus = $post["id1_hapus"][$i];
            $query = "DELETE FROM db_ajax_table_pengawas WHERE id=$id_hapus";
            
        }
        mysqli_query($conn,$query);
    }

    $jumlah_baris2 = count($post["lokasi2"]);
    for ($i=0; $i<$jumlah_baris2; $i++){
        $lokasi = $post["lokasi2"][$i];
        $installasi = $post["installasi2"][$i];
        $idUpdate = $post["id2"][$i];
        if ($idUpdate == "0"){
            $query = "INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($idDetailLokasi,'$lokasi','$installasi','pembebasan')";
        } else{
            $query = "UPDATE db_ajax_table_tahapan SET id_lokasi_detail=$idDetailLokasi, lokasi='$lokasi', installasi='$installasi' WHERE id=$idUpdate";
        }
        mysqli_query($conn,$query);
    }

    if(isset($post["id2_hapus"])){
        $jumlah_hapus = count($post["id2_hapus"]);
        for ($i=0; $i<$jumlah_hapus; $i++){
            $id_hapus = $post["id2_hapus"][$i];
            $query = "DELETE FROM db_ajax_table_tahapan WHERE id=$id_hapus";
            
        }
        mysqli_query($conn,$query);
    }

    $jumlah_baris3 = count($post["lokasi3"]);
    for ($i=0; $i<$jumlah_baris3; $i++){
        $lokasi = $post["lokasi3"][$i];
        $installasi = $post["installasi3"][$i];
        $idUpdate = $post["id3"][$i];
        if ($idUpdate == "0"){
            $query = "INSERT INTO db_ajax_table_tahapan (id_lokasi_detail,lokasi,installasi,tahapan) VALUES ($idDetailLokasi,'$lokasi','$installasi','penormalan')";
        } else{
            $query = "UPDATE db_ajax_table_tahapan SET id_lokasi_detail=$idDetailLokasi, lokasi='$lokasi', installasi='$installasi' WHERE id=$idUpdate";
        }
        mysqli_query($conn,$query);
    }

    if(isset($post["id3_hapus"])){
        $jumlah_hapus = count($post["id3_hapus"]);
        for ($i=0; $i<$jumlah_hapus; $i++){
            $id_hapus = $post["id3_hapus"][$i];
            $query = "DELETE FROM db_ajax_table_tahapan WHERE id=$id_hapus";
            
        }
        mysqli_query($conn,$query);
        return mysqli_affected_rows($conn);
    }

    mysqli_query($conn,"UPDATE db_ajax_lokasi SET nama = '$namaLokasi' WHERE id_lokasi = $idLokasi");
    return mysqli_affected_rows($conn);

    mysqli_query($conn,"UPDATE db_ajax_lokasi_detail SET nama = '$namaLokasiDetail' WHERE id_lokasi_detail = $idDetailLokasi");
    return mysqli_affected_rows($conn);
}

function hapusDB($id) {
    global $conn;

    mysqli_query($conn,"DELETE FROM db_ajax_lokasi_detail WHERE id_lokasi_detail = $id");
    mysqli_query($conn,"DELETE FROM  db_ajax_table_pengawas WHERE id_lokasi_detail = $id");
    mysqli_query($conn,"DELETE FROM  db_ajax_table_tahapan WHERE id_lokasi_detail = $id");
    return mysqli_affected_rows($conn);
}

function tambahUser($post) {
    global $conn;
    $nama = $post["nama"];
    $level = $post["level"];
    $pass = password_hash('12345', PASSWORD_DEFAULT);

    if (isset ($nama)) {
        $query = mysqli_query($conn, "SELECT username FROM db_user WHERE username='$nama' ");
        if ($query->num_rows > 0) {
            echo "<script>alert('username already exist');</script>";
        } else {
            mysqli_query($conn,"INSERT INTO db_user (level,password,username) VALUES ('$level','$pass','$nama')");
        }
    }

    

    return mysqli_affected_rows($conn);

}

function ubahUser($post) {
    global $conn;
    $nama = $post["nama"];
    $level = $post["level"];
    $id = $_GET["id"];

    mysqli_query($conn,"UPDATE db_user SET username='$nama',level='$level' WHERE id='$id'");

    return mysqli_affected_rows($conn);

}

function hapusUser($id){ 
    global $conn;
    mysqli_query($conn,"DELETE FROM db_user WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function hapus($id) {
    global $conn;
    mysqli_query($conn,"DELETE FROM db_form WHERE id = $id");
    mysqli_query($conn,"DELETE FROM db_table_1 WHERE id_form = $id");
    mysqli_query($conn,"DELETE FROM db_table_2 WHERE id_form = $id");
    mysqli_query($conn,"DELETE FROM db_table_3 WHERE id_form = $id");
    return mysqli_affected_rows($conn);
}


function rubahPass($post){
    global $conn;
    $nama = $_SESSION["username"];
    $id = $_SESSION["id"];
    $o_pass = $post["curPass"];
    $n_pass = mysqli_real_escape_string($conn, $post["newPass"]);
    $c_pass = mysqli_real_escape_string($conn, $post["conPass"]);
    
    if( $n_pass !== $c_pass) {
        echo "<script>alert('new password dan confirm pass tidak sama');</script>";
        return false;
    }

    $query = mysqli_query($conn,"SELECT * FROM db_user WHERE id = '$id'");
    $num = mysqli_fetch_array($query);
    $verify = password_verify($o_pass,$num["password"]);
    $n_pass = password_hash($n_pass, PASSWORD_DEFAULT);
    if ($verify){
        mysqli_query($conn,"UPDATE db_user SET password = '$n_pass' WHERE id = '$id'");
        
    } else {
        echo "<script>alert('password lama salah');</script>";
        return false;
    }


    // if( $o_pass !== $num["password"] ){
    //     echo "<script>alert('Password lama belum sesuai');</script>";

    // }

    
    // die();

    // if ($num > 0) {
    //     mysqli_query($conn,"UPDATE db_user SET password = '$n_pass' WHERE id = '$id'");
    // } 
    return mysqli_affected_rows($conn);


}

function coba($isi) {
    
}




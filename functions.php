<?php
$conn=mysqli_connect("localhost","root","","db_lm");
date_default_timezone_set('Asia/Jakarta');

$jumlahDataPerHalaman = 10;

$dataArray = [0,0,0,1,2,3,4];


$dataArray = array_values($dataArray);
$newDataArray = array_unique($dataArray);
print_r($newDataArray);

$dataValidasi1 = end($dataArray);
$dataValidasi2 = count($dataArray)-1;

echo $newDataArray[4]."<br>";
echo $dataValidasi1."<br>";
echo $dataValidasi2;


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

// data hari indonesia
$dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
);


function query($query){
    global $conn;
    $result = mysqli_query($conn,$query); //kotaknya
    $rows = []; //siapkan wadah kosong
    while($row = mysqli_fetch_assoc($result)){
        $rows [] = $row;
    }
    return $rows; //mengembalikan kotaknya yg dipilih
}

function insertForm1($post){
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


    if (isset($post["lokasiPembebasan"])){
        $pengawas = serialize([
            [
                "lokasiPembebasan" => $post["lokasiPembebasan"]
            ]
        ]);
    } else {
        echo "<script>
        alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
        return false;
    }


    $catatanPraBebas = htmlspecialchars($post["catatan_pra_bebas"]);

    $foto = upload("foto"); 
    if( !$foto ){
        return false;
    }

    if (isset($post["lokasiManuverBebas"])){
        $manuverBebas = serialize([
            [
                "lokasiManuverBebas" => $post["lokasiManuverBebas"],
                "installManuverBebas" => $post["installManuverBebas"] 
            ]
        ]);
    } else {
        echo "<script>
                alert ('Anda belum memasukkan lokasi Manuver Pembebasan');
                history.back(-1);
             </script>";
        return false;
    }

    $catatanPraNormal =htmlspecialchars($post["catatan_pra_normal"]);

    $foto2 = upload("foto2"); 
    if( !$foto2 ){
        return false;
    }

    if (isset($post["lokasiManuverNormal"])){
        $manuverNormal = serialize([
            [
                "lokasiManuverNormal" => $post["lokasiManuverNormal"],
                "installManuverNormal" => $post["installManuverNormal"]
            ]
        ]);
    } else {
        echo "<script>
        alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
        return false;
    }

  

    $joinLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis=$jenis AND db_ajax_lokasi.nama='$lokasi' AND db_ajax_lokasi_detail.nama='$instal'");
    $isiJoin = mysqli_fetch_assoc($joinLokasiDetail);
    
    $cekLokasi = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE id_jenis = $jenis AND nama = '$lokasi'");
    $isiLokasi = mysqli_fetch_assoc($cekLokasi);

    $idLokasi = mysqli_query($conn,"SELECT id_lokasi FROM db_ajax_lokasi ORDER BY id_lokasi DESC LIMIT 1");
    $ambilIdLokasi = mysqli_fetch_assoc($idLokasi);

    $cekLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi = $isiLokasi[id_lokasi] AND nama='$instal'");
    $isiLokasiDetail = mysqli_fetch_assoc($cekLokasiDetail);

    $idLokasiDetail = mysqli_query($conn,"SELECT id_lokasi_detail FROM db_ajax_lokasi_detail ORDER BY id_lokasi_detail DESC LIMIT 1");
    $ambilIdLokasiDetail = mysqli_fetch_assoc($idLokasiDetail);



    if ($pilihanDB == 1) {
        if (mysqli_num_rows($joinLokasiDetail) == 0){
            if (mysqli_num_rows($cekLokasi) == 0) {
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($ambilIdLokasi[id_lokasi]+1,'$instal','$pengawas','$manuverBebas','$manuverNormal')");
                $id_lokasi_detail = $ambilIdLokasiDetail["id_lokasi_detail"]+1;
            } else {
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($isiLokasi[id_lokasi],'$instal','$pengawas','$manuverBebas','$manuverNormal')");
                $id_lokasi_detail = $ambilIdLokasiDetail["id_lokasi_detail"]+1;
            }
        } else {
            mysqli_query($conn,"UPDATE db_ajax_lokasi_detail SET pengawas = '$pengawas', manuver_bebas = '$manuverBebas', manuver_normal='$manuverNormal' WHERE id_lokasi_detail = $isiJoin[id_lokasi_detail]");
            $id_lokasi_detail = $isiJoin["id_lokasi_detail"];
        }
    } else {
        if ($_GET["idz"]){
            $id_lokasi_detail = $_GET["idz"];
        } else {
            $id_lokasi_detail = 0 ;
        }
    }

    if ($_GET['form']){
        $form = $_GET['form'];
    } else {
        $form = $post['form'];
    }

    $query = "INSERT INTO db_form (id,create_date,create_user,user,pekerjaan,`date`,`start`,`end`,lokasi,installasi,foto,foto2,catatan_pra_pembebasan,catatan_pra_penormalan,`status`,jenis_pekerjaan,chose_db,emergency_pengawas_bebas,emergency_bebas,emergency_normal,id_lokasi_detail,jenis_form)
                VALUE ($idTask,'$create_date','$user','$user','$pekerjaan','$date','$start','$end','$lokasi','$instal','$foto','$foto2','$catatanPraBebas','$catatanPraNormal','amn',$jenis,$pilihanDB,'$pengawas','$manuverBebas','$manuverNormal',$id_lokasi_detail,$form)
                ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}

function updateForm($post) {
    global $conn;
    //var_dump($post); die;
    $idTask =$post["idTask"];
    $fotolama1 = $post["fotoLama1"];
    $fotolama2 = $post["fotoLama2"];
    $pekerjaan = htmlspecialchars($post["pekerjaan"]);
    $date = $post["date"];
    $start = $post["start"];
    $end = $post["end"];
    $jenis = $post["jenis_pekerjaan"];
    $lokasi = strtolower(ltrim(rtrim(htmlspecialchars($post["lokasi"]))));
    $instal = strtolower(ltrim(rtrim(htmlspecialchars($post["instal"]))));
    $level = $post["level"];
    $potongLevel = substr($level,4);
    $pilihanDB = $post["chose_db"];
    $idLokasiDetail = $post["id_lokasi_detail"];

    if (strlen($level) == 9) {
        $level = $post["level"];
    } else {
        $level = $potongLevel;
    }

    if (isset($post["lokasiPembebasan"])){
        $pengawas = serialize([
            [
                "lokasiPembebasan" => $post["lokasiPembebasan"]
            ]
        ]);
    } else {
        echo "<script>
        alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
    }

    $catatanPraBebas = htmlspecialchars($post["catatan_pra_bebas"]);

    if( $_FILES['foto']['error'] === 4){
        $foto = $fotolama1;
    } else {
        $foto = upload("foto");
    }

    if (isset($post["lokasiManuverBebas"])){
        $manuverBebas = serialize([
            [
                "lokasiManuverBebas" => $post["lokasiManuverBebas"],
                "installManuverBebas" => $post["installManuverBebas"] 
            ]
        ]);
    } else {
        echo "<script>
                alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
    }

    $catatanPraNormal =htmlspecialchars($post["catatan_pra_normal"]);

    if( $_FILES['foto2']['error'] === 4){
        $foto2 = $fotolama2;
    } else {
        $foto2 = upload("foto2");
    }

    if (isset($post["lokasiManuverNormal"])){
        $manuverNormal = serialize([
            [
                "lokasiManuverNormal" => $post["lokasiManuverNormal"],
                "installManuverNormal" => $post["installManuverNormal"]
            ]
        ]);
    } else {
        echo "<script>
        alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
    }

    $joinLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis=$jenis AND db_ajax_lokasi.nama='$lokasi' AND db_ajax_lokasi_detail.nama='$instal'");
    $isiJoin = mysqli_fetch_assoc($joinLokasiDetail);
    
    $cekLokasi = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE id_jenis = $jenis AND nama = '$lokasi'");
    $isiLokasi = mysqli_fetch_assoc($cekLokasi);

    $idLokasi = mysqli_query($conn,"SELECT id_lokasi FROM db_ajax_lokasi ORDER BY id_lokasi DESC LIMIT 1");
    $ambilIdLokasi = mysqli_fetch_assoc($idLokasi);

    $cekLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi = $isiLokasi[id_lokasi] AND nama='$instal'");
    $isiLokasiDetail = mysqli_fetch_assoc($cekLokasiDetail);

    $idLokasiDetail = mysqli_query($conn,"SELECT id_lokasi_detail FROM db_ajax_lokasi_detail ORDER BY id_lokasi_detail DESC LIMIT 1");
    $ambilIdLokasiDetail = mysqli_fetch_assoc($idLokasiDetail);



    if ($pilihanDB == 1) {
        if (mysqli_num_rows($joinLokasiDetail) == 0){
            if (mysqli_num_rows($cekLokasi) == 0) {
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($ambilIdLokasi[id_lokasi]+1,'$instal','$pengawas','$manuverBebas','$manuverNormal')");
                $id_lokasi_detail = $ambilIdLokasiDetail["id_lokasi_detail"]+1;
            } else {
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($isiLokasi[id_lokasi],'$instal','$pengawas','$manuverBebas','$manuverNormal')");
                $id_lokasi_detail = $ambilIdLokasiDetail["id_lokasi_detail"]+1;
            }
        } else {
            mysqli_query($conn,"UPDATE db_ajax_lokasi_detail SET pengawas = '$pengawas', manuver_bebas = '$manuverBebas', manuver_normal='$manuverNormal' WHERE id_lokasi_detail = $isiJoin[id_lokasi_detail]");
            $id_lokasi_detail = $isiJoin["id_lokasi_detail"];
        }
    } else {
        $id_lokasi_detail = 0;
    }

    $query = "UPDATE db_form SET
              pekerjaan = '$pekerjaan',
              `date` = '$date',
              `start` = '$start',
              `end` = '$end',
              lokasi = '$lokasi',
              installasi = '$instal',
              emergency_pengawas_bebas = '$pengawas',
              foto = '$foto', 
              emergency_bebas ='$manuverBebas',
              foto2 = '$foto2',
              emergency_normal = '$manuverNormal',
              `status` = 'amnUbah',
              catatan_pra_pembebasan = '$catatanPraBebas',
              chose_db = $pilihanDB,
              catatan_pra_penormalan = '$catatanPraNormal',
              id_lokasi_detail = $id_lokasi_detail
              WHERE id = $idTask ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);

}

function insertForm2($post){
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
    $lokasi = strtolower(trim(htmlspecialchars($post["lokasi"])));//================ke DB
    $instal = strtolower(trim(htmlspecialchars($post["instal"])));//================ ke DB

    if (isset($post["lokasiPembebasan"])){
        $pengawas = serialize([
            [
                "lokasiPembebasan" => $post["lokasiPembebasan"]
            ]
        ]);
    } else {
        echo "<script>
        alert ('Anda belum memasukkan lokasi GITET');
                history.back(-1);
             </script>";
             return false;
    }

    $catatanPraBebas = htmlspecialchars($post["catatan_pra_bebas"]);
   
    $array_foto_bebas = [];
    for ($i=0; $i<count($_FILES["fotoBebas"]["name"]); $i++){
        $namaFile = uploadIndex($i,"fotoBebas");
            if (!$namaFile){
                return false;
            }
        array_push($array_foto_bebas,$namaFile);
    }

    if (isset($post["idBebas"])){ 
    $manuverBebas = serialize([
        [
            "idBebas" => $post["idBebas"],
            "titelBebas" => $post["titelBebas"],
            "fotoBebas" => $array_foto_bebas,
            "lokasiManuverBebas" => $post["lokasiManuverBebas"],
            "installManuverBebas" => $post["installManuverBebas"]
        ]

    ]);
    $manuverBebasDB = serialize([
        [
            "idBebas" => $post["idBebas"],
            "titelBebas" => $post["titelBebas"],
            "lokasiManuverBebas" => $post["lokasiManuverBebas"],
            "installManuverBebas" => $post["installManuverBebas"]
        ]
    ]);
    } else {
        echo "<script>
        alert ('Anda belum memasukkan Manuver Pembebasan');
        history.back(-1);
     </script>";
        return false;
    }

    $catatanPraNormal =htmlspecialchars($post["catatan_pra_normal"]);

    $array_foto_normal = [];
    for ($i=0; $i<count($_FILES["fotoNormal"]["name"]); $i++){
        $namaFile = uploadIndex($i,"fotoNormal");
            if (!$namaFile){
                return false;
            }
        array_push($array_foto_normal,$namaFile);
    }

    if (isset($post["idNormal"])){ 
        $manuverNormal = serialize([
            [
                "idNormal[]" => $post["idNormal"],
                "titelNormal" => $post["titelNormal"],
                "fotoNormal" => $array_foto_normal,
                "lokasiManuverNormal" => $post["lokasiManuverNormal"],
                "installManuverNormal" => $post["installManuverNormal"]
            ]
        ]);

        $manuverNormalDB = serialize([
            [
                "idNormal" => $post["idNormal"],
                "titelNormal" => $post["titelNormal"],
                "lokasiManuverNormal" => $post["lokasiManuverNormal"],
                "installManuverNormal" => $post["installManuverNormal"]
            ]
        ]);
    } else {
        echo "<script>
        alert ('Anda belum memasukkan Manuver Penormalan');
        history.back(-1);
     </script>";
        return false;
    } 

    $joinLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis=$jenis AND db_ajax_lokasi.nama='$lokasi' AND db_ajax_lokasi_detail.nama='$instal'");
    $isiJoin = mysqli_fetch_assoc($joinLokasiDetail);
    
    $cekLokasi = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE id_jenis = $jenis AND nama = '$lokasi'");
    $isiLokasi = mysqli_fetch_assoc($cekLokasi);

    $idLokasi = mysqli_query($conn,"SELECT id_lokasi FROM db_ajax_lokasi ORDER BY id_lokasi DESC LIMIT 1");
    $ambilIdLokasi = mysqli_fetch_assoc($idLokasi);

    $cekLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi = $isiLokasi[id_lokasi] AND nama='$instal'");
    $isiLokasiDetail = mysqli_fetch_assoc($cekLokasiDetail);

    $idLokasiDetail = mysqli_query($conn,"SELECT id_lokasi_detail FROM db_ajax_lokasi_detail ORDER BY id_lokasi_detail DESC LIMIT 1");
    $ambilIdLokasiDetail = mysqli_fetch_assoc($idLokasiDetail);

    if ($pilihanDB == 1) {
        if (mysqli_num_rows($joinLokasiDetail) == 0){
            if (mysqli_num_rows($cekLokasi) == 0) {
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($ambilIdLokasi[id_lokasi]+1,'$instal','$pengawas','$manuverBebasDB','$manuverNormalDB')");
                $id_lokasi_detail = $ambilIdLokasiDetail["id_lokasi_detail"]+1;
            } else {
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($isiLokasi[id_lokasi],'$instal','$pengawas','$manuverBebasDB','$manuverNormalDB')");
                $id_lokasi_detail = $ambilIdLokasiDetail["id_lokasi_detail"]+1;
            }
        } else {
            mysqli_query($conn,"UPDATE db_ajax_lokasi_detail SET pengawas = '$pengawas', manuver_bebas = '$manuverBebasDB', manuver_normal='$manuverNormalDB' WHERE id_lokasi_detail = $isiJoin[id_lokasi_detail]");
            $id_lokasi_detail = $isiJoin["id_lokasi_detail"];
        }
    } else {
        if ($_GET["idz"]){
            $id_lokasi_detail = $_GET["idz"];
        } else {
            $id_lokasi_detail = 0 ;
        }
    }

    if (isset($_GET['form'])){
        $form = $_GET['form'];
    } else {
        $form = $post['form'];
    }

    $query = "INSERT INTO db_form (id,create_date,create_user,user,pekerjaan,`date`,`start`,`end`,lokasi,installasi,catatan_pra_pembebasan,catatan_pra_penormalan,`status`,jenis_pekerjaan,chose_db,emergency_pengawas_bebas,emergency_bebas,emergency_normal,id_lokasi_detail,jenis_form)
                VALUE ($idTask,'$create_date','$user','$user','$pekerjaan','$date','$start','$end','$lokasi','$instal','$catatanPraBebas','$catatanPraNormal','amn',$jenis,$pilihanDB,'$pengawas','$manuverBebas','$manuverNormal',$id_lokasi_detail,$form)
                ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);


}

function insertDB($post){
    // var_dump($post); die;
    global $conn;
    $form = $post["form"];
    $jenis = $post["jenis"];
    $lokasi = strtolower(str_replace(" ","",htmlspecialchars($post["lokasi"])));
    $detail = strtolower(str_replace(" ","",htmlspecialchars($post["detailLokasi"])));

    // $cek_lokasi = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE nama='$lokasi'");
    // $ambil_id_lokasi = mysqli_fetch_assoc($cek_lokasi);
    // $cek_lokasi_detail = mysqli_query($conn, "SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi = $ambil_id_lokasi[id_lokasi] AND nama = '$detail'");

    error_reporting(0);

    if(mysqli_num_rows(isset($cek_lokasi_detail)) > 0){
        echo "
        <script>
        alert ('data sudah ada dalam database');
        history.back(-1);
        </script>
        ";
        die;
    }
    
    if (isset($post["lokasiPembebasan"])){
        $pengawas = serialize([
            [
                "lokasiPembebasan" => $post["lokasiPembebasan"]
            ]
        ]);
    } 

    if (isset($post["lokasiManuverBebas"])){
        $manuverBebas = serialize([
            [
                "lokasiManuverBebas" => $post["lokasiManuverBebas"],
                "installManuverBebas" => $post["installManuverBebas"]
            ]
        ]);
    }

    if (isset($post["lokasiManuverNormal"])) {
        $manuverNormal = serialize([
            [
                "lokasiManuverNormal" => $post["lokasiManuverNormal"],
                "installManuverNormal" => $post["installManuverNormal"]
            ]
        ]);

    }

    if (isset($post["idBebas"])) {
        $manuverBebasForm = serialize([
            [
                "idBebas" => $post["idBebas"],
                "titelBebas" => $post["titelBebas"],
                "lokasiManuverBebas" => $post["lokasiManuverBebas"],
                "installManuverBebas" => $post["installManuverBebas"]
            ]
        ]);

    }

    if ($post["idNormal"]) {
        $manuverNormalForm = serialize([
            [
                "idNormal" => $post["idNormal"],
                "titelNormal" => $post["titelNormal"],
                "lokasiManuverNormal" => $post["lokasiManuverNormal"],
                "installManuverNormal" => $post["installManuverNormal"]
            ]
        ]);
    }

    $joinLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi LEFT JOIN db_ajax_lokasi_detail ON db_ajax_lokasi.id_lokasi = db_ajax_lokasi_detail.id_lokasi WHERE db_ajax_lokasi.id_jenis=$jenis AND db_ajax_lokasi.nama='$lokasi' AND db_ajax_lokasi_detail.nama='$detail'");
    $isiJoin = mysqli_fetch_assoc($joinLokasiDetail);

    // untuk nomor id
    $idLokasi = mysqli_query($conn,"SELECT id_lokasi FROM db_ajax_lokasi ORDER BY id_lokasi DESC LIMIT 1");
    $ambilIdLokasi = mysqli_fetch_assoc($idLokasi);

    $cekLokasi = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE id_jenis = $jenis AND nama = '$lokasi'");
    $isiLokasi = mysqli_fetch_assoc($cekLokasi);

    $idLokasiDetailAkhir = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail ORDER BY id_lokasi_detail DESC LIMIT 1");
    $ambilIdLokasiDetailAkhir = mysqli_fetch_assoc($idLokasiDetailAkhir);

    $cekLokasiDetail = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi = $isiLokasi[id_lokasi] AND nama='$instal'");
    $isiLokasiDetail = mysqli_fetch_assoc($cekLokasiDetail);

    if ($form == 1) {
        if (mysqli_num_rows($joinLokasiDetail) == 0) {
            if (mysqli_num_rows($cekLokasi) == 0){
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($ambilIdLokasi[id_lokasi]+1,'$detail','$pengawas','$manuverBebas','$manuverNormal')");
            } else {
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($ambilIdLokasi[id_lokasi],'$detail','$pengawas','$manuverBebas','$manuverNormal')");
            }
        }   else {
            echo "<script>
                    alert ('database tersebut sudah ada');
                 </script>";
            return false;
        }
    } else {
        if (mysqli_num_rows($joinLokasiDetail) == 0) {
            if (mysqli_num_rows($cekLokasi) == 0){
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi (id_jenis,nama) VALUES ($jenis,'$lokasi')");
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($ambilIdLokasi[id_lokasi]+1,'$detail','$pengawas','$manuverBebasForm','$manuverNormalForm')");
            } else {
                mysqli_query($conn,"INSERT INTO db_ajax_lokasi_detail (id_lokasi,nama,pengawas,manuver_bebas,manuver_normal) VALUES ($ambilIdLokasi[id_lokasi],'$detail','$pengawas','$manuverBebasForm','$manuverNormalForm')");
            }
        }   else {
            echo "<script>
                    alert ('database tersebut sudah ada');
                 </script>";
            return false;
        }
    }

    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);

}

function updateDB($post){
    global $conn;
    $form = $post["form"];
    $idLokasi = $post["idy"];
    $idLokasiDetail = $post["idz"];
    $namaLokasi = $post["nama_lokasi"];
    $namaLokasiDetail = $post["nama_lokasi_detail"];

    $queryForm = mysqli_query($conn,"SELECT * FROM db_form WHERE lokasi = '$namaLokasi' AND installasi = '$namaLokasiDetail' AND `status` IN ('amn','amnUbah','msb','msbUbah','initiator')");
    $adaQuery = mysqli_num_rows($queryForm);

    //var_dump($adaQuery); die;
    
    if ( $adaQuery > 0 ) {
        echo    "<script>
                    alert ('database tersebut sedang berjalan');
                </script>";
        return false;
        die;
    }

    if (isset($post["lokasiPembebasan"])){
        $pengawas = serialize([
            [
                "lokasiPembebasan" => $post["lokasiPembebasan"]
            ]
        ]);
    }

    if (isset($post["lokasiManuverBebas"])){
        $manuverBebas = serialize([
            [
                "lokasiManuverBebas" => $post["lokasiManuverBebas"],
                "installManuverBebas" => $post["installManuverBebas"]
            ]
        ]);
    }

    if (isset($post["lokasiManuverNormal"])) {
        $manuverNormal = serialize([
            [
                "lokasiManuverNormal" => $post["lokasiManuverNormal"],
                "installManuverNormal" => $post["installManuverNormal"]
            ]
        ]);
    }

    if (isset($post["idBebas"])) {
        $manuverBebasForm = serialize([
            [
                "idBebas" => $post["idBebas"],
                "titelBebas" => $post["titelBebas"],
                "lokasiManuverBebas" => $post["lokasiManuverBebas"],
                "installManuverBebas" => $post["installManuverBebas"]
            ]
        ]);

    }

    if ($post["idNormal"]) {
        $manuverNormalForm = serialize([
            [
                "idNormal" => $post["idNormal"],
                "titelNormal" => $post["titelNormal"],
                "lokasiManuverNormal" => $post["lokasiManuverNormal"],
                "installManuverNormal" => $post["installManuverNormal"]
            ]
        ]);
    }

    if ($form == 1) {
        mysqli_query($conn,"UPDATE db_ajax_lokasi SET nama = '$namaLokasi' WHERE id_lokasi = $idLokasi");
        $query = "UPDATE db_ajax_lokasi_detail SET nama = '$namaLokasiDetail', pengawas = '$pengawas', manuver_bebas='$manuverBebas', manuver_normal='$manuverNormal' WHERE id_lokasi_detail = $idLokasiDetail";
    } else{
        mysqli_query($conn,"UPDATE db_ajax_lokasi SET nama = '$namaLokasi' WHERE id_lokasi = $idLokasi");
        $query = "UPDATE db_ajax_lokasi_detail SET nama = '$namaLokasiDetail', pengawas = '$pengawas', manuver_bebas='$manuverBebasForm', manuver_normal='$manuverNormalForm' WHERE id_lokasi_detail = $idLokasiDetail";
    }

    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
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
    $potongLevel = substr($level,4);
    $time =$post["time"];
    $status = $post["status"];
    $catatan = $post["catatan_amn"];
    $aproval = $post["aproval"];
    $userMsb = $post["userMSB"];

    if (strlen($level) == 3) {
        $lastLevel = $level ;
    } else {
        $lastLevel = $potongLevel ;
    }

    if ($aproval == 'approve' && $status == 'amn'){
        $status = 'msb' ;
    } elseif  ($aproval == 'disapprove' && $status =='amn') {
        $status = 'initiator' ;
    } elseif ($aproval == 'approve' && $status =='amnUbah') {
        $status = 'amn' ;
    } elseif  ($aproval == 'disapprove' && $status =='amnUbah'){
        $status = 'initiator';
    }

    $query = "UPDATE db_form SET 
             user_amn = '$userAmn',
             level_amn = '$lastLevel',
             time_amn_aprove = '$time',
             `status` = '$status',
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
    $potongLevel = substr($level,4);
    $time = $post["time"];
    $catatan = $post["catatan_msb"];
    //$statusAE = $post["statusAE"];

    if (strlen($level) == 3) {
        $lastLevel = $level ;
    } else {
        $lastLevel = $potongLevel ;
    }


    if ($aproval == 'approve' && $status == 'msb'){
        $status = 'dispaAwal';
    } elseif ($aproval == 'disapprove' && $status == 'msb'){
        $status = 'initiator';
    } elseif ($aproval == 'approve' && $status == 'msbUbah') {
        $status = 'dispaAwal';
    } elseif ($aproval == 'disapprove' && $status == 'msbUbah') {
        $status = 'initiator';
    }

    // rencana ditambahkan dispa = pembebasan dan status = pembebasan
    $query = "UPDATE db_form SET 
             user_msb = '$userMsb',
             level_msb = '$level',
             time_msb_aprove = '$time',
             msb = '$aproval',
             `status` = '$status',
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
    $dpf_awal = htmlspecialchars($post["dpf_awal"]);
    $userDispa = $post["userdispa"];
    $status = $post["status"];

    $pengawas = serialize([
        [
            "lokasiPembebasan" => $post["lokasiPembebasan"],
            "peng_pekerjaan" => $post["peng_pekerjaan"],
            "peng_manuver" => $post["peng_manuver"],
            "peng_k3" => $post["peng_k3"],
            "spv" => $post["spv"],
            "opr" => $post["opr"]
        ]
    ]);

    if (isset($_POST["document"])){
        $document = implode(",", $post["document"]);
    }

    
    $scada_awal_before = htmlspecialchars($post["scada_awal_before"]);
    
    if( $_FILES['dpfFile_awal']['error'] === 4){
        $foto = $fotolama;
    } else {
        $foto = uploadDpf('dpfFile_awal');
    }
    
    $scada_awal_after = htmlspecialchars($post["scada_awal_after"]);

    $manuverBebas = serialize([
        [
            "lokasiManuverBebas" => $post["lokasiManuverBebas"],
            "remote_bebas" => $post["remote_bebas"],
            "real_bebas" => $post["real_bebas"],
            "ads_bebas" => $post["ads_bebas"],
            "installManuverBebas" => $post["installManuverBebas"]
        ]
    ]);

    
    $catatan = htmlspecialchars($post["catatan_pasca_bebas"]);

    if($status == 'dispaAwalUbah') {
        $status = 'amnDispaAwalUbah';
    } else {
        $status ='amnDispaAwal';
    }

    $query = "UPDATE db_form SET
              user_dispa_awal = '$userDispa',
              emergency_pengawas_bebas = '$pengawas',
              scada_awal_before = '$scada_awal_before',
              scada_awal_after = '$scada_awal_after',
              report_date = '$report',
              dpf_awal = '$dpf_awal',
              document = '$document',
              catatan_pasca_pembebasan = '$catatan',
              time_dispa_awal_aprove = '$time',
              foto_dpf1 = '$foto',
              emergency_bebas = '$manuverBebas',
              `status` = '$status'
              WHERE id = $idTask
    ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

function inputDispaAkhir($post) {
    global $conn;
    $idTask = $post["idTask"];
    $fotolama = $post["fotoLama"];
    $dpf_akhir = htmlspecialchars($post["dpf_akhir"]);
    $userDispa = $post["userdispa"]; 
    $timeDispaAproveAkhir = $post["time"];
    $status = $post["status"];
    $pengawas =serialize([
        [
            "spv_normal" => $post["spv_normal"],
            "opr_normal" => $post["opr_normal"]
        ]
    ]);

    $scada_akhir_before = htmlspecialchars($post["scada_akhir_before"]);
    $scada_akhir_after = htmlspecialchars($post["scada_akhir_after"]);

    if( $_FILES['dpfFile_akhir']['error'] === 4){
        $foto = $fotolama;
    } else {
        $foto = uploadDpf('dpfFile_akhir');
    }

   $manuverNormal = serialize([
        [
            "lokasiManuverNormal" => $post["lokasiManuverNormal"],
            "remote_normal" => $post["remote_normal"],
            "real_normal" => $post["real_normal"],
            "ads_normal" => $post["ads_normal"],
            "installManuverNormal" => $post["installManuverNormal"]
        ]
   ]);

   
   $catatan = htmlspecialchars($post["catatan_pasca_normal"]);

    if($status == 'dispaAkhir') {
        $status = 'amnDispaAkhir';
    } else {
        $status ='amnDispaAkhirUbah';
    }

    // var_dump($status); die;
    $query = "UPDATE db_form SET
             user_dispa_akhir = '$userDispa',
             emergency_pengawas_normal = '$pengawas',
             scada_akhir_before = '$scada_akhir_before',
             scada_akhir_after = '$scada_akhir_after',
             dpf_akhir = '$dpf_akhir',
             catatan_pasca_penormalan = '$catatan',
             time_dispa_akhir_aprove = '$timeDispaAproveAkhir',
             emergency_normal = '$manuverNormal',
             foto_dpf2 = '$foto',
             `status` = '$status'
             WHERE id = $idTask
             ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

function amnDispaAproveAwal($post) {
    global $conn;
    $idTask = $post["idTask"];
    $userAmnDispa = $post["userAmnDispa"];
    $aproval = $post["aproval"];
    $timaAprovalAmnDispaAwal = $post["time"];
    $catatan = $post["catatan_amndis_awal"];
    $level = $post["level"];
    

    if ($aproval == 'approve') {
        $status = 'dispaAkhir';
    } elseif ($aproval == 'disapprove'){
        $status = 'dispaAwalUbah';
    }

    $query = "UPDATE db_form SET
              user_amn_dispa_awal = '$userAmnDispa',
              amn_dispa_awal = '$aproval',
              time_amnDispa_awal_aprove = '$timaAprovalAmnDispaAwal',
              catatan_amnDispa_awal = '$catatan',
              level_amn_dispa_awal = '$level',
              `status` = '$status'
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

function hapusDBParent($id) {
    global $conn;

    // $query = "SELECT * FROM db_db_ajax_lokasi_detail WHERE id_lokasi = $id";
    // $data = mysqli_fetch_assoc($query);

    mysqli_query($conn,"DELETE FROM db_ajax_lokasi WHERE id_lokasi = $id");
    mysqli_query($conn,"DELETE FROM db_ajax_lokasi_detail WHERE id_lokasi = $id");
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
    $query = mysqli_query($conn,"SELECT * FROM db_form WHERE id = $id");
    $isiQuery = mysqli_fetch_assoc($query);
    $dataFoto = array($isiQuery['foto'],$isiQuery['foto2'],$isiQuery['foto_dpf1'],$isiQuery['foto_dpf2']);
    
    for ($i=0; $i<count($dataFoto); $i++) {
        if(!empty($dataFoto[$i])){
            unlink('img/'.$dataFoto[$i]);
        }
    }

    mysqli_query($conn,"DELETE FROM db_form WHERE id = $id");
    mysqli_query($conn,"DELETE FROM db_table_pengawas WHERE id_form = $id");
    mysqli_query($conn,"DELETE FROM db_table_tahapan WHERE id_form = $id");
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

    return mysqli_affected_rows($conn);
}

function insertEmergency($post){
    
    global $conn;
    $create_date = $post["create_date"];//ok
    $user = $post["user_creater"]; ;//ok
    $idTask =$post["idTask"];//ok
    $pekerjaan = htmlspecialchars($post["pekerjaan"]);//ok
    $date = $post["date"];
    $start = $post["start"];
    $end = $post["end"];
    $lokasi = strtolower(ltrim(rtrim(htmlspecialchars($post["lokasi"]))));//================ke DB
    $instal = strtolower(ltrim(rtrim(htmlspecialchars($post["instal"]))));//================ ke DB
    $report = $post["report_date"];

    if ($_GET['form']) {
        $form = $_GET["form"];
    } else {
        $form = $post["form"];
    }

    if (!$end){
        $end = "00:00:00";
    }

    $pengawas = serialize([
        [
            "lokasiPembebasan" => $post["lokasiPembebasan"],
            "peng_pekerjaan" => $post["peng_pekerjaan"],
            "peng_manuver" => $post["peng_manuver"],
            "peng_k3" => $post["peng_k3"],
            "spv" => $post["spv"],
            "opr" => $post["opr"]
        ]
    ]);

    if (isset($_POST["document"])){
        $document = implode(",", $post["document"]);
    }
    
    $surat = uploadSurat();

    $scada_awal_before = htmlspecialchars($post["scada_awal_before"]);
    
    $scada_awal_after = htmlspecialchars($post["scada_awal_after"]);

    $catatanPraBebas = htmlspecialchars($post["catatan_pra_bebas"]);

    $foto = upload("foto"); 
     if( !$foto ){
         return false;
     }
    
    $manuverBebas = serialize([
        [
            "lokasiManuverBebas" => $post["lokasiManuverBebas"],
            "remote_bebas" => $post["remote_bebas"],
            "real_bebas" => $post["real_bebas"],
            "ads_bebas" => $post["ads_bebas"],
            "installManuverBebas" => $post["installManuverBebas"]
        ]
    ]);

    $catatanPascaBebas = htmlspecialchars($post["catatan_pasca_bebas"]);

    $query = "INSERT INTO db_form 
                (id,create_date,create_user,user_dispa_awal,pekerjaan,`date`,`start`,`end`,lokasi,installasi,emergency_pengawas_bebas,document,surat,scada_awal_before,scada_awal_after,catatan_pra_pembebasan,foto,emergency_bebas,catatan_pasca_pembebasan,`status`,report_date,jenis_form)
              VALUES
                ($idTask,'$create_date','$user','$user','$pekerjaan','$date','$start','$end','$lokasi','$instal','$pengawas','$document','$surat','$scada_awal_before','$scada_awal_after','$catatanPraBebas','$foto','$manuverBebas','$catatanPascaBebas','amnDispaAwal','$report',$form)
             ";



    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);

}

function ubahEmergencyAwal($post){
    global $conn;
    $create_date = $post["create_date"];//ok
    $user = $post["user"]; ;//ok
    $idTask =$post["idTask"];//ok
    $pekerjaan = htmlspecialchars($post["pekerjaan"]);//ok
    $date = $post["date"];
    $start = $post["start"];
    $end = $post["end"];
    $report =$post["report_date"];
    $lokasi = strtolower(ltrim(rtrim(htmlspecialchars($post["lokasi"]))));//================ke DB
    $instal = strtolower(ltrim(rtrim(htmlspecialchars($post["instal"]))));//================ ke DB
    $filelama = $post["filelama"];
    $fotoLamaBebas = $post["fotoLamaBebas"];
    $fotoLamaNormal = $post["fotoLamaNormal"];
    $statusAwal = $post["status"];
    $timaAprovalAmnDispaAwal = $post["dateAprove"];

    if (!$end){
        $end = "00:00:00";
    }

    $pengawas = serialize([
        [
            "lokasiPembebasan" => $post["lokasiPembebasan"],
            "peng_pekerjaan" => $post["peng_pekerjaan"],
            "peng_manuver" => $post["peng_manuver"],
            "peng_k3" => $post["peng_k3"],
            "spv" => $post["spv"],
            "opr" => $post["opr"]
        ]
    ]);

    if (isset($_POST["document"])){
        $document = implode(",", $post["document"]);
        // mysqli_query($conn,"UPDATE db_form SET document = '$document' WHERE id=$idTask");
    }

    if( $_FILES['pdf']['error'] === 4){
        $surat = $filelama;
    } else {
        $surat = uploadSurat();
    }
    
    $scada_awal_before = htmlspecialchars($post["scada_awal_before"]);
    $scada_awal_after = htmlspecialchars($post["scada_awal_after"]);
    $catatanPraBebas = htmlspecialchars($post["catatan_pra_bebas"]);

    if( $_FILES['foto']['error'] === 4){
        $foto = $fotoLamaBebas;
    } else {
        $foto = upload("foto");
    }

    $manuverBebas = serialize([
        [
            "lokasiManuverBebas" => $post["lokasiManuverBebas"],
            "remote_bebas" => $post["remote_bebas"],
            "real_bebas" => $post["real_bebas"],
            "ads_bebas" => $post["ads_bebas"],
            "installManuverBebas" => $post["installManuverBebas"]
        ]
    ]);

    $catatanPascaBebas = htmlspecialchars($post["catatan_pasca_bebas"]);

    

    if($statusAwal == 'dispaAwalUbah') {
        $status = 'amnDispaAwalUbah';
    } else {
        $status = 'amnDispaAwal';
    }

    $query = "UPDATE db_form SET
              pekerjaan = '$pekerjaan',
              `date` = '$date',
              `start` = '$start',
              `end` = '$end',
              lokasi = '$lokasi',
              installasi = '$instal',
              emergency_pengawas_bebas = '$pengawas',
              foto = '$foto', 
              document = '$document',
              surat = '$surat',
              scada_awal_before = '$scada_awal_before',
              scada_awal_after = '$scada_awal_after',
              catatan_pra_pembebasan = '$catatanPraBebas',
              foto = '$foto',
              emergency_bebas = '$manuverBebas',
              catatan_pasca_pembebasan = '$catatanPascaBebas',
              report_date = '$report',
              time_dispa_awal_aprove = '$timaAprovalAmnDispaAwal',
              `status` = '$status'
              WHERE id = $idTask;
            ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);

}

function ubahEmergencyAkhir($post){
    global $conn;
    $user = $_SESSION['username'];//ok
    $idTask =$post["idTask"];//ok
    $fotoLamaNormal = $post["fotoLamaNormal"]; 
    $statusAwal = $post["status"];
    $timaAprovalAmnDispaAwal = $post["dateAprove"];

    $pengawas = serialize([
        [
            "spv_normal" => $post["spv_normal"],
            "opr_normal" => $post["opr_normal"]
        ]
        
    ]);

    $scada_akhir_before = htmlspecialchars($post["scada_akhir_before"]);
    $scada_akhir_after = htmlspecialchars($post["scada_akhir_after"]);
    $catatanPraNormal =htmlspecialchars($post["catatan_pra_normal"]);

    if( $_FILES['foto2']['error'] === 4){
        $foto2 = $fotoLamaNormal;
    } else {
        $foto2 = upload("foto2");
    }

    $manuverNormal = serialize([
        [
            "lokasiManuverNormal" => $post["lokasiManuverNormal"],
            "remote_normal" => $post["remote_normal"],
            "real_normal" => $post["real_normal"],
            "ads_normal" => $post["ads_normal"],
            "installManuverNormal" => $post["installManuverNormal"]
        ]
        
    ]);

    $catatanPascaNormal = htmlspecialchars($post["catatan_pasca_normal"]);

    if($statusAwal == 'dispaAkhirUbah') {
        $status = 'amnDispaAkhirUbah';
    } else {
        $status = 'amnDispaAkhir';
    }

    $query = "UPDATE db_form SET
                user_dispa_akhir ='$user',
                emergency_pengawas_normal = '$pengawas',
                scada_akhir_before = '$scada_akhir_before',
                scada_akhir_after ='$scada_akhir_after',
                catatan_pra_penormalan = '$catatanPraNormal',
                catatan_pasca_penormalan = '$catatanPascaNormal',
                foto2 ='$foto2 ',
                emergency_normal = '$manuverNormal',
                time_dispa_akhir_aprove = '$timaAprovalAmnDispaAwal',
                `status` = '$status'
                WHERE id = $idTask;
            ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);


}

function postpone($post){
    global $conn;
    $user_dispa = $_SESSION["username"];
    $postpone = $post["postpone"];

    mysqli_query($conn,"UPDATE db_form SET user_dispa_awal = '$user_dispa', postpone = '$postpone', `status`= 'postpone' WHERE id=$_GET[id]");
    return mysqli_affected_rows($conn);


}

// ===========================================================================untuk upload gambar manuver===========================================
function upload($post){
    $namaFile = $_FILES[$post]["name"];
    $ukuranFile = $_FILES[$post]["size"];
    $error = $_FILES[$post]["error"];
    $tmpNama = $_FILES[$post]["tmp_name"];

    //cek apakah tidak ada gambar yg diupload
    if( $error === 4) {     //angka 4 indikasi error tidak ada gambar yg diupload baku
        echo "<script>
                alert ('Anda belum upload gambar!');
                </script>";
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
    if( $ukuranFile > 10000000){
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

function uploadDpf($post) {
    $namaFile = $_FILES[$post]["name"];
    $ukuranFile = $_FILES[$post]["size"];
    $error = $_FILES[$post]["error"];
    $tmpNama = $_FILES[$post]["tmp_name"];

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
    if( $ukuranFile > 10000000){
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

function uploadSurat() {
    $namaFile = $_FILES["pdf"]["name"];
    $ukuranFile = $_FILES["pdf"]["size"];
    $error = $_FILES["pdf"]["error"];
    $tmpNama = $_FILES["pdf"]["tmp_name"];

    //cek apakah tidak ada gambar yg diupload
    if( $error === 4) {     //angka 4 indikasi error tidak ada gambar yg diupload baku
        echo "<script>
                alert ('Anda belum upload document!');
                </script>";
        return false;
    }

    //cek yang diupload gambar atau bukan
    $ekstensiGambarValid = ['jpg','jpeg','png','pdf']; //menentukan format
    $ekstensiGambar = explode('.',$namaFile); //explode untuk delimiter nama file menjadi array contoh shofwan.jpg menjadi ['shofwan'.'jpg']
    $ekstensiGambar = strtolower(end($ekstensiGambar)); // end untuk mengambil array paling belakang dimana paling belakang jpg/png/jpeg strtolower untuk mengecilkan huruf jika format kapital
    if( !in_array($ekstensiGambar,$ekstensiGambarValid)){
        echo "<script>
                alert ('Anda tidak mengupload document format dpf, jpg, jpeg dan png!');
                </script>";
        return false;

    } 

    //cek ukuran gambar
    if( $ukuranFile > 10000000){
        echo "<script>
                alert ('Anda mengupload gambar ukuran diatas 10MW');
                </script>";
        return false;
    }

    //lolos upload
    //generate nama gambar agar tidak ada yg sama
    $namaFileBaru = 'SURAT_'.date('dmY_His');                               //membuat nama file random
    $namaFileBaru .= '.';                                   //menggabungkan nama file baru dengan ekstensu eksisting
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpNama, 'surat/' . $namaFileBaru);
    return  $namaFileBaru;
}

function uploadIndex($index,$post) {
    $namaFile = $_FILES[$post]["name"][$index];
    $ukuranFile = $_FILES[$post]["size"][$index];
    $error = $_FILES[$post]["error"][$index];
    $tmpNama = $_FILES[$post]["tmp_name"][$index];
    //cek apakah tidak ada gambar yg diupload
    if( $error === 4) {     //angka 4 indikasi error tidak ada gambar yg diupload baku
        echo "<script>
                alert ('Anda belum upload gambar!');
                </>";
        return false;
    }
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
    move_uploaded_file($tmpNama, 'img/' . $namaFileBaru);
    return  $namaFileBaru;
}







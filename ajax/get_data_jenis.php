<?php

include 'functions.php';

$form = $_POST['id'];
$modul = $_POST['modul'];

if ($modul == 'jenis') {
    $sql = mysqli_query($conn,"SELECT * FROM db_ajax_jenis WHERE id_form = $form ORDER BY nama ASC") or die(mysqli_error($conn));
    $jenis='<option>-SELECT-</option>';
    while ($dt = mysqli_fetch_array($sql)) {
        $jenis.='<option value="'.$dt['id_jenis'].'">'.$dt['nama'].'</option>';
    }

    echo $jenis;
}

elseif ($modul == 'lokasi') {
    $sql = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi WHERE id_jenis = $form ORDER BY nama ASC") or die(mysqli_error($conn));
    $lokasi='<option>-SELECT-</option>';
    while ($dt = mysqli_fetch_array($sql)) {
        $lokasi.='<option value="'.$dt['id_lokasi'].'">'.strtoupper($dt['nama']).'</option>';
    }

    echo $lokasi;
}
elseif ($modul == 'detail_lokasi') {
    $sql = mysqli_query($conn,"SELECT * FROM db_ajax_lokasi_detail WHERE id_lokasi = $form ORDER BY nama ASC") or die(mysqli_error($conn));
    $detail='<option>-SELECT-</option>';
    while ($dt = mysqli_fetch_array($sql)) {
        $detail.='<option value="'.$dt['id_lokasi_detail'].'">'.strtoupper($dt['nama']).'</option>';
    }

    echo $detail;
}


?>
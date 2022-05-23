<?php
//include 'functions.php';

$id = $_POST['id'];
// error_reporting(E_ALL ^ E_NOTICE);

//cara ke-2
if (isset($_POST['q'])) {
   
    
    
    $response = "<ul><li>No data found!</li></ul>";

    $connection = mysqli_connect("localhost","root","","db_lm");//new mysqli("localhost","root","","db_provinsi");
    $q = $connection->real_escape_string($_POST['q']);

    $sql = $connection->query("SELECT nama FROM db_ajax_lokasi WHERE id_jenis=$id AND nama LIKE '%$q%'");
    if ($sql->num_rows > 0) {
        $response = "<ul class='auto'>";

        while ($data = $sql->fetch_array())
            $response .= "<li>" . strtoupper($data['nama']) . "</li>";

        $response .= "</ul>";
    }
    exit($response);
}



?>
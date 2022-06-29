<?php
//include 'functions.php';

$id = $_POST['id'];
$val = $_POST['val'];
error_reporting(E_ALL ^ E_NOTICE);
//cara ke-2
if (isset($_POST['q'])) {
   
      $response = "<ul><li>No data found!</li></ul>";

      $connection = mysqli_connect("localhost","root","","db_lm");//new mysqli("localhost","root","","db_provinsi");
      $q = $connection->real_escape_string($_POST['q']);
      $val = $connection->real_escape_string($_POST['val']);


      $beforeSql = $connection->query("SELECT * FROM db_ajax_lokasi WHERE id_jenis = $id AND nama = '$val'");
      $ambilSql = mysqli_fetch_assoc($beforeSql);
      $sql = $connection->query("SELECT nama FROM db_ajax_lokasi_detail WHERE id_lokasi=$ambilSql[id_lokasi] AND nama LIKE '%$q%'");
      if ($sql->num_rows > 0) {
          $response = "<ul class='auto'>";

          while ($data = $sql->fetch_array())
              $response .= "<li class='detail'>" . strtoupper($data['nama']) . "</li>";

          $response .= "</ul>";
      }
      exit($response);
  }



?>
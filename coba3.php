<?php
  include 'coba2.php';
  
  //$searchkey = $_GET['term']; // menangkap kiriman data dari inputan yang dimasukan
  // $id = $_POST['id'];
  // $modul = $_POST['modul'];
  

  // if ($modul == 'provinsi') {
  //   $sql = mysqli_query($conn,"SELECT * FROM provinsi WHERE id_pulau = $id ORDER BY nama ASC") or die(mysqli_error($conn));
  //   $provinsi = "<ul>";
  //   while ($data = mysqli_fetch_array($sql)){
  //     $provinsi.='<li>' . $data['nama'] . '</li>';
  //   }

  //   echo $provinsi;
 
  // }

  $id = $_POST['id'];
  //cara ke-2
  if (isset($_POST['q'])) {
     
		$response = "<ul><li>No data found!</li></ul>";

		$connection = mysqli_connect("localhost","root","","db_provinsi");//new mysqli("localhost","root","","db_provinsi");
		$q = $connection->real_escape_string($_POST['q']);

		$sql = $connection->query("SELECT nama FROM provinsi WHERE id_pulau=$id AND nama LIKE '%$q%'");
		if ($sql->num_rows > 0) {
			$response = "<ul>";

			while ($data = $sql->fetch_array())
				$response .= "<li>" . $data['nama'] . "</li>";

			$response .= "</ul>";
		}
		exit($response);
	}





  // $key =$_POST['pulauId'];
 
  // $query = "SELECT * FROM provinsi WHERE id_pulau = $key AND nama LIKE '%".$searchkey."%' ORDER BY nama ASC"; //perintah query sql untuk menampilkan data pada tabel murid dengan operator SQL = LIKE
   
  // $pencarian =mysqli_query($conn,$query); // query dieksekusi
   
  // // data ditampilkan dengan menggunakan perulangan
  // while ($row = mysqli_fetch_array($pencarian)) {
  //     $data[] = $row['nama'];
  // }
  // // nilainya disimpan dalam bentuk json
  // echo json_encode($data);




  // if (isset($_POST['term'])) {
  //   $query = "SELECT * FROM provinsi WHERE nama LIKE '%{$_POST['term']}%' LIMIT 25";
  //   $result = mysqli_query($conn, $query);
  //   if (mysqli_num_rows($result) > 0) {
  //   while ($user = mysqli_fetch_array($result)) {
  //   $res[] = $user['nama'];
  //   }
  //   } else {
  //   $res = array();
  //   }
  //   //return json res
  //   echo json_encode($res);
  //   }

// $term = trim(strip_tags($_GET['term']));
// //query untuk menampilkan data dari tabel country
// $query = mysqli_query($conn, "SELECT * FROM provinsi WHERE  nama LIKE '%$term%' ");

// $array=array();
// //looping data
// while($data=mysqli_fetch_assoc($query)){ 
//     $row['value']=$data['nama'];
//  //buat array yang nantinya akan di konversi ke json
//     array_push($array, $row);
//    }

//    echo json_encode($array);
?>
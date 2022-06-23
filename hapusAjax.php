<?php 

require "functions.php";

$id = $_GET["id"];

if ( hapusDB($id) > 0) {
    echo "<script>
            alert ('data berhasil dihapus');
            document.location.href ='home.php?url=updateDB';
         </script>";
} else {
    echo "<script>
    alert ('data berhasil dihapus');
    document.location.href ='home.php?url=updateDB';
 </script>";

}

?>
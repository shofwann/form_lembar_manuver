<?php

require "functions.php";
$id = $_GET["id"];

if ( hapusUser($id) > 0) {
    echo "<script>
            alert ('data berhasil dihapus');
            document.location.href ='home.php?url=users';
         </script>";
} else {
    echo "<script>
    alert ('data berhasil dihapus');
    document.location.href ='home.php?url=users';
 </script>";

}

?>
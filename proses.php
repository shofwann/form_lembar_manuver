<?php

$form = $_GET["form"];
$ida = $_GET["idx"];
$idb = $_GET["idy"];
$idc = $_GET["idz"];
$level = $_GET['level'];

if(  $level == 'dispa' ) {
    
    echo "bener";
    if ($form == 1) {
        echo
        "<script>
        alert('anda memilih form1');
        document.location.href = 'home.php?url=form_emergency_auto&idx=$ida&idy=$idb&idz=$idc';
        </script>";
        //header("Location:initiator-dashboard.php?url=autoForm1&idz=$id");
    }elseif ($form == 2){
        echo "<script>
        alert('form 2 belum ada');
        document.location.href = 'home.php';
        </script>";
    }

} else {

    
    if ($form == 1) {
        echo
        "<script>
        alert('anda memilih form1');
        document.location.href = 'home.php?url=autoForm1&idx=$ida&idy=$idb&idz=$idc&idForm=$form';
        </script>";
        //header("Location:initiator-dashboard.php?url=autoForm1&idz=$id");
    }elseif ($form == 2){
        echo "<script>
        alert('anda memilih form2');
        document.location.href = 'home.php?url=autoForm2&idx=$ida&idy=$idb&idz=$idc&idForm=$form';
        </script>";
    }
}


?>
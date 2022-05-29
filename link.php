<?php

$conn=mysqli_connect("localhost","root","","db_lm");
$sql=mysqli_query($conn,"SELECT * FROM db_form WHERE status = 'dispaAwal' OR status = 'dispaAkhir' OR status = 'dispaAwalUbah' OR status = 'dispaAkhirUbah' OR status = 'amnDispaAwal' OR status = 'amnDispaAkhir' OR status = 'amnDispaAwalUbah' OR status = 'amnDispaAkhirUbah'");

if (isset($_GET['url']))
{
    $url=$_GET['url'];

    switch($url)
    {
        case'form-1';
        include "form-1.php";
        break;

        case'form-2';
        include "form-2.php";
        break;
        
        case 'inbox';
        include 'inbox.php';
        break;
        
        case 'amnApprove';
        include 'approve-amn.php'; 
        break;
        
        case 'participant';
        include 'participant.php';
        break;

        case 'show_detail';
        include 'show_detail.php';
        break;
        case 'updateForm-1';
        include 'updateForm1.php';
        break;
        
        case 'msbApprove';
        include 'approve-msb.php'; 
        break;
        
        case 'dispaInputAwal';
        include 'dispa-inputAwal.php';
        break;
        
        case 'amnApproveAwal';
        include 'approve-amn-dispa-awal.php';
        break;
        
        case 'dispaInputAkhir';
        include 'dispa-inputAkhir.php';
        break;
        
        case 'amnApproveAkhir';
        include 'approve-amn-dispa-akhir.php';
        break;
        
        case 'autoForm1';
        include 'form-auto.php';
        break;
        
        case 'select-form';
        include 'select-form.php';
        break;

        case 'insertDB';
        include 'DBinsert.php';
        break;

        case 'updateDB';
        include 'DBupdate.php';
        break;

        case 'hapusAjax';
        include 'hapusAjax.php';
        break;

        
        
        
        
        




        case'listManuverDispa';
        include 'listManuverDispa.php';   //delete
        break;

        case 'list_pekerjaan';
        include 'list_pekerjaan2.php';
        break;

        case 'show_detail';
        include 'show_detail.php';
        break;

        case 'initiatorInbox';
        include 'initiator-Inbox.php'; //delete
        break;
        

        case 'amnInbox';
        include 'amn-inbox.php'; //delete
        break;

        case 'amnList';
        include 'amn-list.php'; //delete
        break;


        case 'msbInbox';
        include 'msb-inbox.php'; //delete
        break;

        case 'msbList';
        include 'msb-list.php'; //delete
        break;

        case 'msbApprove';
        include 'msb-approve.php'; 
        break;

        case 'dispaInbox';
        include 'dispa-inbox.php'; //delete
        break;

        case 'dispaList';
        include 'dispa-list.php'; //delete
        break;

        case 'tes';
        include 'tes.php';  //delete
        break;

        case 'trial';
        include 'auto.php';
        break;

        case 'autoForm2';
        include 'auto-form2.php';
        break;

        case 'amnDispaInbox';
        include 'dispa-amn-inbox.php';  //delete
        break;

        case 'amnDispaList';
        include 'dispa-amn-list.php'; //delete
        break;

        case 'dispaUpdateAwal';
        include 'dispa-update-awal.php';
        break;

        case 'dispaUpdateAkhir';
        include 'dispa-update-akhir.php';
        break;

        case 'users';
        include 'admin-users.php';
        break;

        case 'jobs';
        include 'admin-jobs.php';
        break;

        case 'userUbah';
        include 'admin-usersUbah.php';
        break;

        case 'userHapus';
        include 'admin-usersHapus.php';
        break;

        case 'hapus';
        include 'admin-hapusPekerjaan.php';
        break;


        case 'change-pass';
        include 'ganti-pass.php';
        break;

        case 'change-pass';
        include 'home.php';
        break;

        
        case 'form-auto-new';
        include 'form-second/form-auto.php';
        break;



        


        


        
        
    }
}
else
{
    
    ?>

    
        <div class="card">
            <div class="card-header">
            Dashboard
            </div>
            <div class="container-wrap">
                <div class="container" style="height: 990px;">
                    User Level <?= $_SESSION['level']; ?> <br> Nama User: <?= $_SESSION['username']; ?> 
                    <div class="pekerjaan" style="margin-top:15px;">
                        <h4>List Pekerjaan sedang berjalan</h4>
                        <?php while ($listPekerjaanBerlangsung = mysqli_fetch_assoc($sql)) : ?>
                            <ul style="margin-left:19px;">
                                <li><?= $listPekerjaanBerlangsung['pekerjaan']?></li>
                            </ul>
                        <?php endwhile; ?>
                    </div>
                   

                    
                    
                 <?php
                echo "</div>";
            echo "</div>";
        echo "</div>";
    
        

}
?>

       

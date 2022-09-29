<?php

require 'fpdf/fpdf.php';
require 'functions.php';

$query=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
$isi=mysqli_fetch_assoc($query);
class PDF extends FPDF {
    function BasicTable($header, $data, $x = 0, $y = 0) {

		$this->SetXY($x , $y);
		
		// Header
		foreach($header as $col)
			$this->Cell(15 ,5,$col,1); 
		$this->Ln(0);
		
		// Data
		$i = 5;
		$this->SetXY($x , $y + $i);
		foreach($data as $row){
			foreach($row as $col){
				//$this->SetXY($x , $y + $i);
				$this->Cell(15 ,5,$col,1);
				
			}
			$i= $i + 5 ;  // incremento el valor de la columna
			$this->SetXY($x , $y + $i);		
		  //$this->Ln();
		}
	}
}

$pdf = new PDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(280,0,'Pedoman Manuvar Untuk Pemeliharaan/Perbaikan/Perluasan Instalasi/ Pengaturan Tegangan',0,1,'C');
$pdf->Cell(59,5,'',0,1);

$pdf->SetFont('Times','B','10');
$pdf->Cell(16,5,'Pekerjaan','T,L',0);
$pdf->Cell(2,5,':','T',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(114,5,substr($isi['pekerjaan'],0,64),'T,R',0);
$pdf->SetFont('Times','B','10');
$pdf->Cell(90,5,'Manuver Pembebasan','T,R',0,'C');
$pdf->Cell(60,5,'Manuver Penormalan','T,R',1,'C');
$pdf->SetFont('Times','','10');
$pdf->Cell(19,5,'','L',0);
$pdf->Cell(113,5,substr($isi['pekerjaan'],64,64),'',0);
$pdf->Cell(90,5,'','L',0,'');
$pdf->SetFont('Times','B','10');

$dataArray = unserialize($isi["emergency_pengawas_bebas"]);


$rencana = $_GET['jumlah'];
if ($rencana == 2){
    $a = 22.5;
    $b = 30;
    $c = '           .....                         .....            ';
    $d = '           .....                         .....            ';
} elseif ($rencana == 3){
    $a = 15;
    $b = 20;
    $c = '           .....           .....            .....';
    $d = '        .....                .....                  .....';
} elseif ($rencana == 1){
	$a = 45;
    $b = 60;
    $c = '           .....                      ';
    $d = '                              .....           ';
	
}

foreach (unserialize($isi["emergency_pengawas_bebas"]) ?: [] as $row) :
	for($j = 0; $j < count($row["lokasiPembebasan"]); $j++){

		foreach (unserialize($isi["emergency_pengawas_normal"]) ?: [] as $row2) :
                                                      
			for($k = 0; $k < count($row2["spv_normal"]); $k++){
		
$pdf->Cell(60,5,'','LR',1,'');
$pdf->Cell(38+39,5,'','L',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(55,5,'','',0);
$pdf->Cell(30,5,'Pengawas Pekerjaan','L',0);
$pdf->Cell(2,5,':','',0);
$pdf->Cell(58,5,$row['peng_pekerjaan'][0],'R',0);
$pdf->Cell(60,5,$row2['spv_normal'][$k],'R',1);

$pdf->SetFont('Times','B','10');
$pdf->Cell(18,5,'','L',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(114,5,'','R',0);
$pdf->Cell(30,5,'Pengawas Manuver','',0);
$pdf->Cell(2,5,':','',0);
$pdf->Cell(58,5,$row['peng_pekerjaan'][0],'R',0);
$pdf->Cell(60,5,$row2['spv_normal'][$k],'R',1);

$pdf->SetFont('Times','B','10');
$pdf->Cell(16.5,5,'Lokasi','L',0);
$pdf->Cell(2,5,':','',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(52,5,$isi['lokasi'],'',0,'');
$pdf->SetFont('Times','B','10');
$pdf->cell(15,5,'installasi','',0);
$pdf->Cell(2,5,':','',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(44.5,5,$isi['installasi'],'R',0,'');
$pdf->Cell(30,5,'Pengawas K3','',0);
$pdf->Cell(2,5,':','',0);
$pdf->Cell(58,5,$c,'R',0);
$pdf->Cell(60,5,$d,'R',1);

$pdf->SetFont('Times','B','10');
$pdf->Cell(16.5,5,'Date','L',0);
$pdf->Cell(2,5,':','',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(113.5,5,$isi['date'],'R',0,'');
$pdf->Cell(30,5,'Supervisor GITET','',0);
$pdf->Cell(2,5,':','',0);
$pdf->Cell(58,5,$c,'R',0);
$pdf->Cell(60,5,$d,'R',1);

$pdf->SetFont('Times','B','10');
$pdf->Cell(132,5,'Permintaan pembebasan instalasi diterima pada pukul:','L,R,B',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(30,5,'Operator GITET','B',0);
$pdf->Cell(2,5,':','B',0);
$pdf->Cell(58,5,$c,'R,B',0);
$pdf->Cell(60,5,$d,'R,B',1);
}
endforeach;
}
endforeach;

$pdf->SetFont('Times','B','10');
$pdf->Cell(132,5,'Aliran daya pada installasi menjelang dibebaskan:','L,R',0);
$pdf->Cell(110,5,'Aliran daya pada installasi menjelang dinormalkan:','L,R',0);
$pdf->SetTextColor(255,0,0);
$pdf->Cell(40,5,'Kelengkapan Dokumen:','L,R',1);
$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Times','B','10');
$pdf->Cell(35,5,'Pembacaan SCADA :','L',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(97,5,' ........MW, ........MVar, ........Ampere, ........kV','R',0);
$pdf->SetFont('Times','B','10');
$pdf->Cell(35,5,'Pembacaan SCADA :','L',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(75,5,' ........MW, ........MVar, ........Ampere, ........kV','R',0);
$pdf->SetTextColor(255,0,0);
$pdf->Cell(27,5,'Working Permit','',0);
$pdf->Cell(4,4,'','R,L,T,B',0);
$pdf->Cell(9,5,'','R',1);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','B','10');
$pdf->Cell(35,5,'Hasil Studi DPF        :','L',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(97,5,' ........MW, ........MVar, ........Ampere, ........kV','R',0);
$pdf->SetFont('Times','B','10');
$pdf->Cell(35,5,'Hasil Studi DPF        :','L',0);
$pdf->SetFont('Times','','10');
$pdf->Cell(75,5,' ........MW, ........MVar, ........Ampere, ........kV','R',0);
$pdf->SetTextColor(255,0,0);
$pdf->Cell(27,5,'IK','',0);
$pdf->Cell(4,4,'','R,L,T,B',0);
$pdf->Cell(9,5,'','R',1);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','B','10');
$pdf->Cell(242,5,'Ket : Lampirkan hasil print out DPF serta cantumkan alasan apabila DPF tidak bisa digunakan','L,R,T,B',0);
$pdf->SetFont('Times','','10');
$pdf->SetTextColor(255,0,0);
$pdf->Cell(27,5,'K3','B',0);
$pdf->Cell(4,4,'','R,L,T,B',0);
$pdf->Cell(9,5,'','R,B',1);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','B','12');
$pdf->Cell(110,5,'','',0);
$pdf->Cell(84,5,'MANUVER PEMBEBASAN INSTALLASI','L,R,B',0,'C');
$pdf->Cell(88,5,'MANUVER PENORMALAN INSTALLASI','R,B,L',1,'C');
$pdf->Cell(110,40,'','R',0);
$pdf->Cell(84,40,'','R',0);
$pdf->Cell(88,40,'','R',1);

$pdf->SetFont('Times','B','10');
$pdf->SetTextColor(0,0,0);
$pdf->Image('img/'.$isi['foto'],10,71,-300);
$pdf->Image('img/'.$isi['foto2'],10,135,-300);

$pdf->SetFont('Arial','','9');
$pdf->Cell(110,5,'Pelaksana Manuver Pembebasan','R',0,'L');
$pdf->Cell(84,5,'','R',0);
$pdf->Cell(88,5,'','R',1);
$pdf->Cell(110,10,'','R',0,'L');
$pdf->Cell(84,10,'','R',0,'L');
$pdf->Cell(88,10,'','R',1);

$pdf->Cell(110,5,'   Dispatcher        AMN ORT','R',0,'L');
$pdf->Cell(84,5,'','R',0);
$pdf->Cell(88,5,'','R',1);

$pdf->SetTextColor(255,0,0);
$pdf->Cell(110,20,'','R');
$pdf->Cell(84,20,'','R'); 
$pdf->Cell(88,20,'','R',1,'C');

$pdf->Cell(110,5,'','R');//1
$pdf->Cell(84,5,'Catatan: '.substr($isi['catatan_pra_pembebasan'],0,40),'R'); 
$pdf->Cell(88,5,'Catatan: '.substr($isi['catatan_pra_penormalan'],0,44),'R',1);

$pdf->Cell(110,5,'','R');//2
$pdf->Cell(12,5,'','');
$pdf->Cell(72,5,substr($isi['pekerjaan'],40,40),'R,');
$pdf->Cell(12,5,'','');
$pdf->Cell(76,5,substr($isi['pekerjaan'],43,45),'R',1);

$pdf->Cell(110,5,'','R');//3
$pdf->Cell(12,5,'','');
$pdf->Cell(72,5,substr($isi['pekerjaan'],80,40),'R');
$pdf->Cell(12,5,'','');
$pdf->Cell(76,5,substr($isi['pekerjaan'],90,45),'R',1);

$pdf->SetTextColor(0,0,0);
$pdf->Cell(110,5,'','R');
$pdf->Cell(84,5,'','R'); 
$pdf->Cell(88,5,'Dibuat Oleh','R',1,'C');
$pdf->Cell(110,5,'','R');
$pdf->Cell(84,5,'','R'); 
$pdf->Cell(88,5,'','R',1,'C');
$pdf->Cell(110,5,'','R');
$pdf->Cell(84,5,'','R'); 
$pdf->Cell(88,5,$isi['user'],'R',1,'C');
$pdf->Cell(110,5,'','R');
$pdf->Cell(84,5,'','R'); 
$pdf->Cell(88,2,'AE RORT LUR','R',1,'C');
$pdf->Cell(110,2,'Pelaksana Manuver Penormalan','');
$pdf->Cell(84,2,'','L'); 
$pdf->Cell(44,5,'Diperikasa Oleh','L',0,'C');
$pdf->Cell(44,5,'Disetujui Oleh','R',1,'C');

$pdf->Cell(110,5,'','R');
$pdf->Cell(84,5,'','R'); 
$pdf->Cell(88,5,'','R',1,'C');

$pdf->Cell(110,2,'','R');
$pdf->Cell(84,2,'','R'); 
$pdf->Cell(44,5,'('.$isi['user_amn'].')','L',0,'C');
$pdf->Cell(44,5,'('.$isi['user_msb'].')','R',1,'C');


$pdf->Cell(110,5,'   Dispatcher        AMN ORT','R',0,'L');
$pdf->Cell(84,5,'','R,B'); 
$pdf->Cell(44,5,'MSB DALOP','L,B',0,'C');
$pdf->Cell(44,5,'AMN RORT','R,B',1,'C');



$pdf->SetFont('Arial','','8');
//TABLA 1
$header = array('Lokasi', 'Remote', 'Real','ADS', 'Installasi');
$data = [];

$data = mysqli_query($conn2,"SELECT lokasi,remote_,real_,ads,installasi FROM db_table_2 WHERE id_form=2");
$pdf->BasicTable($header, $data, 123, 77);
$pdf->Ln(5);

$data2 = mysqli_query($conn,"SELECT emergency_bebas FROM db_form WHERE id= $_GET[id]");
// $data2 = unserialize($data2);

//$pdf= new FPDF();
//$pdf->AddPage();
$pdf->SetFont('Arial', "", 10);
$pdf->Ln();
$fruits=["apple", "Strawberry", "Banana"];
$animals=['Lion', 'Camel', 'Dog'];
$numbers=[1,2,3];

$i = 0;
while ($i < count($fruits))
{
    $pdf->Cell(35, 8, $numbers[$i]);
    $pdf->Cell(35, 8, $fruits[$i]);
    $pdf->Cell(35, 8, $animals[$i]);
    // Insert a line break at the end of each row.
    $pdf->Ln();
    $i++;
}
$pdf->output();



//TABLA 2
$header = array('Lokasi', 'Remote', 'Real','ADS', 'Installasi');
$data1 = [];
//$data1 = mysqli_query($conn,"SELECT lokasi,remote,real_,ads,installasi FROM db_table_3 WHERE id_form=$_GET[id]");
//$pdf->BasicTable($header, $data1 , 214,77);
// $pdf->Ln(5);


//TABLA 3





$pdf->Output();
?>
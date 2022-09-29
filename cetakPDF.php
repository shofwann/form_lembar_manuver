<?php
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
require "functions.php";

// $sql=mysqli_query($conn,"SELECT * FROM db_form WHERE id='$_GET[id]'");
// $data=mysqli_fetch_assoc($sql);

$data = query("SELECT * FROM db_form WHERE id='$_GET[id]'")[0];
// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8', 
    'format' => 'A4-L',
    'margin_top' => 5

]);

// Write some HTML code:
$html ="
<head>
<link rel='stylesheet' href='css/stylePDF.css'>

</head>
<body style='font-family: serif; font-size: 10pt;'>
    <h3 style='text-align: center;'>Pedoman Manuver Untuk Pemeliharaan/Perbaikan/Perluasan Installasi/Pengaturan Tegangan</h3>

   
   
    <table style='border-collapse: collapse;'>
        <tr>
            <td class='border' style='width: 500px;'>
                <table >
                    <tr>
                        <td class='top_left' style='font-weight:bold'>Pekerjaan</td>
                        <td class='top_left'>:</td>
                        <td colspan='5' >".$data["pekerjaan"]."</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan='5'></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan='5'></td>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan='5'></td>
                        
                    </tr>
                    <tr>
                        <td style='font-weight:bold'>Lokasi</td>
                        <td>:</td>
                        <td style='width:'>".$data["lokasi"]."</td>
                        <td style='width:70px'></td>
                        <td style='font-weight:bold'>Installasi</td>
                        <td>:</td>
                        <td>".$data["installasi"]."</td>
                    </tr>
                    <tr>
                        <td class='top_left' style='font-weight:bold'>Tanggal</td>
                        <td class='top_left'>:</td>
                        <td colspan='5'>".$dayList[date("D", strtotime($data["date"]))].",".date(" d F Y", strtotime($data["date"]))."</td>
                    </tr>
                    <tr>
                        <td colspan='7' style='font-weight:bold'>Permintaan pembebasan installasi diterima pada pukul :</td>
                        <td></td>
                        <td></td>
                    </tr>
                
                </table>                                                                
            </td>
            <td class='border top_left' style='width: 30%;font-weight:bold'>Manuver Pembebasan
                <table>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <table><tr>";

                            foreach (unserialize($data["emergency_pengawas_bebas"]) ?: [] as $row) :
                                for($j = 0; $j < count($row["lokasiPembebasan"]); $j++){
                                    $html .= "<td style='padding-left: 3px;'>".$row['lokasiPembebasan'][$j]."</td>";
                                }
                            endforeach;
                            
                            $html .= "</tr></table>
                        
                        
                        </td>
                    </tr>
                    <tr>
                        <td>Pengawas Pekerjaan</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Pengawas Manuver</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Pengawas K3</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Supervisor GITET</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Operator GITET</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </table>
               
            </td>
            <td class='border top_left' style='width: 25%;font-weight:bold' colspan='2'>Manuver Penormalan
                <table>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <table><tr>";
                            foreach (unserialize($data["emergency_pengawas_bebas"]) ?: [] as $row) :
                                for($j = 0; $j < count($row["lokasiPembebasan"]); $j++){
                                    $html .= "<td style='padding-left: 3px;'>".$row['lokasiPembebasan'][$j]."</td>";
                                }
                            endforeach;
                    $html .=  "</tr></table>                       
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class='border' style='width: 500px;font-weight:bold'> Aliran daya pada installasi menjelang dibebaskan :
                <table>
                    <tr>
                        <td>Pembacaan SCADA</td>
                        <td>:</td>
                        <td>........MW, ........MVar, ........Ampere, ........kV </td>
                    </tr>
                    <tr>
                        <td>Hasil Studi DPF</td>
                        <td>:</td>
                        <td>........MW, ........MVar, ........Ampere, ........kV </td>
                    </tr>
                </table>
            </td>
            <td class='border' style='width: 250px;font-weight:bold' colspan='2'> Aliran daya pada installasi menjelang dinormalkan :
                <table>
                    <tr>
                        <td>Pembacaan SCADA</td>
                        <td>:</td>
                        <td>........MW, ........MVar, ........Ampere, ........kV </td>
                    </tr>
                    <tr>
                        <td>Hasil Studi DPF</td>
                        <td>:</td>
                        <td>........MW, ........MVar, ........Ampere, ........kV </td>
                    </tr>
                </table>
            </td>
            <td rowspan='2' style='border:1px solid black'>Kelengkapan Document
                <table >
                    <tr>
                        <td style='width:60px;'>WP      </td>
                        <td style='border:1px solid black;width:18px;'></td>
                    </tr>
                    <tr>
                        <td>IK</td>
                        <td style='border:1px solid black;width:18px;'></td>
                    </tr>
                    <tr>
                        <td>K3</td>
                        <td style='border:1px solid black;width:18px;'></td>
                       
                    </tr>
                
                </table>
                          
            </td>
        </tr>
        <tr>
            <td class='border' style='width: 500px;font-weight:bold' colspan='3'> Ket : Lampirkan hasil print out DPF serta cantumkan alasan apabila DPF tidak bisa digunakan 
            </td>
        </tr>
    </table>
    
 
    <table style='table-layout: auto;'>
        <tr>
            <td class='border' style='font-size:60px'><h2>MANUVER PEMBEBASAN INSTALLASI</h2> 
                <table class='border' style='font-size:60px;padding:5px;'>
                    <tr>
                        <th class='border' style='height: 70px;' >Lokasi</th>
                        <th class='border' >Remote</th>
                        <th class='border' >Real</th>
                        <th class='border' >ADS</th>
                        <th class='border' >Installasi</th>
                    </tr>";
                    foreach (unserialize($data["emergency_bebas"])  ? : []  as $row) :
                        for($j = 0; $j < count($row["lokasiManuverBebas"]); $j++){
                            $html .= 
                            "<tr>
                                <td class='border'>".$row['lokasiManuverBebas'][$j]."</td>
                                <td class='border'></td>
                                <td class='border'></td>
                                <td class='border'></td>
                                <td class='border'>".$row['installManuverBebas'][$j]."</td>
                            </tr>";
                        }
                    endforeach;
                
            $html.=" </table>
            </td>
            <td class='border' style='font-size:60px'><h2>MANUVER PENORMALAN INSTALLASI</h2>
                    <table class='border' style='font-size:60px;'>
                    <tr>
                        <th class='border' >Lokasi</th>
                        <th class='border' >Remote</th>
                        <th class='border' >Real</th>
                        <th class='border' >ADS</th>
                        <th class='border' >Installasi</th>
                        </tr>";
                        foreach (unserialize($data["emergency_normal"])  ? : []  as $row) :
                            for($j = 0; $j < count($row["lokasiManuverNormal"]); $j++){
                                $html .= 
                                "<tr>
                                    <td class='border'>".$row['lokasiManuverNormal'][$j]."</td>
                                    <td class='border'></td>
                                    <td class='border'></td>
                                    <td class='border'></td>
                                    <td class='border'>".$row['installManuverNormal'][$j]."</td>
                                </tr>";
                            }
                        endforeach;
                    
                $html.=" </table>
            
            </td>
        </tr>
    
    </table>
    <table>
    <tr>
    <td class='border' style='text-align:center;'> <img src='img/".$data["foto"]."'  width='350'></td>
    <td class='border' style='text-align:center;'> <img src='img/".$data["foto2"]."'  width='350'></td>
    
    </tr>
    </table>

   
    
   
    
</body>


";
$mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
$mpdf->Output();
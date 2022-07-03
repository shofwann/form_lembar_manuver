<?php

$idnya = $_POST["idForm"];

?>


<?php if ($idnya == 1) { ?>
   <br>
    <div class="flex-container">
        <div class="grid-item titel">Lokasi</div>
        <div class="grid-item titel">Manuver Pembebasan</div>
        <div class="grid-item titel">Manuver Penormalan</div>
        <div class="grid-item">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th >Lokasi</th>
                    </tr>
                </thead>
                <tbody id="tableBody1">
                    
                </tbody>
            </table>
            <div class="form-button">
                <button type="button" id="add1" class="btn btn-success" onclick="tambah1()">+</button>
                <button type="button" id="remove1" class="btn red" onclick="kurang1()">-</button> 
            </div>
        </div>
        <div class="grid-item">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Lokasi</th>
                        <th>Installasi</th>
                    </tr>
                </thead>
                <tbody id="tableBody2">
                    
                </tbody>
            </table>
                <button type="button" id="add2" class="btn btn-success" onclick="tambahRow(0,'lokasiManuverBebas[]','installManuverBebas[]','tableBody2',0)">+</button>
                <button type="button" id="remove2" class="btn red" onclick="kurangRow('tableBody2')">-</button> 
        </div>
        <div class="grid-item">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Lokasi</th>
                        <th>Installasi</th>
                    </tr>
                </thead>
                <tbody id="tableBody3">
                    
                </tbody>
            </table>
                <button type="button" id="add3" class="btn btn-success" onclick="tambahRow(0,'lokasiManuverNormal[]','installManuverNormal[]','tableBody3',0)">+</button>
                <button type="button" id="remove3" class="btn red" onclick="kurangRow('tableBody3')">-</button> 
        </div>   
    </div>

    
<?php } else { ?>
    <br>
    <div class="flex-container">
        <div class="grid-item titel">Lokasi</div>
        <div class="grid-item titel">Manuver Pembebasan</div>
        <div class="grid-item titel">Manuver Penormalan</div>
        <div class="grid-item">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th >Lokasi</th>
                    </tr>
                </thead>
                <tbody id="tableBody1">
                    
                </tbody>
            </table>
            <div class="form-button">
                <button type="button" id="add1" class="btn btn-success" onclick="tambah1('tableBody1',i)">+</button>
                <button type="button" id="remove1" class="btn red" onclick="kurang1()">-</button> 
            </div>
        </div>
        <div class="grid-item">
            <div class="flex-container-sub">
                <div class="grid-item " style="">
                    <input type="text" name="titelBebas[]" id="">
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th style="width:33%">No</th>
                                <th style="width:33%">Lokasi</th>
                                <th style="width:33%">Installasi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody2">
                            
                        </tbody>
                    </table>
                        <button type="button" id="add2" class="btn btn-success" onclick="tambahRow(0,'lokasiManuverBebas[]','installManuverBebas[]','tableBody2','idBebas[]')">+</button>
                        <button type="button" id="remove2" class="btn btn-danger" onclick="kurangRow('tableBody2')">-</button>
                </div>
                <div class="grid-item form2" >
                    <button type="button" onclick="tambahForm(0,'copyForm1','titelBebas[]','lokasiManuverBebas[]','installManuverBebas[]','tableBody2','idBebas[]','openBebas')">+</button>
                </div>
            </div>
            
            <div id="copyForm1">

            </div>


             
        </div>
        <div class="grid-item">
            <div class="flex-container-sub">
                <div class="grid-item " style="">
                    <input type="text" name="titelNormal[]" id="">
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th style="width:33%">No</th>
                                <th style="width:33%">Lokasi</th>
                                <th style="width:33%">Installasi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody3">
                            
                        </tbody>
                    </table>
                        <button type="button" id="add2" class="btn btn-success" onclick="tambahRow(0,'lokasiManuverNormal[]','installManuverNormal[]','tableBody3','idNormal[]')">+</button>
                        <button type="button" id="remove2" class="btn btn-danger" onclick="kurangRow('tableBody3')">-</button>
                </div>
                <div class="grid-item form2" >
                    <button type="button" onclick="tambahForm(0,'copyForm2','titelNormal[]','lokasiManuverNormal[]','installManuverNormal[]','tableBody3','idNormal[]','openNormal')">+</button>
                </div>
            </div> 
            <div id="copyForm2">

            </div>
        </div>   
    </div>
<?php } ?>

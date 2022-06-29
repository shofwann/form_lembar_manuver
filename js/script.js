

let tableRed1 = document.querySelectorAll('#dynamic_field1 td');
let tablered2 = document.querySelectorAll('#dynamic_field2 td');



if (tableRed1 != null) {
    for (let i = 0; i<tableRed1.length; i++) {
        if (tableRed1[i].innerHTML.toLowerCase().slice(-3) == "tag" ) {
            tableRed1[i].parentElement.children[1].style.color = "red";
            tableRed1[i].parentElement.children[5].style.color = "red"; 
        } 
    }
}

if (tablered2 != null) {
    for (let i = 0; i<tablered2.length; i++) {
        if (tablered2[i].innerHTML.toLowerCase().slice(-3) == "tag" ) {
            tablered2[i].parentElement.children[1].style.color = "red";
            tablered2[i].parentElement.children[5].style.color = "red";
            
        } 
    }

}

//=================pop up modal=================================

var modalBtn = document.querySelectorAll(".modal-open");

modalBtn.forEach(function (btn){
    btn.onclick = function() {
        var modal = btn.getAttribute("data-modal");
        document.getElementById(modal).style.display="block";
    };
});

var closeBtn = document.querySelectorAll(".modal-close");

closeBtn.forEach(function (btn){
    btn.onclick = function(){
        var modal= btn.closest(".modal").style.display="none";
    };
});

window.onclick = function(e) {
    if (e.target.className === "modal"){
        e.target.style.display = "none";
    }
};



 function kurang() {
    let jumlahRow = document.getElementById('table1').rows.length-1;
    // let jumlahRow2 = document.getElementById('table2').rows.length-1;
    table = document.getElementById('table1').children[jumlahRow--].children[0].children[1];
    if (table.value != "0" ){
    id_hapus = table.cloneNode(true);
        id_hapus.setAttribute("name","id_ajax_hapus_petugas[]");
        document.getElementById("form_id").appendChild(id_hapus);
    }
    
    // table2 = document.getElementById('table2').children[jumlahRow2--].children[0];

    table.parentElement.parentElement.remove();
    // table2.parentElement.parentElement.remove();
}

 function tambah() {
    let table = document.getElementById('table1');
    let row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);

    cell1.innerHTML = "<input type='text' name='lokasiPembebasan[]'><input type='text' name='id_update_petugas[]' style='' value='0' >";
    cell2.innerHTML = "";
    cell3.innerHTML = "";
    cell4.innerHTML = "";
    cell5.innerHTML = "";
    cell6.innerHTML = "";

    // let table1 = document.getElementById('table2');
    // var row1 = table1.insertRow(-1);
    // var cell7 = row1.insertCell(0);
    // var cell8 = row1.insertCell(1);

    // cell7.innerHTML = "<input type='text' name=spvPenormalan[] id='' style='width:140px;border:1px solid #fff;'>";
    // cell8.innerHTML = "<input type='text' name=oprPenormalan[] id='' style='width:140px;border:1px solid #fff;'>";
}









tableManuver1 = document.getElementById('dynamic_field1');
if(tableManuver1){
    jumlah_baris = tableManuver1.rows.length-1;
}


tableManuver2 = document.getElementById('dynamic_field2');
if(tableManuver2){
    jumlah_baris2 = tableManuver2.rows.length-1;
}


// jumlah_sub_row = document.getElementById('sub_dynamic_field1').getElementsByTagName('tr').length;
// var idRow = document.querySelectorAll("#sub_dynamic_field1 tr");
// for (let i=0; i<jumlah_sub_row; i++) {
//     idRow[i].setAttribute('id','row');
// }

// var k = 0;
// lengthRows = document.getElementById('sub_dynamic_field1').getElementsByTagName('tr').length;
// function generateIndex() {
//     lengthRows = document.querySelector('#sub_dynamic_field1 tr').length;
//     return lengthRows;
// }

function tambahManuver(a,b,c,d,e,f,g,h) {
   
    table = document.getElementById(a);
    var row = table.insertRow(-1);
    row.setAttribute("id","row");
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);

    cell1.innerHTML = e++;
    cell2.innerHTML = "<input type='text' name='"+b+"' placeholder='lokasi' style='width:8rem;padding:0rem;'>";
    cell3.innerHTML = "<input type='time' name='"+f+"' class='disabled'>";
    cell4.innerHTML = "<input type='time' name='"+g+"' class='disabled' >";
    cell5.innerHTML = "<input type='time' name='"+h+"' class='disabled' >";
    cell6.innerHTML = "<input type='text' name='"+c+"' placeholder='installasi' style='width:8rem;padding:0rem;'>";
    cell7.innerHTML = "<button type='button' onclick='hapus_baris_new(this)' class='btn btn-danger btn_remove'>Remove</button><input type='text' name='"+d+"' value='0' hidden>";

    const disabled = document.querySelectorAll('.disabled');
   
   if ( level != 'dispa' ){
       for (i=0; i<disabled.length; i++){
           disabled[i].style.display = 'none';
       } 

   }
    
}

function hapus_baris(a,b) {
    baris = a.parentElement.parentElement
    if (baris.children[6].children[1].value != "0"){
        id_hapus = baris.children[6].children[1].cloneNode(true);
        id_hapus.setAttribute("name", ""+b+"");
        document.getElementById("form_id").appendChild(id_hapus);
        
    
    }
    baris.remove();

    const cells = document.querySelectorAll("#dynamic_field1 tbody td:first-child");
    for (const i in cells) {
        cells[i].innerText = (parseInt(i) + 1).toString();
    }

}


//hapus row kondisi id masih 0
function hapus_baris_new(tombol) {
    baris = tombol.parentElement.parentElement
    baris.remove();
}

//===================================dynamic form=================================================
const fileInput = document.querySelectorAll('input[type=file]'); 
fileInput.forEach(input => { 
    input.addEventListener('change', e => { 
        const imageElement = e.target.previousElementSibling.previousElementSibling; 
        console.log(imageElement); 
        const imageURL = URL.createObjectURL(e.target.files[0]); 
        imageElement.src = imageURL; 
    }); 
});

var k=0;
// let i=1;
// let j=0;


function tambahFormRow(h,i,j,k) {
    //j++;
    const id = h === 0 ? ''+i+'':`${i}${h}`
    let table = document.getElementById(id); //tangkap id
    const newRow = document.createElement('tr');  // buat elemen tr
    const existingRows = table.querySelectorAll('tr'); // untuk menghitung jumlah row
    newRow.innerHTML = `<td>${existingRows.length + 1}</td><td><input type='text' name='${j}'></td><td></td><td></td><td></td><td><input type='text' name='${k}'></td><td><button type='button' class='btn red' onclick='kurangFormRow(this)'>Remove</button><input type='' name='id_bebas[]' value='${h}'></td>`;

    table.appendChild(newRow);
}

function kurangFormRow(ini){
    const row = ini.parentElement.parentElement;
    const table = ini.parentElement.parentElement.parentElement;
    row.remove();
    const existingRows = table.querySelectorAll('tr');
    existingRows.forEach((row, idx) => {
        row.childNodes[0].innerText = idx + 1;
    });
}

function tambahForm(j,i,l,m,n,o){
    k++;
    form = document.createElement('div');
    form.innerHTML = `<div class='container-fluid'><div class='grid-item'><img id='output${k}' height='auto' width='350px'><br><input type='file' accept='image/*' name='${l}'></div><div class='grid-item'><label>Masukkan Titel</label><br><input type='text' name='${m}' style='font: size 20px; margin-bottom:10px;'><table><thead><tr><th rowspan='2' style='padding-top:35px;width:4rem'>No.</th><th rowspan='2' style='width:7rem;text-align:center;padding-top:35px'>Lokasi</th><th colspan='3'style='width:9rem;text-align:center'>Jam Manuver Buka</th><th rowspan='2'style='padding-top:35px;width:9rem;'>Installasi</th><th rowspan='2'><button type='button' class='btn green' onclick="tambahFormRow(${k},'${j}','${n}','${o}')">Add More</button></th></tr><tr><th style='width:9rem;'>Remote</th><th style='width:9rem;'>Real (R/L)</th><th style='width:9rem;'>ADS</th></tr></thead><tbody id='${j}${k}'></tbody></table></div><div class='grid-item'><button type='button' class='btn reed' onclick='kurangForm(this)'>-</button></div></div>`;
    document.getElementById(i).appendChild(form);
    form.querySelector('input[type=file]').addEventListener('change', e => { 
        const imageElement = e.target.previousElementSibling.previousElementSibling; 
        console.log(imageElement); 
        const imageURL = URL.createObjectURL(e.target.files[0]); 
        imageElement.src = imageURL; 
    }); 
}

function kurangForm(ini){
    row = ini.parentElement.parentElement;
    row.remove();
}


function tambahRowNormal(g) {
    //j++;
    const id = g === 0 ? `dynamic_form2`:`dynamic_form2${g}`
    let table = document.getElementById(id);
    const newRow = document.createElement('tr');
    const existingRows = table.querySelectorAll('tr');
    console.log(existingRows.length + 1)
    newRow.innerHTML = `<td>${existingRows.length + 1}</td><td><input type='text' name='lokasiManuverNormal[]'></td><td></td><td></td><td></td><td><input type='text' name='lokasiManuverNormal[]'></td><td><button type='button' class='btn red' onclick='kurangFormRow(this)'>Remove</button><input type='' name='id_normal[]' value='${g}'></td>`;

    table.appendChild(newRow);
}

var q=0;
function tambahFormNormal() {
    q++;
    form =  document.createElement('div');
    form.innerHTML = `<div class='container-fluid'><div class='grid-item'><img id='output${q}' height='auto' width='350px'><br><input type='file' accept='image/*' name='fotoNormal[]'></div><div class='grid-item'><label>Masukkan Titel</label><br><input type='text' name='titelNormal[]' style='font: size 20px; margin-bottom:10px;'><table><thead><tr><th rowspan='2' style='padding-top:35px;width:4rem'>No.</th><th rowspan='2' style='width:7rem;text-align:center;padding-top:35px'>Lokasi</th><th colspan='3'style='width:9rem;text-align:center'>Jam Manuver Buka</th><th rowspan='2'style='padding-top:35px;width:9rem;'>Installasi</th><th rowspan='2'><button type='button' class='btn green' onclick="tambahRowNormal(${q})">Add More</button></th></tr><tr><th style='width:9rem;'>Remote</th><th style='width:9rem;'>Real (R/L)</th><th style='width:9rem;'>ADS</th></tr></thead><tbody id='dynamic_form2${q}'></tbody></table></div><div class='grid-item'><button type='button' class='btn reed' onclick='kurangForm(this)'>-</button></div></div>`;
    document.getElementById('copy2').appendChild(form);
    form.querySelector('input[type=file]').addEventListener('change', e => { 
        const imageElement = e.target.previousElementSibling.previousElementSibling; 
        console.log(imageElement); 
        const imageURL = URL.createObjectURL(e.target.files[0]); 
        imageElement.src = imageURL; 
    }); 
}

// function kurangRowNormal(ini){
//     const row = ini.parentElement.parentElement;
//     const table = ini.parentElement.parentElement.parentElement;
//     row.remove();
//     const existingRows = table.querySelectorAll('tr');
//     existingRows.forEach((row, idx) => {
//         row.childNodes[0].innerText = idx + 1;
//     });
// }


// ======================================autocomplete nama GITET

let namaGitet = [
    "Srlya",
    "Srlyu",
    "Bnten",
    "Cwang",
    "Bkasi",
    "Priok",
    "Clgon",
    "Bjnra",
    "Lgkng",
    "Gndul",
    "Kmban",
    "Drkbi",
    "Blrja",
    "Depok",
    "Tmbun",
    "Cbing",
    "Mtwar",
    "Crata",
    "Bdsln",
    "Sglng",
    "Clmya",
    "Sktni",
    "Tasik",
    "Idmyu",
    "Dtmas",
    "Ksghn",
    "Mdcan",
    "Ujbrg",
    "Adpla",
    "Clcap",
    "Ungrn",
    "Pmlng",
    "Btang",
    "Ngbng",
    "Pedan",
    "Tjati",
    "Sbbrt",
    "Kdiri",
    "Tjbru",
    "Grati",
    "Grsik",
    "Piton",
];

let sortNames = namaGitet.sort();

// =================================mengecek apakah id tersebut exsis================================
let varlevel = document.getElementById('level');
if (varlevel != null){
    level = varlevel.value;
}

let varStatus = document.getElementById('statusJob');
if (varStatus != null ){
    statusJob = varStatus.value;
}

// =======================================================================================================
function tambah(){
    table = document.getElementById("table1");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);

   cell1.innerHTML = `<input type='text' name='lokasiPembebasan[]' placeholder='nama lokasi' autocomplete='off'>`;
   cell2.innerHTML = `<input type='text' name='peng_pekerjaan[]' placeholder='nama pengawas' class='disabled' autocomplete='off'>`;
   cell3.innerHTML = `<input type='text' name='peng_manuver[]' placeholder='nama pengawas' class='disabled' autocomplete='off'>`;
   cell4.innerHTML = `<input type='text' name='peng_k3[]' class='disabled' placeholder='nama pengawas' autocomplete='off'>`;
   cell5.innerHTML = `<input type='text' name='spv[]' class='disabled' placeholder='nama SPV' autocomplete='off'>`;
   cell6.innerHTML = `<input type='text' name='opr[]' class='disabled' placeholder='nama Operator' autocomplete='off'>`;

   table1 = document.getElementById("table2");
   var row1 = table1.insertRow(-1);
   var cell7 = row1.insertCell(0);
   var cell8 = row1.insertCell(1);

   cell7.innerHTML = "<input type='text' name=spvPenormalan[] id='' disabled>";
   cell8.innerHTML = "<input type='text' name=oprPenormalan[] id='' disabled>";

   const disabled = document.querySelectorAll('.disabled');
   
   if ( level != 'dispa' ){
       for (i=0; i<disabled.length; i++){
           disabled[i].style.display = 'none';
       } 

   }
}



function kurang(){
    table = document.getElementById("table1");
    row = table.getElementsByTagName('tr');
    if (row.length!='0'){
        row[row.length - 1].outerHTML='';
    }
    table = document.getElementById("table2");
    row = table.getElementsByTagName('tr');
    if (row.length!='0'){
        row[row.length - 1].outerHTML='';
    }

}



let destination = ["Italy", "Spain", "Portugal", "Brazil"];

function tambahBaris(a,b,c,aa,bb,cc) {
    let table = document.getElementById(a);
    const newRow = document.createElement('tr');
    const existingRows = table.querySelectorAll('tr');
    newRow.innerHTML = `<td>${existingRows.length + 1}</td><td><input type="text" class="inputNew" placeholder="lokasi" name="`+b+`" id="inputNew" autocomplete="on"></td><td><input type="time" class="disableManuver" name="`+aa+`"></td><td><input type="time" class="disableManuver" name="`+bb+`"></td><td><input type="time" class="disableManuver" name="`+cc+`"></td><td><input type="text" name="`+c+`" placeholder="installasi" id=""></td><td><button type='button' class='btn red' onclick='kurangBaris(this)'>Remove</button></td>`;
    table.appendChild(newRow);

    const disableManuver = document.querySelectorAll('.disableManuver');
    if (level != 'dispa'){
        for (i=0; i<disableManuver.length; i++){
            disableManuver[i].style.display = 'none';
        }
    }

    const disableManuverBebas = document.querySelectorAll('#dynamic_field2 tr td .disableManuver');
    if(statusJob == '') {
        for (i=0; i<disableManuverBebas.length; i++){
            disableManuverBebas[i].style.display = 'none';
        }

    }

   
}




function kurangBaris(ini) {
    const row = ini.parentElement.parentElement;
    const table = ini.parentElement.parentElement.parentElement;
    row.remove();
    const existingRows = table.querySelectorAll('tr');
    
    existingRows.forEach((row, idx) => {
        row.childNodes[0].innerText = idx + 1;
    });

}

function hapus_baris_emergency(a) {
    let baris = a.parentElement.parentElement;
    baris.remove();
}

var user,
element = document.getElementById('user');
if(element != null){
    user = element.value;
} else {
    str = null;
}

if (user === ''){
    const varEmergency = document.querySelectorAll("#emergency");
    for (i=0; i<varEmergency.length; i++){
        varEmergency[i].innerText = 'emergency'
        varEmergency[i].style.color = 'red'
    
    }

}


var y = document.getElementById('check')


let jumCheck = document.querySelectorAll('.fa-times').length;
for (i=0; i <jumCheck; i++) {
    document.querySelectorAll('.fa-times')[i].style.display = 'none';
}
if(y) {
    y.addEventListener('change', function(){
        if (y.checked == true) {
            //document.getElementById('verdict').innerHTML = 'berangkat';
            for (i=0; i <jumCheck; i++) {
                document.querySelectorAll('.fa-times')[i].style.display = "";
            }
        } else {
            //document.getElementById('verdict').innerHTML = 'pulang';
            for (i=0; i <jumCheck; i++) {
                document.querySelectorAll('.fa-times')[i].style.display = "none";
    
            }
        }
        });
}

let id = document.getElementById('submit')

if (id){

    id.style.display = 'none'
}



// const toggleModal = () => {
//     document.querySelector('.modal').classList.toggle('modal--hidden');
//     document.querySelector('.overlay').classList.toggle('overlay--hidden');
// }
//     document.querySelector('#show-modal').addEventListener('click', toggleModal);
    
//     document.querySelector('.overlay').addEventListener('click', toggleModal);
    
//     document.querySelector('#learn-more-form').addEventListener('submit', (e) => {
//     e.preventDefault();
//     toggleModal();
//     });
    
//     document.querySelector('.modal__close-bar span').addEventListener('click', toggleModal);
//     document.querySelector('.overlay').addEventListener('click', toggleModal);
      


function showHide1() {
    var x = document.getElementById("curPass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
}

function showHide2() {
    var x = document.getElementById("newPass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
}

function showHide3() {
    var x = document.getElementById("conPass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
}






let table = document.querySelectorAll('#dynamic_field1 td');
let table2 = document.querySelectorAll('#dynamic_field2 td');

if (table != null) {
    for (let i = 0; i<table.length; i++) {
        if (table[i].innerHTML.toLowerCase().slice(-3) == "tag" ) {
            table[i].parentElement.children[1].style.color = "red";
            table[i].parentElement.children[5].style.color = "red"; 
        } 
    }
}

if (table2 != null) {
    for (let i = 0; i<table2.length; i++) {
        if (table2[i].innerHTML.toLowerCase().slice(-3) == "tag" ) {
            table2[i].parentElement.children[1].style.color = "red";
            table2[i].parentElement.children[5].style.color = "red";
            
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

//==========================tabel manipulasi====================================
// let row1 = document.querySelector("#table1").getElementsByTagName("tr");
// const jumRow = row1.length;

// let row2 = document.querySelector("#table2");

// for (let i = 0; i < jumRow; i++) {
//     // di sini code buat nambah row di table 2
//     tableRow = row2.insertRow(0);
//     cell1 = tableRow.insertCell(0);
//     cell2 = tableRow.insertCell(1);
//     cell1.innerHTML = "";
//     cell2.innerHTML = "";
//  }




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
jumlah_baris = tableManuver1.rows.length-1;

tableManuver2 = document.getElementById('dynamic_field2');
jumlah_baris2 = tableManuver2.rows.length-1;


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

function tambahManuver(a,b,c,d,e) {
   
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
    cell2.innerHTML = "<input type='text' name='"+b+"' style='width:8rem;padding:0rem;'>";
    cell3.innerHTML = "";
    cell4.innerHTML = "";
    cell5.innerHTML = "";
    cell6.innerHTML = "<input type='text' name='"+c+"' style='width:8rem;padding:0rem;'>";
    cell7.innerHTML = "<button type='button' onclick='hapus_baris_new(this)' class='btn btn-danger btn_remove'>X</button><input type='text' name='"+d+"' value='0' >";
    
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

function tambahRowBebas(h) {
    //j++;
    const id = h === 0 ? 'dynamic_form1':`dynamic_form1${h}`
    let table = document.getElementById(id);
    const newRow = document.createElement('tr');
    const existingRows = table.querySelectorAll('tr');
    newRow.innerHTML = `<td>${existingRows.length + 1}</td><td><input type='text' name='lokasiManuverBebas[]'></td><td></td><td></td><td></td><td><input type='text' name='lokasiManuverBebas[]'></td><td><button type='button' class='btn red' onclick='kurangRowBebas(this)'>Remove</button></td>`;

    table.appendChild(newRow);
}

function kurangRowBebas(ini){
    const row = ini.parentElement.parentElement;
    const table = ini.parentElement.parentElement.parentElement;
    row.remove();
    const existingRows = table.querySelectorAll('tr');
    existingRows.forEach((row, idx) => {
        row.childNodes[0].innerText = idx + 1;
    });
}

function tambahFormBebas(){
    k++;
    form = document.createElement('div');
    form.innerHTML = "<div class='container-fluid'><div class='grid-item'><img id='output"+k+"' height='auto' width='350px'><br><input type='file' accept='image/*' name='fotoBebas[]'></div><div class='grid-item'><label>Masukkan Titel</label><br><input type='text' name='titel[]' style='font: size 20px; margin-bottom:10px;'><table><thead><tr><th rowspan='2' style='padding-top:35px;width:4rem'>No.</th><th rowspan='2' style='width:7rem;text-align:center;padding-top:35px'>Lokasi</th><th colspan='3'style='width:9rem;text-align:center'>Jam Manuver Buka</th><th rowspan='2'style='padding-top:35px;width:9rem;'>Installasi</th><th rowspan='2'><button type='button' class='btn green' onclick='tambahRowBebas("+k+")'>Add More</button></th></tr><tr><th style='width:9rem;'>Remote</th><th style='width:9rem;'>Real (R/L)</th><th style='width:9rem;'>ADS</th></tr></thead><tbody id='dynamic_form1"+k+"'></tbody></table></div><div class='grid-item'><button type='button' class='btn red' onclick='kurangForm(this)'>-</button></div></div>";
    document.getElementById('copy').appendChild(form);
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

function tambahRowNormal(h) {
    //j++;
    const id = h === 0 ? 'dynamic_form2':`dynamic_form2${h}`
    let table = document.getElementById(id);
    const newRow = document.createElement('tr');
    const existingRows = table.querySelectorAll('tr');
    newRow.innerHTML = `<td>${existingRows.length + 1}</td><td><input type='text' name='lokasiManuverBebas[]'></td><td></td><td></td><td></td><td><input type='text' name='lokasiManuverBebas[]'></td><td><button type='button' class='btn red' onclick='kurangRowBebas(this)'>Remove</button></td>`;

    table.appendChild(newRow);
}

function kurangRowNormal(ini){
    const row = ini.parentElement.parentElement;
    const table = ini.parentElement.parentElement.parentElement;
    row.remove();
    const existingRows = table.querySelectorAll('tr');
    existingRows.forEach((row, idx) => {
        row.childNodes[0].innerText = idx + 1;
    });
}


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

// const parent = document.querySelector('td');
// let ul = 'ini';

// if(parent.childNode.classList.contains('suggest')) {
//     ul = document.querySelector('.suggest');
// }







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


const varEmergency = document.querySelectorAll("#emergency");
for (i=0; i<varEmergency.length; i++){
    varEmergency[i].innerText = 'emergency'
    varEmergency[i].style.color = 'red'

}







// let destination = ["Italy", "Spain", "Portugal", "Brazil"];
// let inputField = document.getElementById('input');
// let ulField = document.getElementById('suggestions');
// inputField.addEventListener('input', changeAutoComplete);
// ulField.addEventListener('click', selectItem);

// function changeAutoComplete({ target }) {
//   let data = target.value;
//   ulField.innerHTML = ``;
//   if (data.length) {
//     let autoCompleteValues = autoComplete(data);
//     autoCompleteValues.forEach(value => { addItem(value); });
//   }
// }


// function autoComplete(inputValue) {
//   return destination.filter(
//     (value) => value.toLowerCase().includes(inputValue.toLowerCase())
//   );
// }

// function addItem(value) {
//   ulField.innerHTML = ulField.innerHTML + `<li class="">${value}</li>`;
// }

// function selectItem({ target }) {
//   if (target.tagName === 'LI') {
//     inputField.value = target.textContent;
//     ulField.innerHTML = ``;
//   }
// }


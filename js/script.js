// let table = document.getElementById('dynamic_field1').getElementsByTagName('td');
// let table2 = document.getElementById('dynamic_field2').getElementsByTagName('td');


// if (table != null) {
//     for (let i = 0; i<table.length; i++) {
//         if (table[i].innerHTML.toLowerCase().slice(-3) == "tag" ) {
//             table[i].parentElement.children[1].style.color = "red";
//             table[i].parentElement.children[5].style.color = "red";
            
            
//         } 
//     }

// }

// if (table2 != null) {
//     for (let i = 0; i<table2.length; i++) {
//         if (table2[i].innerHTML.toLowerCase().slice(-3) == "tag" ) {
//             table2[i].parentElement.children[1].style.color = "red";
//             table2[i].parentElement.children[5].style.color = "red";
            
//         } 
//     }

// }

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
let row1 = document.querySelector("#table1").getElementsByTagName("tr");
const jumRow = row1.length;

let row2 = document.querySelector("#table2");

for (let i = 0; i < jumRow; i++) {
    // di sini code buat nambah row di table 2
    tableRow = row2.insertRow(0);
    cell1 = tableRow.insertCell(0);
    cell2 = tableRow.insertCell(1);
    cell1.innerHTML = "";
    cell2.innerHTML = "";
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

    cell1.innerHTML = "<input type='text' name='lokasiPembebasan[]'><input type='text' name='id_bebas_update[]' style='' value='0' hidden>";
    cell2.innerHTML = "";
    cell3.innerHTML = "";
    cell4.innerHTML = "";
    cell5.innerHTML = "";
    cell6.innerHTML = "";

    let table1 = document.getElementById('table2');
    var row1 = table1.insertRow(-1);
    var cell7 = row1.insertCell(0);
    var cell8 = row1.insertCell(1);

    cell7.innerHTML = "<input type='text' name=spvPenormalan[] id='' style='width:140px;border:1px solid #fff;'>";
    cell8.innerHTML = "<input type='text' name=oprPenormalan[] id='' style='width:140px;border:1px solid #fff;'>";
}

let jumlahRow = document.getElementById('table1').rows.length-1;
function kurang() {
    table = document.getElementById('table1').children[jumlahRow--].children[0].children[1];
    if (table.value != "0" ){
    id_hapus = table.cloneNode(true);
        id_hapus.setAttribute("name","id_hapus0[]");
        document.getElementById("form_id").appendChild(id_hapus);
    }
    
    table.parentElement.parentElement.remove();
}






// tableManuver1 = document.getElementById('dynamic_field1');
// jumlah_baris = tableManuver1.rows.length-1;

// tableManuver2 = document.getElementById('dynamic_field2');
// jumlah_baris2 = tableManuver2.rows.length-1;


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

function tambahManuver(a,b,c) {
   
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

    cell1.innerHTML = jumlah_baris++;
    cell2.innerHTML = "<input type='text' name='"+b+"' style='width:8rem;padding:0rem;'>";
    cell3.innerHTML = "";
    cell4.innerHTML = "";
    cell5.innerHTML = "";
    cell6.innerHTML = "<input type='text' name='"+c+"' style='width:8rem;padding:0rem;'>";
    cell7.innerHTML = "<button type='button' onclick='hapus_baris_new(this)' class='btn btn-danger btn_remove'>X</button><input type='text' name='id_bebas_update2[]' value='0' hidden>";
    
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




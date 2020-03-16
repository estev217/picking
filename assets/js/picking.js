let input = document.getElementById("picking_gencod_gen");
let gencod = document.getElementById("gencod");
let number = document.getElementById("picking_gencod_picking");
// const myForm = document.getElementById("myForm");
let button = document.getElementById("picking_gencod_saveAndNew");

input.addEventListener("change", valueFunction);

function valueFunction() {
    if (input.value === gencod.innerText) {
        number.value = parseInt(number.value) + 1;
    } else {
        alert("mauvais gencod");
    }
}

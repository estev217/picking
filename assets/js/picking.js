let input = document.getElementById("picking_gencod_gen");
let gencod = document.getElementById("gencod");
let number = document.getElementById("picking_gencod_picking");
let button = document.getElementById("picking_gencod_saveAndNew");

input.addEventListener("change", valueFunction);

function valueFunction() {
    if (input.value === gencod.innerText) {
        number.value = parseInt(number.value) + 1;
    } else {
        alert("Mauvais gencod !");
    }
}

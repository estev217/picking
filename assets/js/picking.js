const input = document.getElementById("picking_gencod_saveAndNew");
const gencod = document.getElementById("gencod");
const number = document.getElementById("picking_gencod_picking");
const myForm = document.getElementById("myForm");

input.addEventListener("submit", submitFunction);

function submitFunction() {
    if (input.value === gencod.innerText) {
        number.value++;
    }
}
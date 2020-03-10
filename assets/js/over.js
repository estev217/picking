document.getElementById("commande").addEventListener("focusin", inFunction);

function inFunction() {
    document.getElementById("commande").className = "over";
}

document.getElementById("commande").addEventListener("focusout", outFunction);

function outFunction() {
    document.getElementById("commande").className = "";
}
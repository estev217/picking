document.getElementById("commande").addEventListener("focusin", insideFunction);

function insideFunction() {
    document.getElementById("commande").className = "over";
}

document.getElementById("commande").addEventListener("focusout", outsideFunction);

function outsideFunction() {
    document.getElementById("commande").className = "";
}
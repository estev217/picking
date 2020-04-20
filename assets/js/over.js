document.getElementById("commande").addEventListener("focusin", insideCommandeFunction);
document.getElementById("gencod").addEventListener("focusin", insideGencodFunction);

function insideCommandeFunction() {
    document.getElementById("commande").className = "over";
}

function insideGencodFunction() {
    document.getElementById("gencod").className = "over";
}

document.getElementById("commande").addEventListener("focusout", outsideCommandeFunction);
document.getElementById("gencod").addEventListener("focusout", outsideGencodFunction);

function outsideCommandeFunction() {
    document.getElementById("commande").className = "";
}

function outsideGencodFunction() {
    document.getElementById("gencod").className = "";
}
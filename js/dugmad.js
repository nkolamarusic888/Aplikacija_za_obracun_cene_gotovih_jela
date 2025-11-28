// Funkcija za dodavanje novog reda sastojka
function addSastojak() {
    const container = document.getElementById("sastojci-container");
    const firstRow = container.querySelector(".sastojak-row");
    const newRow = firstRow.cloneNode(true);

    // Očisti vrednosti inputa i select-a
    newRow.querySelectorAll("input, select").forEach(el => el.value = "");

    // Ukloni sve prikazane error poruke
    newRow.querySelectorAll(".error").forEach(e => e.remove());

    container.appendChild(newRow);
}

// Funkcija za uklanjanje reda sastojka
function removeSastojak(btn) {
    const container = document.getElementById("sastojci-container");
    const rows = container.querySelectorAll(".sastojak-row");

    if (rows.length > 1) {
        btn.parentNode.remove();
    } else {
        alert("Mora postojati bar jedan sastojak.");
    }
}

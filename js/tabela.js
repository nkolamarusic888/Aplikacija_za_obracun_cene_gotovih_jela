// Inline edit + Ukupno update
function editRow(btn){
    let tr = btn.closest('tr');
    // Čuvamo originalne vrednosti
    tr.querySelectorAll('input, select').forEach(el=>{
        if(el.dataset.original === undefined) {
            el.dataset.original = el.value;
        }
        el.disabled = false;
    });
    btn.style.display = 'none';
    tr.querySelector('.btn-cancel').style.display = 'inline-block';
}

function cancelRow(btn){
    let tr = btn.closest('tr');
    // Vraćamo originalne vrednosti
    tr.querySelectorAll('input, select').forEach(el=>{
        if(el.dataset.original !== undefined){
            el.value = el.dataset.original;
        }
        el.disabled = true;
    });
    btn.style.display = 'none';
    tr.querySelector('.btn-edit').style.display = 'inline-block';
    updateRowTotal(tr); // osvežava ukupno po redu i globalno
}

function updateRowTotal(tr){
    let k=parseFloat(tr.querySelector('input[name="sastojak_kolicina[]"]').value)||0;
    let c=parseFloat(tr.querySelector('input[name="sastojak_cena[]"]').value)||0;
    tr.querySelector('.ukupno').innerText=(k*c).toFixed(2);
    updateTotal();
}
function updateTotal(){
    let total=0;
    document.querySelectorAll('.ukupno').forEach(td=>{
        total+=parseFloat(td.innerText)||0;
    });
    document.getElementById('total').innerText=total.toFixed(2);
}
document.querySelectorAll('input[name="sastojak_kolicina[]"], input[name="sastojak_cena[]"]').forEach(i=>{
    i.addEventListener('input', e=>{
        let tr=e.target.closest('tr');
        updateRowTotal(tr);
    });
});
function addRow(){
    // 1) OTKLJUČAJ SVE POSTOJEĆE REDOVE PRE DODAVANJA NOVOG 
    document.querySelectorAll('#tabela tr').forEach(tr => {
        tr.querySelectorAll('input, select').forEach(el => {
            el.disabled = false;
        });
    });

    // 2) Dodaj novi red normalno 
    let template=document.getElementById('template');
    let clone=template.cloneNode(true);
    clone.removeAttribute('id');
    document.getElementById('tabela').appendChild(clone);
    clone.querySelectorAll('input,select').forEach(i=>i.disabled=false);
    clone.querySelector('.btn-edit').style.display='none';
    clone.querySelector('.btn-cancel').style.display='none';
}

function removeRow(btn){
    btn.closest('tr').remove();
    updateTotal();
}
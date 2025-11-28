<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Obračun cene jela</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- NAVIGACIJA -->
<nav class="navbar">
    <div class="logo">🍲 Restoran</div>
    <ul class="nav-links">
        <li><a href="../index.php">Početna</a></li>
        <li><a href="receptura.php">Dodaj recepte</a></li>
        <li><a href="pregled_i_izmena.php">Pregled jela</a></li>
    </ul>
</nav>

<?php
require_once "../baze/konekcija.php"; 

$jelo_id = $_GET['id'] ?? null;
if(!$jelo_id){
    die("Jelo nije izabrano!");
}

// Učitavanje podataka o jelu
$stmt = $conn->prepare("SELECT * FROM jelo WHERE id=?");
$stmt->bind_param("i", $jelo_id);
$stmt->execute();
$res_j = $stmt->get_result();
$jelo = $res_j->fetch_assoc();
$stmt->close();

if(!$jelo){
    die("Nevažeći ID jela!");
}

// Broj porcija
$broj_por = $_POST['broj_por'] ?? 1;

// Učitavanje recepture
$stmt2 = $conn->prepare("
    SELECT r.*, a.naziv as art_naziv 
    FROM receptura r 
    JOIN artikal a ON a.id=r.artikal_id 
    WHERE r.jelo_id=?
");
$stmt2->bind_param("i", $jelo_id);
$stmt2->execute();
$res_s = $stmt2->get_result();

$sastojci = [];
$ukupan_trosak_po_por = 0;

while($row = $res_s->fetch_assoc()){
    $row['ukupan_po_por'] = $row['kolicina'] * $row['cena'];
    $sastojci[] = $row;
    $ukupan_trosak_po_por += $row['ukupan_po_por'];
}
$stmt2->close();

$ukupan_trosak_za_por = $ukupan_trosak_po_por * $broj_por;
$datum_vreme = date("d.m.Y H:i:s");
?>

<h1 class="main-title">Obračun cene jela: <?= htmlspecialchars($jelo['naziv']) ?></h1>

<!-- FORMA ZA BROJ PORCIJA -->
<form class="forma" method="POST" style="margin-bottom:20px;">
    <label>Broj porcija:</label>
    <input type="number" name="broj_por" value="<?= htmlspecialchars($broj_por) ?>" min="1">
    <button class="dugme" type="submit">Izračunaj</button>
</form>

<!-- PRIKAZ OBRAČUNA -->
<div id="receipt">
    <h2 style="text-align:center;">🧾 Obračun cene</h2>

    <div class="receipt-row">
        <span>Jelo:</span>
        <span><?= htmlspecialchars($jelo['naziv']) ?></span>
    </div>

    <div class="receipt-row">
        <span>Broj porcija:</span>
        <span><?= $broj_por ?></span>
    </div>

    <div class="line"></div>

    <div><strong>Sastojci:</strong></div>
    <?php foreach($sastojci as $s): ?>
        <div class="receipt-row">
            <span><?= htmlspecialchars($s['art_naziv']) ?> (<?= $s['kolicina'] ?> <?= $s['jedinica'] ?>)</span>
            <span><?= number_format($s['ukupan_po_por'],2) ?> RSD</span>
        </div>
    <?php endforeach; ?>

    <div class="line"></div>

    <div class="receipt-row">
        <strong>Cena jedne porcije:</strong>
        <strong><?= number_format($ukupan_trosak_po_por,2) ?> RSD</strong>
    </div>

    <?php if($broj_por > 1): ?>
        <div style="text-align:center; margin-top:10px; font-weight:bold;">
            Ukupno za <?= $broj_por ?> porcija:<br>
            <?= number_format($ukupan_trosak_po_por * $broj_por,2) ?> RSD
        </div>
    <?php endif; ?>

    <div class="line"></div>

    <div class="receipt-row">
        <span>Datum i vreme:</span>
        <span><?= $datum_vreme ?></span>
    </div>

    <div class="line"></div>

    <small style="text-align:center; display:block;">Hvala na korišćenju!</small>
</div>

<!-- DUGME ZA ŠTAMPU -->
<div style="text-align:center; margin-top:30px;">
    <button id="racun" class="dugme" onclick="printReceipt()">🖨 Štampaj račun</button>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-content">
        <p>© 2025 Restoran | Sva prava zadržana Nikola Marušić</p>
        <p>Kontakt: nikolamarusic58@gmail.com</p>
    </div>
</footer>

<script src="../js/skripta.js"></script>
<script src="../js/print.js"></script>

</body>
</html>

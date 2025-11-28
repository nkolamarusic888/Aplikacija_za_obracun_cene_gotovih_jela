<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Unos recepture</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- NAVIGACIJA -->
<nav class="navbar">
    <div class="logo">🍲 Restoran</div>
    <ul class="nav-links">
        <li><a href="../index.php" class="active">Početna</a></li>
        <li><a href="receptura.php">Dodaj recepte</a></li>
        <li><a href="pregled_i_izmena.php">Pregled jela</a></li>
    </ul>
</nav>

<h1 class="main-title">Unesi sastojke jela</h1>

<?php
require_once "../baze/konekcija.php"; // konekcija na bazu

$fieldErrors = [
    "jelo_id" => "",
    "sastojak" => [] // niz po redovima
];
$message = "";

// Učitavanje svih jela
$jela = [];
$res = $conn->query("SELECT * FROM jelo ORDER BY naziv ASC");
while($row = $res->fetch_assoc()){
    $jela[] = $row;
}

// Učitavanje svih artikala/sastojaka
$artikli = [];
$res2 = $conn->query("SELECT * FROM artikal ORDER BY naziv ASC");
while($row = $res2->fetch_assoc()){
    $artikli[] = $row;
}

// Obrada POST forme
$jelo_id = "";
$sastojak_id = [];
$sastojak_jedinica = [];
$sastojak_kolicina = [];
$sastojak_cena = [];

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $jelo_id = $_POST["jelo_id"] ?? "";
    $sastojak_id = $_POST["sastojak_id"] ?? [];
    $sastojak_jedinica = $_POST["sastojak_jedinica"] ?? [];
    $sastojak_kolicina = $_POST["sastojak_kolicina"] ?? [];
    $sastojak_cena = $_POST["sastojak_cena"] ?? [];

    // Validacija jela
    if($jelo_id == "") $fieldErrors["jelo_id"] = "Morate izabrati jelo.";

    // Validacija sastojaka
    $validan_sastojak = false;
    for($i=0; $i<count($sastojak_id); $i++){
        $fieldErrors["sastojak"][$i] = [];
        if($sastojak_id[$i] == "") $fieldErrors["sastojak"][$i]["id"] = "Izaberite sastojak.";
        if(!is_numeric($sastojak_kolicina[$i]) || $sastojak_kolicina[$i]<=0) $fieldErrors["sastojak"][$i]["kolicina"] = "Količina je obavezna";
        if(!is_numeric($sastojak_cena[$i]) || $sastojak_cena[$i]<=0) $fieldErrors["sastojak"][$i]["cena"] = "Cena je obavezna";

        if(empty($fieldErrors["sastojak"][$i])) $validan_sastojak = true;
    }

    // Unos u bazu ako je validno
    if($validan_sastojak && $fieldErrors["jelo_id"] == ""){
        $stmt = $conn->prepare("INSERT INTO receptura (jelo_id, artikal_id, jedinica, kolicina, cena) VALUES (?, ?, ?, ?, ?)");
        for($i=0; $i<count($sastojak_id); $i++){
            if(empty($fieldErrors["sastojak"][$i])) {
                $stmt->bind_param("iisdd", $jelo_id, $sastojak_id[$i], $sastojak_jedinica[$i], $sastojak_kolicina[$i], $sastojak_cena[$i]);
                $stmt->execute();
            }
        }
        $stmt->close();
        $message  = "Receptura je uspešno sačuvana! ✔️";
        $sastojak_id = $sastojak_jedinica = $sastojak_kolicina = $sastojak_cena = [];
    } else if(!$validan_sastojak) {
        $message = "Morate dodati bar jedan validan sastojak.";
    }
}

// Validacija GET forme (obračun jela)
$get_error = "";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    if ($_GET["id"] === "") {
        $get_error = "Morate izabrati jelo pre obračuna.";
    } else {
        header("Location: obracun.php?id=" . $_GET["id"]);
        exit;
    }
}
?>

<?php if($message!="") echo "<p class='drugo' style='color:black;'>$message</p>"; ?>

<!-- POST FORMA: unos sastojaka -->
<form class="forma" method="POST">
    <label>Izaberite jelo:</label>
    <select name="jelo_id">
        <option value="">-- izaberi jelo --</option>
        <?php foreach($jela as $j): ?>
            <option value="<?= $j['id'] ?>" <?= ($j['id']==$jelo_id)?'selected':'' ?>><?= htmlspecialchars($j['naziv']) ?></option>
        <?php endforeach; ?>
    </select>
    <?php if($fieldErrors["jelo_id"] != ""): ?>
        <div class="error"><?= $fieldErrors["jelo_id"] ?></div>
    <?php endif; ?>

    <h3 class="sastojci">Sastojci</h3>
    <div id="sastojci-container">
        <?php
        $rows = max(1, count($sastojak_id));
        for($i=0; $i<$rows; $i++):
        ?>
        <div class="sastojak-row">
            <button type="button" class="remove-btn" onclick="removeSastojak(this)">✖</button>

            <label>Sastojak:</label>
            <select name="sastojak_id[]">
                <option value="">-- izaberi sastojak --</option>
                <?php foreach($artikli as $a): ?>
                    <option value="<?= $a['id'] ?>" <?= (isset($sastojak_id[$i]) && $a['id']==$sastojak_id[$i])?'selected':'' ?>>
                        <?= htmlspecialchars($a['naziv']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if(isset($fieldErrors["sastojak"][$i]["id"])): ?>
                <div class="error"><?= $fieldErrors["sastojak"][$i]["id"] ?></div>
            <?php endif; ?>

            <label>Jedinica mere:</label>
            <select name="sastojak_jedinica[]">
                <?php foreach(["kg","g","l","ml","kom"] as $jm): ?>
                    <option value="<?= $jm ?>" <?= (isset($sastojak_jedinica[$i]) && $sastojak_jedinica[$i]==$jm)?'selected':'' ?>><?= $jm ?></option>
                <?php endforeach; ?>
            </select>

            <label>Količina:</label>
            <input type="number" step="0.01" name="sastojak_kolicina[]" value="<?= $sastojak_kolicina[$i] ?? '' ?>">
            <?php if(isset($fieldErrors["sastojak"][$i]["kolicina"])): ?>
                <div class="error"><?= $fieldErrors["sastojak"][$i]["kolicina"] ?></div>
            <?php endif; ?>

            <label>Cena po jedinici:</label>
            <input type="number" step="0.01" name="sastojak_cena[]" value="<?= $sastojak_cena[$i] ?? '' ?>">
            <?php if(isset($fieldErrors["sastojak"][$i]["cena"])): ?>
                <div class="error"><?= $fieldErrors["sastojak"][$i]["cena"] ?></div>
            <?php endif; ?>
        </div>
        <?php endfor; ?>
    </div>

    <button class="dugme" type="button" onclick="addSastojak()">+ Dodaj još sastojaka</button><br><br>
    <button class="dugme" type="submit">Sačuvaj recepturu</button>
</form>

<!-- GET FORMA: obračun cene jela -->
<h3 class="main-title">Izračunaj cenu jela</h3>
<form class="forma" method="get" action="">
    <label>Izaberite jelo:</label>
    <select name="id">
        <option value="">-- izaberi jelo --</option>
        <?php
        $res = $conn->query("SELECT * FROM jelo ORDER BY naziv ASC");
        while($j = $res->fetch_assoc()){
            $sel = (isset($_GET["id"]) && $_GET["id"] == $j["id"]) ? "selected" : "";
            echo "<option value='{$j['id']}' $sel>{$j['naziv']}</option>";
        }
        ?>
    </select>
    <?php if($get_error != ""): ?>
        <div class="error"><?= $get_error ?></div>
    <?php endif; ?>

    <button class="dugme" type="submit">Prikaži obračun</button>
</form>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-content">
        <p>© 2025 Restoran | Sva prava zadržava Nikola Marušić</p>
        <p>Kontakt: nikolamarusic58@gmail.com</p>
    </div>
</footer>
<script src="../js/dugmad.js"></script>
<script src="../js/skripta.js"></script>
</body>
</html>

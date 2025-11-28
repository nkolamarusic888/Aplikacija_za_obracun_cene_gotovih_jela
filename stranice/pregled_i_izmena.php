<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Izmena recepture</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/tabela.css">
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

$errors = [];
$message = "";

// Učitavanje jela
$jela = [];
$q = $conn->query("SELECT * FROM jelo ORDER BY naziv ASC");
while($row = $q->fetch_assoc()){ $jela[] = $row; }

// Učitavanje artikala
$artikli = [];
$q2 = $conn->query("SELECT * FROM artikal ORDER BY naziv ASC");
while($row = $q2->fetch_assoc()){ $artikli[] = $row; }

// Brisanje sastojka
if(isset($_GET["delete"]) && isset($_GET["id"])){
    $del_id = intval($_GET["id"]);
    $stmt = $conn->prepare("DELETE FROM receptura WHERE id=?");
    $stmt->bind_param("i", $del_id);
    $stmt->execute();
    $stmt->close();
    $message = "Sastojak uspešno obrisan!";
}

// Snimanje izmena
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $jelo_id = $_POST["jelo_id"] ?? null;

    if(!$jelo_id){
        $errors[] = "Jelo nije izabrano!";
    } else {
        $row_id = $_POST["row_id"] ?? [];
        $sastojak_id = $_POST["sastojak_id"] ?? [];
        $jedinica = $_POST["sastojak_jedinica"] ?? [];
        $kolicina = $_POST["sastojak_kolicina"] ?? [];
        $cena = $_POST["sastojak_cena"] ?? [];

        for($i=0; $i<count($sastojak_id); $i++){
            // VALIDACIJA ZA SVAKI RED
            if($row_id[$i] == "0") {
                if(empty($sastojak_id[$i]) || empty($jedinica[$i]) || empty($kolicina[$i]) || empty($cena[$i])){
                    $errors[] = "Popunite sva polja u redu broj ".($i+1)." !";
                    continue;
                }
            }
            
            // INSERT I UPDATE
            if(empty($errors)){
                if($row_id[$i] == "0"){
                    $stmt = $conn->prepare("INSERT INTO receptura (jelo_id, artikal_id, jedinica, kolicina, cena) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("iisdd",$jelo_id,$sastojak_id[$i],$jedinica[$i],$kolicina[$i],$cena[$i]);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $id_update=intval($row_id[$i]);
                    $stmt=$conn->prepare("UPDATE receptura SET artikal_id=?, jedinica=?, kolicina=?, cena=? WHERE id=? AND jelo_id=?");
                    $stmt->bind_param("isddii",$sastojak_id[$i],$jedinica[$i],$kolicina[$i],$cena[$i],$id_update,$jelo_id);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        if(empty($errors)) $message="Receptura uspešno sačuvana!✔️";
    }
}

// Učitavanje recepture
$selected_jelo = $_GET["jelo_id"] ?? ($_POST["jelo_id"] ?? null);
$receptura = [];
$ukupan_trosak = 0;

if($selected_jelo){
    $stmt=$conn->prepare("
        SELECT r.id, r.artikal_id, r.jedinica, r.kolicina, r.cena, a.naziv AS artikal_naziv
        FROM receptura r
        JOIN artikal a ON a.id=r.artikal_id
        WHERE r.jelo_id=?
        ORDER BY r.id ASC
    ");
    $stmt->bind_param("i",$selected_jelo);
    $stmt->execute();
    $res=$stmt->get_result();
    while($row=$res->fetch_assoc()){
        $row["ukupno"] = $row["kolicina"] * $row["cena"];
        $ukupan_trosak += $row["ukupno"];
        $receptura[] = $row;
    }
    $stmt->close();
}
?>

<h1 class="main-title">Pregled sastojaka</h1>

<?php if($message): ?>
    <p class="drugo" style="color:green;"><?= $message ?></p>
<?php endif; ?>

<?php if($errors): ?>
    <?php foreach($errors as $e): ?>
        <p class="error-msg"><?= $e ?></p>
    <?php endforeach; ?>
<?php endif; ?>


<!-- IZBOR JELA -->
<form class="forma" method="GET">
    <label>Izaberi jelo:</label>
    <select name="jelo_id" onchange="this.form.submit()">
        <option value="">-- izaberi --</option>
        <?php foreach($jela as $j): ?>
            <option value="<?= $j['id'] ?>" <?= ($selected_jelo==$j['id'])?'selected':'' ?>>
                <?= htmlspecialchars($j['naziv']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if($selected_jelo): ?>
<!-- FORMA ZA IZMENU RECEPTURE -->
<form method="POST">
    <input type="hidden" name="jelo_id" value="<?= $selected_jelo ?>">
    <table id="tabela">
        <tr>
            <th>Sastojak</th>
            <th>Jedinica</th>
            <th>Količina</th>
            <th>Cena</th>
            <th>Ukupno</th>
            <th>Akcije</th>
        </tr>

        <?php foreach($receptura as $r): ?>
        <tr data-id="<?= $r['id'] ?>">
            <td>
                <select class="selektovanje" name="sastojak_id[]" disabled>
                    <?php foreach($artikli as $a): ?>
                        <option value="<?= $a['id'] ?>" <?= ($a['id']==$r['artikal_id'])?'selected':'' ?>>
                            <?= htmlspecialchars($a['naziv']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <select name="sastojak_jedinica[]" disabled>
                    <?php foreach(["kg","g","l","ml","kom"] as $jm): ?>
                        <option value="<?= $jm ?>" <?= ($jm==$r['jedinica'])?'selected':'' ?>><?= $jm ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="number" step="0.01" name="sastojak_kolicina[]" value="<?= $r['kolicina'] ?>" disabled></td>
            <td><input type="number" step="0.01" name="sastojak_cena[]" value="<?= $r['cena'] ?>" disabled></td>
            <td class="ukupno"><?= number_format($r['ukupno'],2) ?></td>
            <td>
                <input type="hidden" name="row_id[]" value="<?= $r['id'] ?>">
                <button type="button" class="btn-edit" onclick="editRow(this)">Uredi</button>
                <button type="button" class="btn-cancel" onclick="cancelRow(this)" style="display:none">Prekini</button>
                <a href="?jelo_id=<?= $selected_jelo ?>&delete=1&id=<?= $r['id'] ?>" class="btn-delete">Obriši</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <button class="dugme" type="button" id="add-row" onclick="addRow()">+ Dodaj sastojak</button>
    <br><br>
    <button class="dugme" type="submit" id="save-btn">Sačuvaj izmene</button>
    <div class="total forma">Ukupan trošak: <span id="total"><?= number_format($ukupan_trosak,2) ?></span> RSD</div>
</form>

<!-- TEMPLATE RED -->
<table style="display:none">
    <tr id="template">
        <td>
            <select name="sastojak_id[]">
                <option value="">-- izaberi --</option>
                <?php foreach($artikli as $a): ?>
                    <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['naziv']) ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <select name="sastojak_jedinica[]">
                <option value="kg">kg</option>
                <option value="g">g</option>
                <option value="l">l</option>
                <option value="ml">ml</option>
                <option value="kom">kom</option>
            </select>
        </td>
        <td><input type="number" step="0.01" name="sastojak_kolicina[]"></td>
        <td><input type="number" step="0.01" name="sastojak_cena[]"></td>
        <td class="ukupno">0.00</td>
        <td>
            <input type="hidden" name="row_id[]" value="0">
            <button type="button" class="btn-edit" onclick="editRow(this)">Uredi</button>
            <button type="button" class="btn-cancel" onclick="cancelRow(this)" style="display:none">Prekini</button>
            <button type="button" class="btn-delete" onclick="removeRow(this)">Obriši</button>
        </td>
    </tr>
</table>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-content">
        <p>© 2025 Restoran | Sva prava zadržana Nikola Marušić</p>
        <p>Kontakt: nikolamarusic58@gmail.com</p>
    </div>
</footer>

<script src="../js/tabela.js"></script>

<?php endif; ?>

</body>
</html>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Unos jela</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
</head>
<body>

<nav class="navbar">
    <div class="logo">🍲 Restoran</div>
    <ul class="nav-links">
        <li><a href="index.php" class="active">Početna</a></li>
        <li><a href="stranice/receptura.php">Dodaj recepte</a></li>
        <li><a href="stranice/pregled_i_izmena.php">Pregled jela</a></li>
    </ul>
</nav>

<div class="header">
    <p class="subtitle">Behind creativity</p>
    <h1 class="main-title">
        <img src="slike/kuvar.png" alt="Chef Icon" class="title-icon">
        Šta danas kuvamo?
    </h1>

    <div class="slider-track" id="sliderTrack">
        <div class="card" data-title="Dimljena roštilj kobasica" data-desc="Sočna, blago dimljena kobasica pripremana na roštilju, idealna za gurmane.">
            <img src="slike/Dimljena-rošilj-kobasica.jpeg" alt="Kobasica">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Gulaš" data-desc="Tradicionalni domaći gulaš kuvan na laganoj vatri sa bogatim sosom.">
            <img src="slike/Gulas.jpeg" alt="Gulaš">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Karađorđeva šnicla" data-desc="Hrskava, punjena šnicla sa kajmakom i tartar sosom.">
            <img src="slike/Karadjordje.jpeg" alt="Karađorđeva">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Lovačke šnicle" data-desc="Šnicle u lovačkom sosu sa pečurkama.">
            <img src="slike/lovacke-snicle.jpeg" alt="Lovačke šnicle">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Mešano meso" data-desc="Ćevapi, kobasice, vešalice i još mnogo toga.">
            <img src="slike/Mesano meso.webp" alt="Mešano meso">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Pečenje" data-desc="Domaće pečenje sa savršenim ukusom.">
            <img src="slike/Pecenje.jpeg" alt="Pečenje">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Pileće belo meso" data-desc="Lagano i sočno belo meso.">
            <img src="slike/pilece belo.jpeg" alt="Pileće belo">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Pršuta" data-desc="Suvo sušena pršuta vrhunskog kvaliteta.">
            <img src="slike/prsuta.jpeg" alt="Pršuta">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Riba sa roštilja" data-desc="Sveža riba sa začinima.">
            <img src="slike/riba.jpeg" alt="Riba">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Sarma" data-desc="Tradicionalna sarma kuvana satima.">
            <img src="slike/sarma.webp" alt="Sarma">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
        <div class="card" data-title="Vino" data-desc="Domaće crveno vino.">
            <img src="slike/vino.jpeg" alt="Vino">
            <div class="hover-overlay"><span>Pogledaj više</span></div>
        </div>
    </div>
</div>

<button class="close-btn" id="closeBtn">
    <svg viewBox="0 0 24 24" fill="none">
        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
    </svg>
</button>

<div class="card-info" id="cardInfo">
    <h2 id="cardTitle"></h2>
    <p id="cardDesc"></p>
</div>

<div class="user-recipe-box">
    <h2>Da li ti se sviđa neko jelo?</h2>
    <p>Unesi svoj recept i podeli sa nama!</p>
    <button id="openRecipeForm">Dodaj svoj recept</button>
</div>

<?php
$errors = ["naziv" => "", "jedinica_mere" => "", "planirana_kolicina" => ""];
$naziv = $opis = $jedinica_mere = $planirana_kolicina = "";
$formShouldOpen = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $naziv = $_POST["naziv"] ?? "";
    $opis = $_POST["opis"] ?? "";
    $jedinica_mere = $_POST["jedinica_mere"] ?? "";
    $planirana_kolicina = $_POST["planirana_kolicina"] ?? "";

    if ($naziv === "") $errors["naziv"] = "Naziv jela je obavezan.";
    if ($jedinica_mere === "") $errors["jedinica_mere"] = "Morate izabrati jedinicu mere.";
    if ($planirana_kolicina === "") $errors["planirana_kolicina"] = "Planirana količina je obavezna.";

    if (array_filter($errors)) {
        $formShouldOpen = true; // 🔥 forma ostaje OTVORENA
    } else {
        $conn = new mysqli("localhost", "root", "", "restoran");
        if ($conn->connect_error) die("Greška sa bazom: " . $conn->connect_error);

        $stmt = $conn->prepare("INSERT INTO jelo (naziv, opis, jedinica_mere, planirana_kolicina) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $naziv, $opis, $jedinica_mere, $planirana_kolicina);

        echo $stmt->execute()
            ? "<p class='uspesno' style='color:green;'>Jelo uspešno dodato ✔️</p>"
            : "<p style='color:red;'>Greška pri unosu.</p>";

        $stmt->close();
        $conn->close();
    }
}
?>

<form class="forma" method="POST" action="" id="recipeForm"
      style="<?= $formShouldOpen ? '' : 'display:none;' ?>">
    <label>Naziv jela:</label><br>
    <input type="text" name="naziv" value="<?= htmlspecialchars($naziv) ?>"><br>
    <?php if ($errors["naziv"]): ?><p class="error"><?= $errors["naziv"] ?></p><?php endif; ?><br>

    <label>Opis:</label><br>
    <textarea name="opis"><?= htmlspecialchars($opis) ?></textarea><br><br>

    <label>Jedinica mere:</label><br>
    <select name="jedinica_mere">
        <option value="">-- izaberi --</option>
        <option value="porcija" <?= $jedinica_mere === "porcija" ? "selected" : "" ?>>porcija</option>
        <option value="kg" <?= $jedinica_mere === "kg" ? "selected" : "" ?>>kg</option>
        <option value="g" <?= $jedinica_mere === "g" ? "selected" : "" ?>>g</option>
        <option value="kom" <?= $jedinica_mere === "kom" ? "selected" : "" ?>>kom</option>
        <option value="l" <?= $jedinica_mere === "l" ? "selected" : "" ?>>l</option>
        <option value="ml" <?= $jedinica_mere === "ml" ? "selected" : "" ?>>ml</option>
    </select><br>
    <?php if ($errors["jedinica_mere"]): ?><p class="error"><?= $errors["jedinica_mere"] ?></p><?php endif; ?><br>

    <label>Planirana količina:</label><br>
    <input type="number" step="0.01" name="planirana_kolicina" value="<?= htmlspecialchars($planirana_kolicina) ?>"><br>
    <?php if ($errors["planirana_kolicina"]): ?><p class="error"><?= $errors["planirana_kolicina"] ?></p><?php endif; ?><br>

    <button class="dugme" type="submit">Sačuvaj jelo</button>
</form>

<?php if ($formShouldOpen): ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const forma = document.getElementById("recipeForm");
    gsap.from(forma, { duration: 0.6, y: -40, opacity: 0, ease: "back.out(1.7)" });
});
</script>
<?php endif; ?>

<footer class="footer">
    <div class="footer-content">
        <p>© 2025 Restoran | Sva prava zadržava Nikola Marušić</p>
        <p>Kontakt: nikolamarusic58@gmail.com</p>
    </div>
</footer>

<script src="js/skripta.js"></script>
</body>
</html>

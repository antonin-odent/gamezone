<?php
session_start();
require_once("conf.php");

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

if (!isset($_SESSION["type"]) || $_SESSION["type"] != 1) {
    die("Accès interdit.");
}

if (!isset($_GET["id"])) {
    die("Tournoi introuvable.");
}

$id = (int)$_GET["id"];

$stmt = mysqli_prepare(
    $connexion,
    "SELECT * FROM ap3_tournoi WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$tournoi = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

if (!$tournoi) {
    die("Tournoi introuvable.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom"];
    $date = $_POST["date"];
    $jeu_id = $_POST["jeu_id"];

    $stmt = mysqli_prepare(
        $connexion,
        "UPDATE ap3_tournoi
         SET nom = ?, date = ?, jeu_id = ?
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssii",
        $nom,
        $date,
        $jeu_id,
        $id
    );

    mysqli_stmt_execute($stmt);

    header("Location: tournois.php");
    exit;
}

$jeux = mysqli_query($connexion, "SELECT * FROM ap3_jeu");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier tournoi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Modifier un tournoi</h1>

<form method="post">

    <label>Nom</label>
    <input
        type="text"
        name="nom"
        value="<?= $tournoi['nom'] ?>"
        required
    >

    <br><br>

    <label>Date</label>
    <input
        type="date"
        name="date"
        value="<?= $tournoi['date'] ?>"
        required
    >

    <br><br>

    <label>Jeu</label>

    <select name="jeu_id">

        <?php while($jeu = mysqli_fetch_assoc($jeux)) : ?>

            <option
                value="<?= $jeu['id'] ?>"
                <?= ($jeu['id'] == $tournoi['jeu_id']) ? 'selected' : '' ?>
            >
                <?= $jeu['nom'] ?>
            </option>

        <?php endwhile; ?>

    </select>

    <br><br>

    <button type="submit">
        Modifier
    </button>

</form>

</body>
</html>
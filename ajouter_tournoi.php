<?php
session_start();
require_once("conf.php");

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

if (!isset($_SESSION["type"]) || $_SESSION["type"] != 1) {
    die("Accès interdit.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom"];
    $date = $_POST["date"];
    $jeu_id = $_POST["jeu_id"];

    $stmt = mysqli_prepare(
        $connexion,
        "INSERT INTO ap3_tournoi (nom, date, jeu_id)
         VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param($stmt, "ssi", $nom, $date, $jeu_id);
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
    <title>Ajouter un tournoi</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>

<h1>Ajouter un tournoi</h1>

<form method="post">

    <label>Nom du tournoi</label>
    <input type="text" name="nom" required>

    <br><br>

    <label>Date</label>
    <input type="date" name="date" required>

    <br><br>

    <label>Jeu</label>
    <select name="jeu_id">

        <?php while($jeu = mysqli_fetch_assoc($jeux)) : ?>

            <option value="<?= $jeu['id'] ?>">
                <?= $jeu['nom'] ?>
            </option>

        <?php endwhile; ?>

    </select>

    <br><br>

    <button type="submit">
        Ajouter
    </button>

</form>

<p><a href="tournois.php">Retour à la liste des tournois</a></p>

</body>
</html>
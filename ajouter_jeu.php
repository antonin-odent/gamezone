<?php
session_start();
require_once("conf.php");

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

if (!isset($_SESSION["id"]) || $_SESSION["type"] != 1) {
    header('Location: index.php');
    exit;

}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un jeu</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Ajouter un jeu</h1>
    <form method="POST" action="ajouter_traitement_jeu.php" enctype="multipart/form-data">
        <div class="champ">
            <label for="nom">Nom du jeu :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="champ">
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div class="champ">
            <label for="logo">Logo :</label>
            <input type="file" id="logo" name="logo" accept="image/*" required>
        </div>

        <button type="submit">Ajouter le jeu</button>
    </form>

</body>
</html>
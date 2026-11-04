<?php
session_start();
include("conf.php");



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription confirmée</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="conteneur">
    <h1>✅ Inscription validée</h1>

    <p>
        Vous êtes bien inscrit au tournoi.
    </p>

    <p>
        Vous pouvez consulter la liste des tournois ou retourner à l'accueil.
    </p>

    <a href="tournois.php">Retour aux tournois</a>
    
    <br><br>
    <a href="index.php">Accueil</a>
</div>

</body>
</html>

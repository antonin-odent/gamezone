<?php
session_start();
require_once("conf.php");

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

$tournoi_id = (int)$_GET["id"];

$stmt = mysqli_prepare(
    $connexion,
    "SELECT nom FROM ap3_tournoi WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $tournoi_id);
mysqli_stmt_execute($stmt);

$tournoi = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Déjà inscrit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Tournoi déjà rejoint</h1>

<p>
    Vous êtes déjà inscrit au tournoi
    <strong><?= htmlspecialchars($tournoi["nom"]) ?></strong>.
</p>

<p>
    Aucune nouvelle inscription n'a été enregistrée.
</p>

<a href="tournois.php">Retour aux tournois</a>

</body>
</html>
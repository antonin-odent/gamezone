<?php
// 7. Se désinscrire d'un tournoi
session_start();
include("conf.php");

if (!isset($_SESSION["id"])) {
    header("Location: connexion.php");
    exit;
}

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);
$joueur  = (int) $_SESSION["id"];
$tournoi = (int) $_POST["tournoi_id"];

mysqli_query($connexion, "DELETE FROM ap3_inscrire WHERE joueur_id=$joueur AND tournoi_id=$tournoi");

header("Location: tournois.php");
exit;
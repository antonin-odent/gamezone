<?php
session_start();
require_once("conf.php");

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

if (!isset($_SESSION["type"]) || $_SESSION["type"] != 1) {
    die("Accès interdit.");
}

if (!isset($_GET["joueur_id"]) || !isset($_GET["tournoi_id"])) {
    die("Paramètres manquants.");
}

$joueur_id = (int) $_GET["joueur_id"];
$tournoi_id = (int) $_GET["tournoi_id"];

$stmt = mysqli_prepare(
    $connexion,
    "DELETE FROM ap3_inscrire
     WHERE joueur_id = ? AND tournoi_id = ?"
);

mysqli_stmt_bind_param($stmt, "ii", $joueur_id, $tournoi_id);
mysqli_stmt_execute($stmt);

header("Location: admin_tournoi.php?id=" . $tournoi_id);
exit;
?>




<?php
session_start();
include("conf.php");
$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

$stmt = mysqli_prepare($connexion, "SELECT * FROM ap3_joueur WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $_POST["email"]);
mysqli_stmt_execute($stmt);
$joueur = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($joueur && password_verify($_POST["mdp"], $joueur["mdp"])) {
    $_SESSION["id"]   = $joueur["id"];
    $_SESSION["type"] = $joueur["type"];
    $_SESSION["nom"]  = $joueur["nom"];
    $_SESSION["prenom"]  = $joueur["prenom"];
    header("Location: index.php");
} else {
    header("Location: index.php?erreur=1");
}
exit;
<?php
session_start();
require_once("conf.php");
$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);


if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1) {
    die("Accès interdit.");
}

$id = $_GET["id"];

$sql = "DELETE FROM ap3_inscrire WHERE id = ?";
$stmt = mysqli_prepare($connexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

echo "Inscription supprimée.";
?>

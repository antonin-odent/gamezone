<?php
session_start();
require_once("conf.php");

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

if (!$connexion) {
    die("Erreur de connexion à la base.");
}

// Vérifier que le joueur est connecté
if (!isset($_SESSION["id"])) {
    die("Vous devez être connecté.");
}

// Vérifier qu'un tournoi a été sélectionné
if (!isset($_GET["id"])) {
    die("Tournoi non spécifié.");
}

$joueur_id = $_SESSION["id"];
$tournoi_id = (int)$_GET["id"];

// Vérifier que le tournoi existe
$stmt = mysqli_prepare(
    $connexion,
    "SELECT * FROM ap3_tournoi WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $tournoi_id);
mysqli_stmt_execute($stmt);

if (!mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
    die("Tournoi introuvable.");
}

// Vérifier si le joueur est déjà inscrit
$stmt = mysqli_prepare(
    $connexion,
    "SELECT *
     FROM ap3_inscrire
     WHERE joueur_id = ? AND tournoi_id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $joueur_id,
    $tournoi_id
);

mysqli_stmt_execute($stmt);

if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
    header("Location: deja_inscrit.php?id=".$tournoi_id);
    exit;
}

// Ajouter l'inscription
$stmt = mysqli_prepare(
    $connexion,
    "INSERT INTO ap3_inscrire (joueur_id, tournoi_id)
     VALUES (?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $joueur_id,
    $tournoi_id
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: confirmation_tournoi.php");
    exit;
} else {
    echo "Erreur lors de l'inscription.";
}
?>



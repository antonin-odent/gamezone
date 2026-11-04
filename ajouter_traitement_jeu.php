<?php
session_start();
require("mailer.php");
include("conf.php");
$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

$nom    = $_POST['nom'];
$description = $_POST['description'];
$logo  = $_FILES['logo'];

if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
    die("Erreur lors de l'envoi du fichier.");
}

if ($_FILES['logo']['size'] > 2 * 1024 * 1024) {
    die("Image trop volumineuse.");
}
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$type = finfo_file($finfo, $_FILES['logo']['tmp_name']);
finfo_close($finfo);

$typesAutorises = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp'
];

if (!isset($typesAutorises[$type])) {
    die("Format d'image non autorisé.");
}

$extension = $typesAutorises[$type];
$nomFichier = uniqid('jeu_', true) . '.' . $extension;

$dossier = 'images/jeux/';
$chemin = $dossier . $nomFichier;

if (!move_uploaded_file($_FILES['logo']['tmp_name'], $chemin)) {
    die("Erreur lors de l'enregistrement du fichier.");
}


$stmt = mysqli_prepare(
        $connexion,
        "INSERT INTO ap3_jeu (nom, description, logo)
         VALUES (?, ?, ?)");

         mysqli_stmt_bind_param($stmt, "sss", $_POST['nom'], $_POST['description'], $nomFichier);
        mysqli_stmt_execute($stmt);
        header("Location: confirmation_ajout_jeu.php")

    




?>
    





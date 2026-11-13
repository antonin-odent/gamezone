<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameZone</title>
    <link rel="stylesheet" href="style1.css">
    
</head>
<body>
    <p>Veuillez entrer votre adresse email pour réinitialiser votre mot de passe.</p>
    <form action="mdp.php" method="POST">
    <label for="email">Email</label>
    <input id="email" name="email" type="email" required>
    <button type="submit">Réinitialiser</button>
</form>
    
</body>
</html>




<?php
session_start();
require_once("conf.php");
require_once("mailer.php");

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

if (!$connexion) {
    die("Erreur de connexion à la base de données.");
}

if (!isset($_POST["email"])) {
    die("");
}

$email = $_POST["email"];

$sql = "SELECT id FROM ap3_joueur WHERE email = ?";
$stmt = mysqli_prepare($connexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$joueur = mysqli_fetch_assoc($result);

if (!$joueur) {
    echo "Erreur : cet email n'existe pas dans notre base.";
    exit;
}

$joueur_id = $joueur["id"];

$token = bin2hex(random_bytes(32));
$expiration = date("Y-m-d H:i:s", time() + 1800);

$sql = "INSERT INTO ap3_reset_password (joueur_id, token, expiration) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($connexion, $sql);
mysqli_stmt_bind_param($stmt, "iss", $joueur_id, $token, $expiration);
mysqli_stmt_execute($stmt);

//$lien= "https://www.siolapie.com/27_ODENT/gamezone/reinitialisation.php?token=" . urlencode($token);
$lien= "http://localhost/gamezone/reinitialisation.php?token=" . urlencode($token);

// Préparer l'email
$objet = "Réinitialisation de votre mot de passe";
$message = "Bonjour,\n\nVous avez demandé à réinitialiser votre mot de passe.
Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : 
$lien

Ce lien expirera dans 30 minutes.

Cordialement,
L'équipe GameZone.";

// Envoyer l'email
envoiMail($email, $objet, $message);

echo "Un email de réinitialisation a été envoyé.";
?>

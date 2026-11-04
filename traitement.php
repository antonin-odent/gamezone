<?php
// Inscription uniquement (la connexion est dans traitement_connexion.php)
session_start();
require("mailer.php");
include("conf.php");
$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

$nom    = $_POST['Nom'];
$prenom = $_POST['Prenom'];
$email  = $_POST['email'];
$jeu_id = $_POST['jeu_id'];
$hash   = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // ne pas écraser $mdp (mot de passe BDD de conf.php)

// L'email existe-t-il déjà ?
$stmt = mysqli_prepare($connexion, "SELECT id FROM ap3_joueur WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
    echo "Erreur : un joueur avec cet email existe déjà. <a href='index.php'>Retour</a>";
    exit;
}

// Insertion (type = 0 par défaut grâce à la BDD)
$stmt = mysqli_prepare($connexion, "INSERT INTO ap3_joueur (nom, prenom, email, jeu, mdp) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssis", $nom, $prenom, $email, $jeu_id, $hash);
mysqli_stmt_execute($stmt);

$objet   = "confirmation d'inscription";
$message = "Bonjour $prenom $nom,\n\nMerci pour votre inscription au jeu GameZone.\n\nCordialement,\nL'équipe GameZone.";
envoiMail($email, $objet, $message);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>GameZone</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include("menu.php"); ?>
<h1>Inscription réussie</h1>
<p>Un email de confirmation a été envoyé à <?= htmlspecialchars($email) ?>. Vous pouvez maintenant vous connecter.</p>
<a href="index.php">Retour à l'accueil</a>
</body>
</html>
<?php
session_start();
require_once("conf.php");
$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

$message = ""; 

if (!$connexion) {
    $message = "Erreur de connexion à la base de données.";
}

if (!isset($_GET["token"])) {
    $message = "Token manquant.";
} else {
    $token = $_GET["token"];

    
    $sql = "SELECT * FROM ap3_reset_password 
            WHERE token = ? 
            AND utilise = 0 
            AND expiration > NOW()";

    $stmt = mysqli_prepare($connexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $reset = mysqli_fetch_assoc($result);

    if (!$reset) {
        $message = "Lien invalide ou expiré.";
    }

    
    if (isset($_POST["mdp"]) && $reset) {

        $hash = password_hash($_POST["mdp"], PASSWORD_DEFAULT);

        
        $sql = "UPDATE ap3_joueur SET mdp = ? WHERE id = ?";
        $stmt = mysqli_prepare($connexion, $sql);
        mysqli_stmt_bind_param($stmt, "si", $hash, $reset["joueur_id"]);
        mysqli_stmt_execute($stmt);

        
        $sql = "UPDATE ap3_reset_password SET utilise = 1 WHERE id = ?";
        $stmt = mysqli_prepare($connexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $reset["id"]);
        mysqli_stmt_execute($stmt);

        $message = "Votre mot de passe a été réinitialisé avec succès.";
    
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="container">

    <?php if ($message != ""): ?>
        <div class="message">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <?php if ($message == "" || $message == ""); ?>
    <a href="index.php">Retour à la page d'accueil</a>
    

    <?php if (isset($reset) && $reset && !isset($_POST["mdp"])): ?>
        <h2>Réinitialiser votre mot de passe</h2>

        <form method="POST">
            <label for="mdp">Nouveau mot de passe :</label><br>
            <input type="password" id="mdp" name="mdp" required><br><br>

            <button type="submit">Valider</button>
        </form>
    <?php endif; ?>

</div>

</body>
</html>

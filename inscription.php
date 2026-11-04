<?php
session_start();
include("conf.php");
$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);
$resultat = mysqli_query($connexion, "SELECT * FROM ap3_jeu");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>GameZone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Inscription des joueurs</h2>
    <form method="POST" action="traitement.php">
        <div class="champ">
            <label for="nom">Nom</label>
            <input id="nom" name="Nom" required>
        </div>
        <div class="champ">
            <label for="prenom">Prénom</label>
            <input id="prenom" name="Prenom" required>
        </div>
        <div class="champ">
            <label for="jeu">Jeu</label>
            <select id="jeu" name="jeu_id" required>
                <?php foreach ($resultat as $jeu) {
                    echo "<option value='".(int)$jeu['id']."'>".htmlspecialchars($jeu['nom'])."</option>";
                } ?>
            </select>
        </div>
        <div class="champ">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required>
        </div>
        <div class="champ">
            <label for="mdp">Mot de passe</label>
            <input id="mdp" name="mdp" type="password" required>
        </div>
        <button type="submit" class="bouton">S'inscrire</button>
    </form>
    
</body>
</html>

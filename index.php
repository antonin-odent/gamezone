<?php
 
session_start();
include("conf.php");
$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);
$resultat = mysqli_query($connexion, "SELECT * FROM ap3_jeu");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameZone</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<?php include("menu.php"); ?>
<main class="carte">
    <h1>GAMEZONE</h1>

    <?php if (isset($_GET["erreur"])) { echo "<p>Email ou mot de passe incorrect.</p>"; } ?>

    <?php if (!isset($_SESSION["id"])) { ?>
    <h2>Connexion</h2>
    <form method="POST" action="traitement_connexion.php">
        <div class="champ">
            <label for="email_c">Email</label>
            <input id="email_c" name="email" type="email" required>
        </div>
        <div class="champ">
            <label for="mdp_c">Mot de passe</label>
            <input id="mdp_c" name="mdp" type="password" required>
        </div>
        <button type="submit" class="bouton">Se connecter</button>
    </form>
    <?php } ?>

    
</main>

<a href="inscription.php">S'inscrire</a>
<a href="mdp.php">Mot de passe oublié ?</a>
</body>
</html>
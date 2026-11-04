<?php
session_start();
if (!isset($_SESSION["id"])) { header("Location: index.php"); exit; }   // pas connecté
if ($_SESSION["type"] != 1)  { header("Location: index.php"); exit; }   // pas admin

include("conf.php");
$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

$requete = "SELECT j.id, j.nom, j.prenom, j.email, g.nom AS nom_jeu
            FROM ap3_joueur j JOIN ap3_jeu g ON j.jeu = g.id
            ORDER BY j.prenom";
$resultat = mysqli_query($connexion, $requete);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>GameZone</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include("menu.php"); ?>
<h1>Liste des joueurs inscrits</h1>
<table border="1">
<tr><th>id</th><th>nom</th><th>prénom</th><th>email</th><th>jeu</th></tr>
<?php while ($l = mysqli_fetch_assoc($resultat)) { ?>
<tr>
    <td><?= $l['id'] ?></td>
    <td><?= htmlspecialchars($l['nom']) ?></td>
    <td><?= htmlspecialchars($l['prenom']) ?></td>
    <td><?= htmlspecialchars($l['email']) ?></td>
    <td><?= htmlspecialchars($l['nom_jeu']) ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>
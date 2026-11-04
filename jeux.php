<?php
session_start();
if (!isset($_SESSION['id'])) { header('Location: index.php'); exit; }
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
    <?php include('menu.php'); ?>
    <h1>Liste des jeux disponibles</h1>

<?php

include("conf.php");
$connexion = mysqli_connect($serveur,$user,$mdp,$nombdd);

$requete= "Select * from ap3_jeu";  
$resultat = mysqli_query($connexion, $requete);
echo "<table border=1><tr>
        <th>nom du jeu</th>
        <th>description</th>
        <th>logo</th>";

    while($ligne = mysqli_fetch_assoc($resultat))
    {
        echo "<tr><td>".$ligne['nom']."</td>" ;
        echo "<td>".htmlspecialchars($ligne['description'])."</td>" ;
        echo '<td><img src="images/jeux/' . htmlspecialchars($ligne['logo'], ) . '" alt="' . htmlspecialchars($ligne['logo'], ) . '"></td>';
       

        

    }
    echo "</table>";


?>
<a href="index.php">Retour a l'acceuil
</a>



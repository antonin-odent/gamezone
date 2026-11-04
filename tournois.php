<?php
session_start();
require_once("conf.php");

$connexion = mysqli_connect($serveur,$user,$mdp,$nombdd);

$sql = "SELECT t.id,
               t.nom AS tournoi,
               t.date,
               j.nom AS jeu
        FROM ap3_tournoi t
        JOIN ap3_jeu j ON t.jeu_id = j.id
        ORDER BY t.date";

$result = mysqli_query($connexion,$sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tournois</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Liste des tournois</h1>

<table>
    <tr>
        <th>Tournoi</th>
        <th>Date</th>
        <th>Jeu</th>
        <th>Détail</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) : ?>

        <tr>
            <td><?= htmlspecialchars($row["tournoi"]) ?></td>
            <td><?= htmlspecialchars($row["date"]) ?></td>
            <td><?= htmlspecialchars($row["jeu"]) ?></td>

            <td>
                <a href="tournoi.php?id=<?= $row['id'] ?>">
                    Voir
                </a>
            </td>
        </tr>

    <?php endwhile; ?>

</table>

<a href="index.php">
        Retour à l'accueil
</a>

<?php if(isset($_SESSION["type"]) && $_SESSION["type"] == 1) : ?>

    <br>

    <a href="ajouter_tournoi.php">
        Ajouter un tournoi
    </a>
   

<?php endif; ?>
 

</body>
</html>
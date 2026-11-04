<?php
session_start();
require_once("conf.php");

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

if (!$connexion) {
    die("Erreur connexion BDD : " . mysqli_connect_error());
}

if (!isset($_SESSION["type"]) || $_SESSION["type"] != 1) {
    die("Accès interdit.");
}

if (!isset($_GET["id"])) {
    die("Tournoi introuvable.");
}

$tournoi_id = (int)$_GET["id"];

$sql = "SELECT
            i.joueur_id,
            i.tournoi_id,
            j.nom,
            j.prenom,
            j.email
        FROM ap3_inscrire i
        INNER JOIN ap3_joueur j
            ON i.joueur_id = j.id
        WHERE i.tournoi_id = ?";

$stmt = mysqli_prepare($connexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $tournoi_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Joueurs inscrits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Joueurs inscrits au tournoi</h1>

<table border="1">
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Action</th>
    </tr>

    <?php if (mysqli_num_rows($result) > 0) : ?>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>

            <tr>
                <td><?= htmlspecialchars($row["nom"]) ?></td>
                <td><?= htmlspecialchars($row["prenom"]) ?></td>
                <td><?= htmlspecialchars($row["email"]) ?></td>
                <td>
                    <a href="supprimer_inscription.php?joueur_id=<?= $row['joueur_id'] ?>&tournoi_id=<?= $row['tournoi_id'] ?>">
                        Supprimer
                    </a>
                </td>
            </tr>

        <?php endwhile; ?>

    <?php else : ?>

        <tr>
            <td colspan="4">Aucun joueur inscrit à ce tournoi.</td>
        </tr>

    <?php endif; ?>

</table>

<br>

<a href="tournois.php">Retour aux tournois</a>

</body>
</html>
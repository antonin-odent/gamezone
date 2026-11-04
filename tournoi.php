<?php
session_start();
require_once("conf.php");

$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);

if (!$connexion) {
    die("Erreur de connexion.");
}

if (!isset($_GET["id"])) {
    die("Tournoi non spécifié.");
}

$id = (int)$_GET["id"];

$stmt = mysqli_prepare(
    $connexion,
    "SELECT t.id,
            t.nom,
            t.date,
            j.nom AS jeu
     FROM ap3_tournoi t
     INNER JOIN ap3_jeu j ON t.jeu_id = j.id
     WHERE t.id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$tournoi = mysqli_fetch_assoc($result);

if (!$tournoi) {
    die("Tournoi introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($tournoi["nom"]) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1><?= htmlspecialchars($tournoi["nom"]) ?></h1>

<p>
    <strong>Date :</strong>
    <?= htmlspecialchars($tournoi["date"]) ?>
</p>

<p>
    <strong>Jeu :</strong>
    <?= htmlspecialchars($tournoi["jeu"]) ?>
</p>

<hr>

<?php if (isset($_SESSION["id"])) : ?>

    <p>
        <a href="inscription_tournoi.php?id=<?= $tournoi['id'] ?>">
            S'inscrire au tournoi
        </a>
    </p>

<?php else : ?>

    <p>
        Connectez-vous pour vous inscrire.
    </p>

<?php endif; ?>

<?php if (isset($_SESSION["type"]) && $_SESSION["type"] == 1) : ?>

    <hr>

    <p>
        <a href="admin_tournoi.php?id=<?= $tournoi['id'] ?>">
            Voir les inscrits
        </a>
    </p>

    <p>
        <a href="modifier_tournoi.php?id=<?= $tournoi['id'] ?>">
            Modifier le tournoi
        </a>
    </p>

    <p>
        <a href="supprimer_tournoi.php?id=<?= $tournoi['id'] ?>"
           onclick="return confirm('Supprimer ce tournoi ?');">
            Supprimer le tournoi
        </a>
    </p>

<?php endif; ?>

<br>

<a href="tournois.php">
    Retour à la liste des tournois
</a>

</body>
</html>
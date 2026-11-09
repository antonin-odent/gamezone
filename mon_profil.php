<?php
session_start();
include("conf.php");


if (!isset($_SESSION["id"])) {
    header("Location: connexion.php");
    exit;
}
$id =  $_SESSION["id"];
$connexion = mysqli_connect($serveur, $user, $mdp, $nombdd);


if (isset($_POST["nom"])) {
    $nom    = mysqli_real_escape_string($connexion, $_POST["nom"]);
    $prenom = mysqli_real_escape_string($connexion, $_POST["prenom"]);
    $email  = mysqli_real_escape_string($connexion, $_POST["email"]);
    mysqli_query($connexion, "UPDATE ap3_joueur SET nom='$nom', prenom='$prenom', email='$email' WHERE id=$id");
}


if (isset($_POST["nouveau_mdp"])) {
    $hash = mysqli_real_escape_string($connexion, password_hash($_POST["nouveau_mdp"], PASSWORD_DEFAULT));
    mysqli_query($connexion, "UPDATE ap3_joueur SET mdp='$hash' WHERE id=$id");
}


$resultat = mysqli_query($connexion, "SELECT nom, prenom, email FROM ap3_joueur WHERE id=$id");
$joueur = mysqli_fetch_assoc($resultat);


$resultat = mysqli_query($connexion,
    "SELECT t.id, t.nom, t.date, j.nom AS jeu
     FROM ap3_inscrire i
     INNER JOIN ap3_tournoi t ON i.tournoi_id = t.id
     INNER JOIN ap3_jeu j ON t.jeu_id = j.id
     WHERE i.joueur_id = $id
     ORDER BY t.date");
$tournois = mysqli_fetch_all($resultat, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="profil.css?v2">
</head>
<body class="page-profil">
  <main class="carte carte--large">
    <h1>Mon profil</h1>
    <p class="sous-titre"><?= htmlspecialchars($joueur["prenom"] . " " . $joueur["nom"]) ?></p>

    <!-- 3. Modifier mes informations -->
    <section class="bloc">
      <h2 class="bloc-titre">Mes informations</h2>
      <form class="formulaire" method="post">
        <div class="duo">
          <div class="champ"><label>Nom</label>
            <input name="nom" value="<?= htmlspecialchars($joueur["nom"]) ?>" required></div>
          <div class="champ"><label>Prénom</label>
            <input name="prenom" value="<?= htmlspecialchars($joueur["prenom"]) ?>" required></div>
        </div>
        <div class="champ"><label>E-mail</label>
          <input type="email" name="email" value="<?= htmlspecialchars($joueur["email"]) ?>" required></div>
        <button class="bouton">Enregistrer</button>
      </form>
    </section>

    <section class="bloc">
      <h2 class="bloc-titre">Mot de passe</h2>
      <form class="formulaire" method="post">
        <div class="champ"><label>Nouveau mot de passe</label>
          <input type="password" name="nouveau_mdp" required></div>
        <button class="bouton">Changer</button>
      </form>
    </section>

    <!-- Mes tournois -->
    <section class="bloc">
      <h2 class="bloc-titre">Mes tournois</h2>
      <?php if (!$tournois) { ?>
        <p class="vide">Aucune inscription pour le moment.</p>
      <?php } ?>
      <ul class="liste-tournois">
        <?php foreach ($tournois as $t) { ?>
        <li class="tournoi">
          <div class="tournoi-info">
            <p class="tournoi-nom"><span class="badge"><?= htmlspecialchars($t["jeu"]) ?></span><?= htmlspecialchars($t["nom"]) ?></p>
            <p class="tournoi-date"><?= htmlspecialchars($t["date"]) ?></p>
          </div>
          <form method="post" action="desinscription.php">
            <input type="hidden" name="tournoi_id" value="<?=  $t["id"] ?>">
            <button class="bouton bouton--petit bouton--danger">Se désinscrire</button>
          </form>
        </li>
        <?php } ?>
      </ul>
    </section>

    <div class="barre-profil">
      <a class="lien" href="index.php">Accueil</a>
      <a class="lien" href="deconnexion.php">Déconnexion</a>
    </div>
  </main>
</body>
</html>
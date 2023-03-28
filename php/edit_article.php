<?php //fichier principal de l'application
session_start();
include_once('./librairies/jwt_utils.php');
include_once('./librairies/lib.php')
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/style.css">
  <title>Modifier article</title>
</head>
<script src="../js/script.js"></script>
<body>
  <?php

  if(isset($_SESSION['token'])){
    // récuperer les informations de l'utilisateur depuis le token
    $username=json_decode(jwt_decode($_SESSION['token']), true)['username'];
    $id_utilisateur=json_decode(jwt_decode($_SESSION['token']), true)['id_utilisateur'];
    $id_role=json_decode(jwt_decode($_SESSION['token']), true)['id_role'];
    $exp=json_decode(jwt_decode($_SESSION['token']), true)['exp'];
    echo'
    <p id="nomUtilisateur">'.$username.' connecté</p>
    <a href="logout.php"><button type="submit" name="boutonDeco" id="boutonDeco">Déconnexion</button></a>
    <p id="role">'.($id_role == 1 ? "Moderator" : "Publisher").'</p>';

  } else {
    header('Location: index.php');
  }
  ?>
  <h1 id="logo">API Rest Articles</h1>

  <?php
  if(isset($_POST['boutonModifier'])) {
    $id_article = $_POST['boutonModifier'];
    $data = get_one_article($id_article);
    echo '
    <div style="z-index: 3;">
      <form method="POST">
        <textarea name="contenuArtMod" id="contenuArtPub" minlength="15" maxlength="5000" required>'."test".'</textarea>
        <div id="conteneurBoutonsPub">
          <a href="index.php"><button type="button" name="boutonAnnuler" id="boutonFermer"><img style="transform: rotate(45deg);" src="../images/plus.png" alt="icone de croix" width="25"> Annuler</button></a>
          <button type="submit" name="boutonValiderModifier" id="boutonValiderModifier" formaction="index.php"><img src="../images/modifier.png" alt="image envoi avion en papier" width="20" style="padding: 2.5px;"> Modifier</button>
        </div>
      </form>
    </div>';
  }
  ?>

</body>
</html>
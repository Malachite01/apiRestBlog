<?php //fichier principal de l'application
session_start();
include('./librairies/jwt_utils.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/style.css">
  <title>Blog</title>
</head>
<script src="../js/script.js"></script>
<body>
  <?php
  if(isset($_SESSION['token'])){
    echo'
    <p id="nomUtilisateur">Connecté</p>
    <a href="logout.php"><button type="submit" name="boutonDeco" id="boutonDeco">Déconnexion</button></a>
    ';
  }else{
    echo'
    <a href="login.php"><button type="submit" name="boutonDeco" id="boutonCo">Connexion</button></a>
    ';
  }

    // récuperer les informations de l'utilisateur depuis le token
    $username=json_decode(jwt_decode($_SESSION['token']), true)['username'];
    $id_utilisateur=json_decode(jwt_decode($_SESSION['token']), true)['id_utilisateur'];
    $id_role=json_decode(jwt_decode($_SESSION['token']), true)['id_role'];
    $exp=json_decode(jwt_decode($_SESSION['token']), true)['exp'];
    
  ?>
  <button type="button" onclick="fenOpen('aCacher'),deCache('aCacher')" id="boutonAjout"><img src="../images/plus.png" alt="Icone ajouter" width="25">Ajouter un article</button>
  <div class="aCacher fenButtonOff transparent" id="formAjoutEnfant">
    <form method="POST">
      <textarea name="" id="contenuArtPub"></textarea>
      <div id="conteneurBoutonsPub">
        <button type="button" name="boutonFermer" id="boutonFermer" onclick="fenClose('aCacher')"><img style="transform: rotate(45deg);" src="../images/plus.png" alt="icone de croix" width="25"> Annuler</button>
        <button type="submit" name="boutonPublier" id="boutonPublier"><img src="../images/publier.png" alt="image envoi avion en papier" width="15" style="padding: 5px;">Publier</button>
      </div>
    </form>
  </div>
  <div class="article">
    <p>Test</p>
    <button type="submit" class="bouton boutonModifier" name="boutonModifier"><img src="../images/modifier.png" alt="image modifier" width="30"></button>
    <button type="submit" class="bouton boutonSupprimer" name="boutonSupprimer" onclick="return confirm('Etes vous sur de vouloir supprimer cet article ?');"><img src="../images/supprimer.png" alt="image supprimer" width="25" style="padding: 2.5px;"></button>
    <button type="submit" class="bouton boutonLike" name="boutonLike"><img src="../images/like.png" alt="image de like" width="25">25</button>
    <button type="submit" class="bouton boutonDislike" name="boutonDislike"><img src="../images/emptylike.png" alt="image de like" width="25" style="transform: rotate(180deg);">3</button>
  </div>
</body>
</html>
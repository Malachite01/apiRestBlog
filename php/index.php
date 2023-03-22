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
  <title>Blog</title>
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
    if($id_role != 1) {
      echo '<button type="button" onclick="fenOpen(\'aCacher\'),deCache(\'aCacher\')" id="boutonAjout"><img src="../images/plus.png" alt="Icone ajouter" width="25">Ajouter un article</button>';
    };
    if(isset($_POST['boutonDislike'])){
      $id_article = $_POST['boutonDislike'];
      //ajouter un 0 dans la bd avec le bon article et le bon user 
      dislike($id_article,$_SESSION['token']);
    }
  }else{
    echo'
    <a href="login.php"><button type="submit" name="boutonDeco" id="boutonCo">Connexion</button></a>
    <p id="role">Guest</p>
    ';

    if(isset($_POST['boutonDislike'])){
      //redirection vers la page de connexion
      header("location:login.php");
    }
  }
  ?>
  <h1 id="logo">API Rest Articles</h1>
  <!-- Ajouter un article -->
  
  <div class="aCacher fenButtonOff transparent" id="formAjoutEnfant">
    <form method="POST">
      <textarea name="contenuArtPub" id="contenuArtPub" minlength="15" maxlength="5000" required></textarea>
      <div id="conteneurBoutonsPub">
        <button type="button" name="boutonFermer" id="boutonFermer" onclick="fenClose('aCacher')"><img style="transform: rotate(45deg);" src="../images/plus.png" alt="icone de croix" width="25"> Annuler</button>
        <button type="submit" name="boutonPublier" id="boutonPublier"><img src="../images/publier.png" alt="image envoi avion en papier" width="15" style="padding: 5px;">Publier</button>
      </div>
    </form>
  </div>

  <!-- Affichage des articles -->
  <form method="POST" id="conteneurArticles">
    <?php
      $articles = get_all_articles();
      
      foreach ($articles['data'] as $article) {
        echo '
        <div class="article">
          <p class="auteurEtDateAjoutEtModif">'.get_user($article[4]) .', le '.($article[2]==null ? date('d/m/Y', strtotime($article[1])) : date('d/m/Y', strtotime($article[2])).' (modifié)').'</p>
          <p class="contenuArticle">&ensp;'.$article[3].'</p>
          <button type="submit" class="bouton boutonModifier" name="boutonModifier" value="'.$article[0].'"><img src="../images/modifier.png" alt="image modifier" width="30"></button>
          <button type="submit" class="bouton boutonSupprimer" name="boutonSupprimer" value="'.$article[0].'" onclick="return confirm(\'Etes vous sur de vouloir supprimer cet article ?\');"><img src="../images/supprimer.png" alt="image supprimer" width="25" style="padding: 2.5px;"></button>
          <button type="submit" class="bouton boutonLike" name="boutonLike" value=""><img src="'.(isset($_SESSION['token']) ? ($article[7] == $id_utilisateur ? "../images/like.png" : "../images/emptylike.png") : "../images/emptylike.png").'" alt="image de like" width="25">'.$article[5].'</button>
          <button type="submit" class="bouton boutonDislike" name="boutonDislike" value=""><img src="'.(isset($_SESSION['token']) ? ($article[7] == $id_utilisateur ? "../images/like.png" : "../images/emptylike.png") : "../images/emptylike.png").'" alt="image de dislike" width="25">'.$article[6].'</button>
        </div>
        ';
      }
    ?>

  </form>
</body>
</html>
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
    <p class="nomUtilisateur">'.($username != "admin" ? '<a href="index.php?Id_utilisateur='.$id_utilisateur.'" id="lienCliquable">'.$username.'</a>' : $username).' connecté</p>
    <a href="logout.php"><button type="submit" name="boutonDeco" id="boutonDeco">Déconnexion</button></a>
    <p id="role" '.($id_role == 1 ? "class='moderator'>Moderator <img src='../images/help.png' alt='info' style='margin-bottom: -3px;' width=15>" : "class='publisher'>Publisher <img src='../images/help.png' alt='info' style='margin-bottom: -3px;' width=15>").'</p>';
    if($id_role != 1) {
      echo '<button type="button" onclick="fenOpen(\'aCacher\'),deCache(\'aCacher\')" id="boutonAjout"><img src="../images/plus.png" alt="Icone ajouter" width="25">Ajouter un article</button>';
    };
    if(isset($_POST['boutonDislike']) || isset($_POST['boutonLike'])){    
      $avis=null;
      $id_article=null;

      if(key_exists('boutonDislike',$_POST)){
        $avis=0;
        $id_article=$_POST['boutonDislike'];

        if($id_role==1){
          header("location: voiravis.php?article=".$id_article);
        }
      }else if(key_exists('boutonLike',$_POST)){

        $avis=1;
        $id_article=$_POST['boutonLike'];

        if($id_role==1){
          header("location: voiravis.php?article=".$id_article);
        }

      }
      //ajouter un 0 ou un 1 dans la bd avec le bon article et le bon user 
      if($id_role!=1){
        avis($id_article,$_SESSION['token'],$avis);
      }
    }

    if(isset($_POST['boutonPublier'])){
      publier($_POST['contenuArtPub'],$_SESSION['token']);
    }

    // Modification d'un article dans edit, validation modif ici
    if(isset($_POST['boutonValiderModifier'])){
      modifier_article($_POST['contenuArtMod'],$_POST['boutonValiderModifier'],$_SESSION['token']);
    }
    if(isset($_POST['boutonSupprimer'])){
      supprimer($_POST['boutonSupprimer'],$_SESSION['token']);
    }
  }else{
    echo'
    <a href="login.php"><button type="submit" name="boutonDeco" id="boutonCo">Connexion</button></a>
    <p id="role" class="guest">Guest <img src="../images/help.png" alt="info" style="margin-bottom: -3px;" width=15></p>
    ';
    if(isset($_POST['boutonDislike']) || isset($_POST['boutonLike']) || isset($_POST['boutonPublier']) || isset($_POST['boutonSupprimer'])){
      //redirection vers la page de connexion
      header("Location: login.php");
    }
  }
  ?>
  <h1 id="logo">API Rest Articles</h1>
  <!-- Ajouter un article -->
  <div class="aCacher fenButtonOff transparent">
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
      //GUEST: Un utilisateur non connecté ne peut que consulter, il sera redirigé vers la page de connexion à chaque interaction
      //PUBLISHER: Un utilisateur connecté peut PUBLIER un article, modifier ou supprimer SES articles
      //MODERATOR: Un modérateur connecté NE PEUT PAS PUBLIER un article, ni modifier, mais il peut supprimer TOUS les articles et accéder a la liste de likes et dislikes
      if(isset($_GET['Id_utilisateur'])){
        $articles=recup_mes_articles($_GET['Id_utilisateur']);
        if($_GET['Id_utilisateur'] != $id_utilisateur) {
          header("location: index.php");
        }
        echo '<a href="index.php" id="boutonRetour"><button type="button" id="boutonFermer"><img src="../images/retour.png" alt="image de retour" width="20"> Retour</button></a>
        <h2 id="titreMesArticles">Mes articles</h2>'; 
      }else{
        $articles = get_all_articles();
      }
      if($articles == null) {
        echo '<p id="pasDArticles">Aucun article</p>';
      } else {
        foreach ($articles['data'] as $article) {
          echo '
          <div class="article">
            <p class="auteurEtDateAjoutEtModif">'.get_user($article[4]) .', le '.($article[2]==null ? date('d/m/Y', strtotime($article[1])) : date('d/m/Y', strtotime($article[2])).' (modifié)').'</p>
            <p class="contenuArticle">&ensp;'.$article[3].'</p>';
            if(isset($_SESSION['token'])) {
              if($id_utilisateur == $article[4] || $id_role == 1) {
                if($id_role != 1) {
                  echo "
                  <button type='submit' class='bouton boutonModifier' name='boutonModifier' formaction='edit_article.php' value='".$article[0]."'>
                    <img src='../images/modifier.png' alt='image modifier' width='30'>
                  </button>
                  <button type='submit' class='bouton boutonSupprimer' name='boutonSupprimer' value='".$article[0]."' onclick=\"return confirm('Etes vous sur de vouloir supprimer cet article ?');\">
                    <img src='../images/supprimer.png' alt='image supprimer' width='25' style='padding: 2.5px;'>
                  </button>";
                } else {
                  echo "
                  <button type='submit' class='bouton boutonSupprimer' name='boutonSupprimer' value='".$article[0]."' onclick=\"return confirm('Etes vous sur de vouloir supprimer cet article ?');\">
                    <img src='../images/supprimer.png' alt='image supprimer' width='25' style='padding: 2.5px;'>
                  </button>";
                }
              }
            }

            echo '
            <button type="submit" class="bouton boutonLike" name="boutonLike" value="'.$article[0].'"><img src="'.(isset($_SESSION['token']) ? ($article[7] == $id_utilisateur ? "../images/like.png" : "../images/emptylike.png") : "../images/emptylike.png").'" alt="image de like" width="25">'.$article[5].'</button>
            <button type="submit" class="bouton boutonDislike" name="boutonDislike" value="'.$article[0].'"><img src="'.(isset($_SESSION['token']) ? ($article[7] == $id_utilisateur ? "../images/like.png" : "../images/emptylike.png") : "../images/emptylike.png").'" alt="image de dislike" width="25">'.$article[6].'</button>
          </div>
          ';
        }
      }
    ?>

  </form>
</body>
</html>
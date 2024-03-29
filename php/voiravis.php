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
  <title>Consulter avis</title>
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

    if($id_role==1){
      if(isset($_GET['article'])){
        $var = get_utilisateur_avis($_GET['article'],$_SESSION['token']);

        $liste_likes=array();
        $liste_dislikes=array();

        for ($i=0;$i<sizeof($var);$i++){
          if($var[$i][1]==0){
            array_push($liste_dislikes,$var[$i][0]);
          }else{
            array_push($liste_likes,$var[$i][0]);
          }
        }
      }
    }
  } else {
    header('Location : auth.php');
  }
  ?>
  <h1 id="logo">API Rest Articles</h1>
  <h2 class="titreLike">Avis pour l'article id=<?php echo $_GET['article']?></h2>
  <a href="index.php" id="boutonRetour"><button type="button" id="boutonFermer"><img src="../images/retour.png" alt="image de retour" width="25"> Retour</button></a>
  <!-- Affichage des articles -->
  <div class="avis">
    <div class="conteneurAvis">
      <p class="auteurEtDateAjoutEtModif"><img src="../images/like.png" alt="like" width="30"> Personnes ayant liké</p>
      <?php
        for($i=0; $i<sizeof($liste_likes); $i++) {
          echo '<div class="unePersonne">liké par '.$liste_likes[$i].'</div>';
        }
      ?>
    </div>

    <div class="conteneurAvis">
      <p class="auteurEtDateAjoutEtModif"><img src="../images/like.png" alt="like" style="transform: rotate(180deg);" width="30"> Personnes ayant disliké</p>  
      <?php
        for($i=0; $i<sizeof($liste_dislikes); $i++) {
          echo '<div class="unePersonne">disliké par '.$liste_dislikes[$i].'</div>';
        }
      ?>
    </div>
  </div>
</body>
</html>
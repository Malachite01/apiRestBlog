<?php //fichier principal de l'application
session_start();
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
<body>
  <?php
  if(isset($_SESSION['token'])){
    echo'<p>connecté</p>
    <a href="logout.php"><button type="submit" name="boutonDeco" id="boutonDeco">Déconnexion</button></a>
    ';
  }else{
    echo'
    <a href="login.php"><button type="submit" name="boutonDeco" id="boutonCo">Connexion</button></a>
    ';
  }
  ?>
  <div class="article">
    <p>Test</p>
    <button type="submit" class="bouton boutonModifier" name="boutonModifier"><img src="../images/modifier.png" alt="image modifier" width="30"></button>
    <button type="submit" class="bouton boutonSupprimer" name="boutonSupprimer" onclick="return confirm('Etes vous sur de vouloir supprimer cet article ?');"><img src="../images/supprimer.png" alt="image supprimer" width="25" style="padding: 2.5px;"></button>
    <button type="submit" class="bouton boutonLike" name="boutonLike"><img src="../images/like.png" alt="image de like" width="25">25</button>
    <button type="submit" class="bouton boutonDislike" name="boutonDislike"><img src="../images/emptylike.png" alt="image de like" width="25" style="transform: rotate(180deg);">3</button>
  </div>
</body>
</html>
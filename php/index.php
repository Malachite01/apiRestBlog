<!DOCTYPE HTML>
<html lang="fr" style="font-family: Arial,sans-serif;">

<head>
    <meta charset="utf-8">
    <!-- importer le fichier de style -->
    <link rel="stylesheet" href="style/style.css" media="screen" type="text/css" />
    <title>bienvenue</title>
</head>

<body>
    <a href="login.php">Connexion</a>
</body>

</html>

<?php //fichier principal de l'application

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
  <div class="article">
    <p>Test</p>
    <button type="submit" class="bouton boutonModifier" name="boutonModifier"><img src="../images/modifier.png" alt="image modifier" width="30"></button>
    <button type="submit" class="bouton boutonSupprimer" name="boutonSupprimer" onclick="alert('Etes vous sur de vouloir supprimer cet article ?')"><img src="../images/supprimer.png" alt="image supprimer" width="25" style="padding: 2.5px;"></button>
    <button type="submit" class="bouton boutonLike" name="boutonLike"><img src="../images/like.png" alt="image de like" width="25">J'aime</button>
    <button type="submit" class="bouton boutonDislike" name="boutonDislike"><img src="../images/like.png" alt="image de like" width="25" style="transform: rotate(180deg);">Je n'aime pas</button>
  </div>
</body>
</html>
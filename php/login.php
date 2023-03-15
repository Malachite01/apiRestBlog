<?php 
  session_start();
  include('librairies/lib.php');
  if (isset($_POST['login']) && isset($_POST['password'])) {
    methodeBody($_POST['login'],$_POST['password']);
  }
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/style.css" >
  <title>Connexion</title>
</head>
<body>
  <div class="login-page">
    <div class="form">
      <form method="POST" class="login-form">
        <input type="text" name="login" placeholder="Adresse e-mail" />
        <input type="password" name="password" placeholder="Mot de passe" />
        <input class="button" type="submit" value="CONNEXION" />

        <p class="message">Pas de compte ? </p>
        <a id="lien-account" href="creation_compte.php">Créer un compte</a>
      </form>
    </div>
  </div>
</body>

</html>
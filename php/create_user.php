<?php 
  session_start();
  include('librairies/lib.php');
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/style.css" >
  <title>Créer un compte</title>
</head>
<body>
  <h1 class="titreLogin">Créer un compte</h1>
  <div class="login-page">
    <div class="form">
      <form method="POST" class="login-form">
        <div class="formCreation">
          <label for="login">Adresse mail : </label><input maxlength="50" minlength="3" type="email" name="login" placeholder="Adresse e-mail" required/>
          <label for="username">Nom d'utilisateur : </label><input maxlength="50" minlength="2" type="text" name="username" placeholder="Nom d'utilisateur" required/>
          <label for="password">Mot de passe : </label><input maxlength="50" minlength="2" type="password" name="password" placeholder="Mot de passe" required/>
        </div>
        <input class="button" type="submit" value="CRÉER" />
      </form>
    </div>
  </div>
</body>

</html>
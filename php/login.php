<?php session_start();
include('librairies/lib.php');
// var_dump($_POST);
if (isset($_POST['login']) && isset($_POST['password'])) {
  methodeBody($_POST['login'],$_POST['password']);
}

?>
<!DOCTYPE HTML>
<html lang="fr" style="font-family: Arial,sans-serif;">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/style_login.css" media="screen" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bienvenue</title>
</head>
<body>
    <div class="login-page">
        <div class="form">
                <form action="" method="post" class="login-form">
                    <input type="text" name="login" placeholder="Adresse e-mail" />
                    <input type="password" name="password" placeholder="Mot de passe" />
                    <input class="button" type="submit" value="Acceder">

                    <div class="texte_creer-compte">
                        <p class="message">Pas de compte ? </p>
                        <a href="creation_compte.php">Creer un compte</a>
                    </div>

                </form>
        </div>
    </div>
</body>

</html>
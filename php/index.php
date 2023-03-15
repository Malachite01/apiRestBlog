<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="fr" style="font-family: Arial,sans-serif;">

<head>
    <meta charset="utf-8">
    <!-- importer le fichier de style -->
    <link rel="stylesheet" href="style/style.css" media="screen" type="text/css" />
    <title>bienvenue</title>
</head>

<body>
    <?php

if(isset($_SESSION['token'])){
    echo"<p>connecté</p>";
}else{
    echo'<a href="login.php">Connexion</a>';
}
?>

</body>

</html>

<?php //fichier principal de l'application

?>
<?php
session_start();
include('librairies/lib.php');
if (isset($_POST['connexion']) && isset($_POST['login']) && isset($_POST['password'])) {
  // tester la validité des login/password, puis call fonction de token jwt
  
  methodeBody('login', 'password');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
</head>
<body>
  
</body>
</html>
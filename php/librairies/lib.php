<?php
include('librairies/jwt_utils.php');
function connexionBd()
{
    // informations de connection
    $SERVER = '127.0.0.1';
    $DB = 'chuckn_facts';
    $LOGIN = 'root';
    $MDP = '';
    // tentative de connexion à la BD
    try {
        // connexion à la BD
        $linkpdo = new PDO("mysql:host=$SERVER;dbname=$DB", $LOGIN, $MDP);
    } catch (Exception $e) {
        die('Erreur ! Problème de connexion à la base de données : ' . $e->getMessage());
    }
    // retourne la connection
    return $linkpdo;
}

function getId($id)
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('select * from chuckn_facts where id = :id');
    if ($req == false) {
        die('Erreur !');
    }
    // execution de la Requête sql
    $req->execute(array('id' => $id));
    if ($req == false) {
        die('Erreur !');
    }
    return $req->fetchAll();
}

function getBySignalement()
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('select * from chuckn_facts where signalement > 0');
    if ($req == false) {
        die('Erreur ! GetAll');
    }
    // execution de la Requête sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! GetAll');
    }
    return $req->fetchAll();
}

function getByVote()
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('select * from chuckn_facts where vote > 3 order by vote desc');
    if ($req == false) {
        die('Erreur ! GetAll');
    }
    // execution de la Requête sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! GetAll');
    }
    return $req->fetchAll();
}

function getByLast10()
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('select * from chuckn_facts order by id desc limit 10');
    if ($req == false) {
        die('Erreur ! GetAll');
    }
    // execution de la Requête sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! GetAll');
    }
    return $req->fetchAll();
}

function getAll()
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('select * from chuckn_facts');
    if ($req == false) {
        die('Erreur ! GetAll');
    }
    // execution de la Requête sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! GetAll');
    }
    return $req->fetchAll();
}

function post($phrase)
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('insert into chuckn_facts (phrase,vote,date_ajout,date_modif,faute, signalement) value(:phrase,0, NOW(),NOW(),0,0)');
    if ($req == false) {
        die('Erreur ! Post');
    }
    // execution de la Requête sql
    $req->execute(array(':phrase' => $phrase));
    if ($req == false) {
        die('Erreur ! Post');
    }
    // recuperation du dernier id
    $lastId = $linkpdo->lastInsertId();
    return getId($lastId);
}

function put($id, $phrase)
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('update chuckn_facts set phrase = :phrase, date_modif = NOW() where id = :id');
    if ($req == false) {
        die('Erreur ! Put');
    }
    // execution de la Requête sql
    $req->execute(array('id' => $id, ':phrase' => $phrase));
    if ($req == false) {
        die('Erreur ! Put');
    }
    // recuperation du dernier id
    return getId($id);
}

function putVotePlus1($id)
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('update chuckn_facts set vote = vote + 1 where id = :id');
    if ($req == false) {
        die('Erreur ! Put');
    }
    // execution de la Requête sql
    $req->execute(array('id' => $id));
    if ($req == false) {
        die('Erreur ! Put');
    }
    // recuperation du dernier id
    return getId($id);
}

function putVoteMoins1($id)
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('update chuckn_facts set vote = vote - 1 where id = :id');
    if ($req == false) {
        die('Erreur ! Put');
    }
    // execution de la Requête sql
    $req->execute(array('id' => $id));
    if ($req == false) {
        die('Erreur ! Put');
    }
    // recuperation du dernier id
    return getId($id);
}

function putSignalementPlus1($id)
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('update chuckn_facts set signalement = signalement + 1 where id = :id');
    if ($req == false) {
        die('Erreur ! Put');
    }
    // execution de la Requête sql
    $req->execute(array('id' => $id));
    if ($req == false) {
        die('Erreur ! Put');
    }
    // recuperation du dernier id
    return getId($id);
}

function putSignalementMoins1($id)
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('update chuckn_facts set signalement = signalement - 1 where id = :id');
    if ($req == false) {
        die('Erreur ! Put');
    }
    // execution de la Requête sql
    $req->execute(array('id' => $id));
    if ($req == false) {
        die('Erreur ! Put');
    }
    // recuperation du dernier id
    return getId($id);
}

function delete($id)
{
    $linkpdo = connexionBd();
    // preparation de la Requête sql
    $req = $linkpdo->prepare('delete from chuckn_facts where id = :id');
    if ($req == false) {
        die('Erreur ! Delete');
    }
    // execution de la Requête sql
    $req->execute(array('id' => $id));
    if ($req == false) {
        die('Erreur ! Delete');
    }
}

function isConnectionValid($login, $passwd) {
    if($login == 'admin' && $passwd == 'admin') {
        $headers = array('alg' => 'HS256', 'typ' => 'JWT');
        $payload = array('login' => $login, 'exp' => (time() + 60));
        return generate_jwt($headers, $payload);
    } else {
        return false;
    }
}


function methodeBody($login, $passwd)
{
  $data = array("login" => $_POST[$login], "password" => $_POST[$passwd]);
  $data_string = json_encode($data);
  /// Envoi de la requête
  $result = file_get_contents(
      'http://localhost/R4.01/REST/authentification.php',
      false,
      stream_context_create(array(
          'http' => array(
              'method' => 'POST', // ou PUT
              'content' => $data_string,
              'header' => array('Content-Type: application/json' . "\r\n"
                  . 'Content-Length: ' . strlen($data_string) . "\r\n")
          )
      ))
  );
  $data = json_decode($result, true);
  if($data['data'] != false) {
    $_SESSION['token'] = $data['data'];
    header('Location: client.php');
  } else {
    echo '<h2 style="color: red; position: absolute; top: 10%; left: 50%; transform: translate(-50%,-50%);">Connexion échouée</h2>';
  }
}
?>
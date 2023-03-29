<?php include_once("jwt_utils.php");
function connexionBd()
{
    // informations de connection
    $SERVER = '127.0.0.1';
    $DB = 'bd_blog';
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

function isConnectionValid($login, $passwd) {
    // requete sql de vérif
    $linkpdo=connexionBd();

    // Je récupère les informations sur le compte de l'utilisateur
    $query = "SELECT id_utilisateur, id_role FROM utilisateur WHERE username=:username AND password=:password";
    $stmt = $linkpdo->prepare($query);
    $stmt->bindParam(':username', $login, PDO::PARAM_STR);
    $stmt->bindParam(':password', $passwd, PDO::PARAM_STR);
    $stmt->execute();
    // Je récupère le nombre de résultats
    $count = $stmt->rowCount();
    
    if($count==1){
      //je resupere les informations de la personne
      $valide = $stmt->fetchAll();

      $headers = array('alg' => 'HS256', 'typ' => 'JWT');
      $payload = array('username' => $login, 'id_utilisateur'=> $valide[0][0] , 'id_role'=>$valide[0][1], 'exp' => (time() + 3600));
      return generate_jwt($headers, $payload);
      
    }else {
        return false;
    }
}

function connexion($login, $passwd)
{
  $data = array("login" => $login,"password" => $passwd);
  $data_string = json_encode($data);
  /// Envoi de la requête
  //var_dump($data_string);
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/auth.php',
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'POST', // ou PUT
            'content' => $data_string,
            'header' => array(
                'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($data_string) . "\r\n"
                )
            )
        )
    )
);
  $data = json_decode($result, true);
  //var_dump($data);
  if($data['data'] != false) {
    $_SESSION['token'] = $data['data'];  
    header('Location: index.php');
  } else {
    echo '<h2 style="color: red; position: absolute; top: 10%; left: 50%; transform: translate(-50%,-50%);">Connexion échouée</h2>';
  }
}


//!  _____________________
//! |______ARTICLES______|

function get_all_articles()
{
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/server.php',
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => array(
            )
        )   
    )
)
);    
  $data = json_decode($result, true);
  if($data['data'] != false) {
    return $data;
  }
}


function recup_mes_articles($id_utilisateur)
{
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/server.php?Id_utilisateur='.$id_utilisateur.'&params=mes_articles',
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => array(
            )
        )   
    )
)
);    
  $data = json_decode($result, true);
if($data['data']!=null) {
    return$data;
  }
}



function get_un_article($id_article)
{
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/server.php?id_article='.$id_article,
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => array(
            )
        )   
    )
)
);    
  $data = json_decode($result, true);
  //var_dump($data);
  if($data['data'] != false) {
    return$data;
  }
}

function publier($contenu, $token) {
  $data = array("contenu" => $contenu,"id_utilisateur"=>json_decode(jwt_decode($token), true)['id_utilisateur']);
  $data_string = json_encode($data);
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/server.php',
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'content' => $data_string,
            'header' => array(
                'Authorization: Bearer '.$token."\r\n"
                .'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($data_string) . "\r\n"
            )
        )   
    )
)
);    
}

function modifier_article($contenu, $id_article, $token) {
  $data = array("contenu" => $contenu, "id_article" => $id_article);
  $data_string = json_encode($data);
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/server.php',
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'PUT',
            'content' => $data_string,
            'header' => array(
                'Authorization: Bearer '.$token."\r\n"
                .'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($data_string) . "\r\n"
            )
        )   
    )
)
);    
}

function supprimer($id_article, $token) {
  return file_get_contents(
    'http://localhost/apiRestBlog/php/server.php?id_article='.$id_article,
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'DELETE',
            'header' => array(
                'Authorization: Bearer '.$token."\r\n"
            )
        )   
    )
)
);    
}

//!  _____________________
//! |____UTILISATEURS____|

function get_user($id)
{
  /// Envoi de la requête
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/server.php?Id_utilisateur='.$id,
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => array()
            )
        )
    )
);
  return json_decode($result, true)['data'][0][0];
}


function get_utilisateur_avis($id,$token)
{
  /// Envoi de la requête
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/server.php?id_article='.$id.'&params=avis',
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => array(
              'Authorization: Bearer '.$token."\r\n"
            )
            )
        )
    )
);
  return json_decode($result, true)['data'];
}

function avis($id_article,$token,$avis)
{
  $data = array("id_article" => $id_article,"id_utilisateur"=>json_decode(jwt_decode($token), true)['id_utilisateur'],"avis" => $avis);
  $data_string = json_encode($data);
  file_get_contents(
    'http://localhost/apiRestBlog/php/server.php',// mettre l'article dans le header
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'PUT', // ou PUT
            'content' => $data_string,
            'header' => array(
                'Authorization: Bearer '.$token."\r\n"
                .'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($data_string) . "\r\n"
              )
          )   
      )
  )
);    
}



function deliver_response($status, $status_message, $data)
{
    /// Paramétrage de l'entête HTTP, suite
    header("HTTP/1.1 $status $status_message");
    /// Paramétrage de la réponse retournée
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    /// Mapping de la réponse au format JSON
    $json_response = json_encode($response);
    echo $json_response;
}


?>
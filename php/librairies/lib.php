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

    //todo $mdp_test = hash('sha256', "ZEN02anWobA4ve5zxzZz" . $_POST['password']);

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

function methodeBody($login, $passwd)
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
  //var_dump($data);
  if($data['data'] != false) {
    return$data;
  }
}

//!  _____________________
//! |____UTILISATEURS____|

function get_user($id)
{
  $data = array("Id_utilisateur" => $id);
  $data_string = json_encode($data);
  /// Envoi de la requête
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/server.php',
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'content' => $data_string,
            'header' => array(
                'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($data_string) . "\r\n"
                )
            )
        )
    )
);
  return json_decode($result, true);
}

function dislike($id_article,$token)
{
  $result = file_get_contents(
    'http://localhost/apiRestBlog/php/server.php',// mettre l'article dans le header
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'PUT', // ou PUT
            'header' => array(
                'Authorization: Bearer '.$token."\r\n"

                
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



/// Envoi de la réponse au Client
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


function api_blog_actions($action, $id=null, $contenu=null){

    $linkpdo = connexionBd();

    switch ($action) {
        case 'recup_articles':
            if ($id==null){
                $req = $linkpdo->prepare('select * from article');
            }else{
                $req = $linkpdo->prepare('select * from article where id_article =:id_article');
                $req->bindParam('id_article', $id);	
            }
            break;
        
        case 'recup_utilisateur':
                $req = $linkpdo->prepare('select username from utilisateur where Id_utilisateur =:Id_utilisateur');
                $req->bindParam('Id_utilisateur', $id);	
            break;

        case 'envoie':
            $req = $linkpdo->prepare('insert into bd_blog (contenu) values (:contenu)');
            $req->bindParam('contenu', $contenu);	
            break;
        
        case 'modif':
            $req = $linkpdo->prepare('update bd_blog set contenu = :contenu where id_article = :id_article');
            $req->bindParam('id_article', $id);
            $req->bindParam('contenu', $contenu);	
            break;
       
        case 'supprime':
            $req = $linkpdo->prepare('delete from bd_blog where id_article=:id_article');
            $req->bindParam('id_article', $id);
            break;
    
        default:
            break;
    }
    $req->execute();
    if (!$req){
        return false;        
    }
    
    if($action=='recup_articles' || $action=='recup_utilisateur'){
        return $req->fetchall();
    }
}
?>
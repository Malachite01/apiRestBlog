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
  if($data['data'] != false) {
    return $data;
  }
}

function get_one_articles($id_article)
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


function api_blog_actions($action, $id_article=null, $id_utilisateur=null, $avis=null,$contenu=null){

    $linkpdo = connexionBd();

    switch ($action) {
        case 'recup_articles':
            if ($id_article==null){
                $req = $linkpdo->prepare('
                SELECT a.Id_article, a.date_pub, a.date_mod, a.contenu, a.Id_utilisateur, SUM(CASE WHEN l.avis = 1 THEN 1 ELSE 0 END) AS num_likes, SUM(CASE WHEN l.avis = 0 THEN 1 ELSE 0 END) AS num_dislikes, l.Id_utilisateur
                FROM article a
                LEFT JOIN likes l ON a.Id_article = l.Id_article
                GROUP BY a.Id_article, a.date_pub, a.date_mod, a.contenu;
                ');
            }else{
                $req = $linkpdo->prepare('select * from article where id_article =:id_article');
                $req->bindParam('id_article', $id_article);	
            }
            break;
        
        case 'recup_utilisateur':
            $req = $linkpdo->prepare('select username from utilisateur where Id_utilisateur =:Id_utilisateur');
            $req->bindParam('Id_utilisateur', $id_utilisateur);	
            break;

        case 'envoi':
            $req = $linkpdo->prepare('insert into article (date_pub, contenu, Id_utilisateur) values (NOW(), :contenu, :Id_utilisateur)');
            $req->bindParam('contenu', $contenu);	
            $req->bindParam('Id_utilisateur', $id_utilisateur);	
            break;
        
        case 'modif':
            $req = $linkpdo->prepare('update bd_blog set contenu = :contenu where id_article = :id_article');
            $req->bindParam('id_article', $id_article);
            $req->bindParam('contenu', $contenu);	
            break;
       
        case 'supprime':
            $req = $linkpdo->prepare('delete from bd_blog where id_article=:id_article');
            $req->bindParam('id_article', $id_article);
            break;

        case 'avis':
          $req = $linkpdo->prepare("replace INTO `likes`(`Id_article`, `Id_utilisateur`, `avis`) VALUES (:id_article,:id_utilisateur,:avis)");
          $req->bindParam('id_article', $id_article);
          $req->bindParam('id_utilisateur', $id_utilisateur);
          $req->bindParam('avis', $avis);
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
    }elseif($action=='avis'){
      return true;
    }
}
?>
<?php

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
              $req = $linkpdo->prepare('
              SELECT a.Id_article, a.date_pub, a.date_mod, a.contenu, a.Id_utilisateur, SUM(CASE WHEN l.avis = 1 THEN 1 ELSE 0 END) AS num_likes, SUM(CASE WHEN l.avis = 0 THEN 1 ELSE 0 END) AS num_dislikes, l.Id_utilisateur
              FROM article a
              WHERE id_article =:id_article
              LEFT JOIN likes l ON a.Id_article = l.Id_article
              GROUP BY a.Id_article, a.date_pub, a.date_mod, a.contenu;
              ');
              $req->bindParam('id_article', $id_article);	
          }
          break;

    case 'recup_likes':
      $req=$linkpdo->prepare('
      SELECT username, avis
      FROM `likes` natural join `utilisateur` 
      WHERE id_article=:id
      order by avis;');
      $req->bindParam('id',$id_article);
      break;

      case 'recup_un_article':
        $req=$linkpdo->prepare('
        SELECT *
        FROM `article` 
        WHERE id_article=:id;');
        $req->bindParam('id',$id_article);
        break;

      case 'recup_auteur':
        $req=$linkpdo->prepare('
        Select id_utilisateur
        from article
        where id_article = :id');
        $req->bindParam('id',$id_article);
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
      
      case 'modifier_article':
          $req = $linkpdo->prepare('update article set contenu = :contenu, date_mod = NOW() where id_article = :id_article');
          $req->bindParam('id_article', $id_article);
          $req->bindParam('contenu', $contenu);	
          break;
    
      case 'supprime':
        // requete à changer et mettre un on cascade sur la table likes
          $req = $linkpdo->prepare('delete from likes where id_article= :id_article ; delete from article where id_article= :id_article ');
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

  if($action=='recup_articles' || $action=='recup_utilisateur'||  $action=='recup_auteur' || $action=='recup_likes' || $action=='recup_un_article'){
    return $req->fetchall();
  }elseif($action=='avis' || $action=='envoi' || $action='supprime' || $action='modifier_article'){
    return true;
  }
}
?>
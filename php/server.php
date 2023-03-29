<?php



// traitement de toutes les requetes qu'on envoie au serveur
include_once("./librairies/jwt_utils.php");
include_once('./librairies/lib_server.php');

	/// Paramétrage de l'entête HTTP (pour la réponse au Client)
	header("Content-Type:application/json");
	// fonction pour la connexion à la bd
  $linkpdo=connexionBd();
	/// Identification du type de méthode HTTP envoyée par le client
	$http_method = $_SERVER['REQUEST_METHOD'];
	//verification du token :
	$bearer="";
	$bearer=get_bearer_token();

  switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
      if(isset($_GET["id_article"])){
        if(isset($_GET['params'])){
          if($_GET['params']=='auteur'){
            $res=api_blog_actions("recup_auteur",$_GET["id_article"]);
          }else if($_GET['params']=='avis'){
            if(is_jwt_valid($bearer)){
              $res=api_blog_actions("recup_likes",$_GET["id_article"]);
            }else{
              deliver_response(403, "Permission non accordée" , NULL);
            }
          }
        }else{
            $res=api_blog_actions("recup_un_article",$_GET["id_article"]);
        }
      }else if(isset($_GET["Id_utilisateur"])){
        if(isset($_GET['params'])){
          if($_GET['params']=='mes_articles'){
            $res=api_blog_actions("recup_mes_articles",null,$_GET["Id_utilisateur"]);
          }
        }else{
          $res=api_blog_actions("recup_utilisateur",null,$_GET["Id_utilisateur"]);
        }
      }else{
        $res=api_blog_actions("recup_articles");
      }
      
      if(!$res){
        deliver_response(500, "Erreur lors de la récupération" , NULL);
      }else{
        deliver_response(201, "Récupération réussie", $res);
      }
      break;
      
      /// Cas de la méthode POST
      case "POST" :
        if(is_jwt_valid($bearer)){
          $id_role = json_decode(jwt_decode($bearer), true)['id_role'];
          if($id_role != 1) {
            /// Récupération des données envoyées par le Client
            $postedData = file_get_contents('php://input');
            $var=json_decode($postedData, true);
            
            $res=api_blog_actions('envoi',null,$var['id_utilisateur'],null,$var['contenu']);
            
            if(!$res){ 
              deliver_response(500, "Votre publication n'a pas pu être postée" , NULL);
          }else{
            deliver_response(201, "Votre publication a été postée", NULL);
          }
        } else {
          //Moderateur ne peut pas liker ou publier
          deliver_response(403, "Permission non accordée" , NULL);
        }
      } else {
        deliver_response(401, "Token invalide" , NULL);
      }
      
      break;
      
      /// Cas de la méthode PUT (modif)
      case "PUT" :
        if(is_jwt_valid($bearer)){
          $id_role = json_decode(jwt_decode($bearer), true)['id_role'];
          //Si on n'est pas un modérateur
          if($id_role != 1) {
            /// Récupération des données envoyées par le Client
            $postedData = file_get_contents('php://input');
            $var=json_decode($postedData, true);
            
            if(isset($var['contenu'])) {
              $id_utilisateur = json_decode(jwt_decode($bearer), true)['id_utilisateur'];
              if($id_utilisateur == get_id_auteur_article($var['id_article'])['data'][0][0]) {
                $res=api_blog_actions('modifier_article',$var['id_article'], null, null, $var['contenu']);
                if(!$res){ 
                  deliver_response(500, "Erreur pour la modification de l'article" , NULL);
                }else{
                  deliver_response(201, "Article modifié", NULL);
                }
              } else {
                deliver_response(403, "Permission non accordée, vous n'êtes pas l'auteur de cette publication." , NULL);
              }
            } else {
              $res=api_blog_actions('avis',$var['id_article'], $var['id_utilisateur'],$var['avis'],null);
              if(!$res){ 
                deliver_response(500, "Erreur pour l'avis" , NULL);
              }else{
                deliver_response(201, "Avis pris en compte", NULL);
              }
            }
          } else {
            //Moderateur ne peut pas liker ou publier ou modifier
            deliver_response(403, "Permission non accordée" , NULL);
          }
        } else {
          deliver_response(401, "Token invalide" , NULL);
        }
        break;
        
        /// Cas de la méthode DELETE
        case "DELETE" :
          if(is_jwt_valid($bearer)){
            // vérifier que c'est bien l'auteur de l'article / qu'il est modérateur
            $id_role = json_decode(jwt_decode($bearer), true)['id_role'];
            $id_utilisateur = json_decode(jwt_decode($bearer), true)['id_utilisateur'];
            $auteur_article = get_id_auteur_article($_GET['id_article']);
        
            if($id_role == 1 || $id_utilisateur==$auteur_article['data'][0][0]){
              /// Récupération de l'identifiant de la ressource envoyé par le Client
              if (!empty($_GET['id_article'])){
                $res=api_blog_actions('supprime',$_GET['id_article']);
                if(!$res){
                  deliver_response(500,"Suppression échouée",NULL);
                }else{
                  deliver_response(200, "Suppression réussie", NULL);
                }
              }
            }else{
              deliver_response(403, "Permission non accordée" , NULL);
            }
          } else {
            deliver_response(401, "Token invalide" , NULL);
          }
        break;
      
        default:
          deliver_response(404, "Introuvable", NULL);
        break;
    }
    ?>
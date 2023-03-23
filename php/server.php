<?php


  // traitement de toutes les requetes qu'on envoie au serveur
  include_once("./librairies/lib.php");  
	include_once("./librairies/jwt_utils.php");

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
      if(!empty($_GET["id_article"])){
        $res=api_blog_actions("recup_articles",$_GET["id_article"]);
      }else if(!empty($_GET["Id_utilisateur"])){
        $res=api_blog_actions("recup_utilisateur",null,$_GET["Id_utilisateur"]);
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
          $var=json_decode($postedData, 'true');
  
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
        if($id_role != 1) {
          /// Récupération des données envoyées par le Client
          $postedData = file_get_contents('php://input');
          $var=json_decode($postedData, true);

          $res=api_blog_actions('avis',$var['id_article'], $var['id_utilisateur'],$var['avis'],null);
          if(!$res){ 
            deliver_response(500, "Erreur pour l'avis" , NULL);
          }else{
            deliver_response(201, "Avis pris en compte", NULL);
          }
        } else {
          //Moderateur ne peut pas liker ou publier
          deliver_response(403, "Permission non accordée" , NULL);
        }
      } else {
        deliver_response(401, "Token invalide" , NULL);
      }

      break;

    /// Cas de la méthode DELETE
    case "DELETE" :
      if(is_jwt_valid($bearer)){
        /// Récupération de l'identifiant de la ressource envoyé par le Client
        if (!empty($_GET['mon_id'])){

          $id = $_GET['mon_id'];
          
          if (!isset($_GET["id"])){
            echo(isset($_GET["id"]));
            deliver_response(400, "id invalide" , NULL);
          }
          $res=api_blog_actions('delete',$id);
          if(!$res){
            deliver_response(500,"message",NULL);
          }else{
            deliver_response(200, "Votre message", NULL);
          }
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
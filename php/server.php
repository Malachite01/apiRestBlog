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




	if(is_jwt_valid($bearer)){
    switch ($http_method){
      /// Cas de la méthode GET
      case "GET" :

        if(!empty($_GET["id_article"])){
          $id_article = $_GET["id_article"];
        }else{
          $id_article=null;
        }

        $res=api_blog_actions("recup",$id_article);

        if(!$res){
          deliver_response(500, "Erreur lors de la récupération des articles" , NULL);
        }else{
          deliver_response(201, "Récupération réussie", $res);
        }
        break;

      /// Cas de la méthode POST
      case "POST" :
        /// Récupération des données envoyées par le Client
        $postedData = file_get_contents('php://input');
        $var=json_decode($postedData, 'true');
        $phrase=$var['phrase'];

        $res=chuckn_facts_action('envoie',null,$phrase);

        if(!$res){ 
          deliver_response(500, "messsssage" , NULL);
        }else{
          deliver_response(201, "Votre message", NULL);
        }

        break;

      /// Cas de la méthode PUT (modif)
      case "PUT" :
        /// Récupération des données envoyées par le Client
        $postedData = file_get_contents('php://input');
        $var=json_decode($postedData, 'true');

        if (!isset($_GET["id"])){
          echo(isset($_GET["id"]));
          deliver_response(400, "id invalide" , NULL);
        }

        $id=$_GET["id"];
        $phrase=$var['phrase'];

        $res=modif('modif',$id, $phrase);
        if(!$res){ 
          deliver_response(500, "messsssage" , NULL);
        }else{
          deliver_response(201, "Votre message", NULL);
        }

        break;

      /// Cas de la méthode DELETE
      case "DELETE" :
        
        /// Récupération de l'identifiant de la ressource envoyé par le Client
        if (!empty($_GET['mon_id'])){

          $id = $_GET['mon_id'];

          if (!isset($_GET["id"])){
            echo(isset($_GET["id"]));
            deliver_response(400, "id invalide" , NULL);
          }

          $res=action('delete',$id);

          if(!$res){
            deliver_response(500,"message",NULL);
          }else{
            deliver_response(200, "Votre message", NULL);
          }

        }

        break;
      
      default:
          deliver_response(404, "Page introuvable", NULL);
          break;
      }
    }else{
      echo"salut";
    }
?>
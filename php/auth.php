<?php
/// Librairies éventuelles (pour la connexion à la BDD, etc.)
require_once('librairies/lib.php');

/// Paramétrage de l'entête HTTP (pour la réponse au Client)
header("Content-Type:application/json");

/// Identification du type de méthode HTTP envoyée par le client
$http_method = $_SERVER['REQUEST_METHOD'];
switch ($http_method) {
    //! Cas de la méthode POST
    case "POST":
        try {
            /// Récupération des données envoyées par le Client
            $postedData = file_get_contents('php://input');
            $postedData = json_decode($postedData, true);
            /// Traitement
            $matchingData = isConnectionValid($postedData['login'], $postedData['password']);
            $RETURN_CODE = 200;
            $STATUS_MESSAGE;
            if($matchingData != false) {
              $STATUS_MESSAGE = "Connexion réussie";
            } else {
              $STATUS_MESSAGE = "Connexion échouée";
            }
        } catch (\Throwable $th) {
            $RETURN_CODE = $th->getCode();
            $STATUS_MESSAGE = $th->getMessage();
        } finally {
            //! Envoi de la réponse au Client
            deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
        }
        break;
    default:
        $matchingData = null;
        $RETURN_CODE = 405;
        $STATUS_MESSAGE = "Méthode introuvable";
        deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
        break;
}

?>
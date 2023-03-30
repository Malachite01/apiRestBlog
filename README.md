# apiRestBlog
est une API REST de blog avec une interface utilisateur, afin de traiter GET, POST, PUT, et DELETE. Les utilisateurs sont authentifiés via un token. Le token est vérifié, afin de valider l'authenticité de l'utilisateur, et son rôle (Moderator ou Publisher).
<br><br>

<h2>Roles : </h2> &ensp;
<br>-GUEST: Est un utilisateur non connecté, qui ne peut que consulter, il sera redirigé vers la page de connexion à chaque interaction
<br><br>-PUBLISHER: Est un utilisateur connecté qui peut PUBLIER un article, consulter (en cliquant sur son nom), modifier ou supprimer SES articles
<br><br>-MODERATOR: Est un modérateur connecté, qui NE PEUT PAS PUBLIER un article, ni modifier, mais il peut supprimer TOUS les articles et accéder à la liste de likes et dislikes (en cliquant sur un like ou dislike en mode admin)
<br><br>

<h2>Hiérarchie : </h2> &ensp;
<br>-BD: L'export de la base de donnée est disponible dans le dossier BD
<br>-Postman: L'export de la collection de requêtes postman, est situé dans le dossier POSTMAN

<h2><img src="https://user-images.githubusercontent.com/112857106/223517565-8b8d33a7-2e78-4049-a2f9-46cf9899d1c7.png" style="width: 30px;">Installation : </h2> &ensp;
<br>Utiliser XAMPP et placer le projet dans le dossier htdocs. Importer la BD SQL dans phpmyadmin sous le nom de "bd_blog". Si vous souhaitez modifier les informations de connexion à la BD à votre guise, vous pouvez changer les variables situées dans la fonction connexionBD() située dans les fichiers /php/librairies/lib.php et /php/librairies/lib_server.php. Dans le cas contraire, tout devrait fonctionner directement.


<br><b><i>par Antunes Mathieu, Trochel Paul, groupe C</i></b>

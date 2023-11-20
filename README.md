# apiRestBlog
est une API REST de blog avec une interface utilisateur, afin de traiter GET, POST, PUT, et DELETE. Les utilisateurs sont authentifiés via un token. Le token est vérifié, afin de valider l'authenticité de l'utilisateur, et son rôle (Moderator ou Publisher).
<br><br>

<h2><img src="https://user-images.githubusercontent.com/112857106/223517565-8b8d33a7-2e78-4049-a2f9-46cf9899d1c7.png" style="width: 30px;">Installation : </h2> &ensp;
<br>Utiliser XAMPP (ou WAMPP) et placer le projet dans le dossier htdocs (ou www). Importer la BD SQL dans phpmyadmin sous le nom de "bd_blog". Si vous souhaitez modifier les informations de connexion à la BD à votre guise, vous pouvez changer les variables situées dans la fonction connexionBD() située dans les fichiers /php/librairies/lib.php et /php/librairies/lib_server.php. Dans le cas contraire, tout devrait fonctionner directement.
<br><br>

<h2>Rôles : </h2> 
<b><ins><span>⚠️⚠️⚠️COMME DANS LE SUJET LES RÔLES NE SONT PAS CUMULATIFS⚠️⚠️⚠️</span></ins></b>
&ensp;<br>-GUEST: Est un utilisateur non connecté, qui ne peut que consulter, il sera redirigé vers la page de connexion à chaque interaction
<br><br>-PUBLISHER: Est un utilisateur connecté qui peut PUBLIER un article, consulter (en cliquant sur son nom), modifier ou supprimer SES articles
<br><br>-MODERATOR: Est un modérateur connecté, qui NE PEUT PAS PUBLIER un article, ni modifier, mais il peut supprimer TOUS les articles et accéder à la liste de likes et dislikes (en cliquant sur un like ou dislike en mode admin)
<br><br>

<h2>Hiérarchie du projet: </h2> &ensp;
<br>-BD: L'export de la base de donnée est disponible dans le dossier BD
<br>-Postman: L'export de la collection de requêtes postman, est situé dans le dossier POSTMAN
<br><br>

<h2>Comptes disponible : </h2> &ensp;
<br>-Compte modérateur: 
  <br>&ensp;login: admin password: admin
<br><br>-Comptes publisher: 
  <br>&ensp;login: juan password: juan
  <br>&ensp;login: pedro password: pedro
  <br>&ensp;login: miguel password: miguel
  <br>&ensp;login: roberto password: roberto
<br><br>

<h2>A savoir : </h2> &ensp;
<br>-L'url d'accès du site est : http://localhost/apiRestBlog/php/index.php (normalement vous serez automatiquement redirigé à partir du dossier apiRestBlog vers index.php)
<br>-L'url d'accès du backend est : http://localhost/apiRestBlog/php/server.php
<br>-Les librairies sont dans le dossier /php/librairies/ elles sont divisées en 3 fichiers, un fichier pour les tokens (jwt_utils.php), un autre pour nos fonctions coté serveur (lib_server.php), et enfin un autre pour le coté client (lib.php)
<br>-Pour faire les requêtes postman vous aurez parfois besoin de renseigner le token dans les autorisations. Pour le récupérer une requête prénommée Get_Token permet de le récupérer, il suffit juste de renseigner vos identifiants de connexion.

<h2>Photos</h2>

![image](https://github.com/Malachite01/apiRestBlog/assets/112857106/99dd3a36-e27a-40f1-ae59-9ce835ee5a04)

![image](https://github.com/Malachite01/apiRestBlog/assets/112857106/f50a68e0-e136-4baf-8007-7ee0e940304c)

![image](https://github.com/Malachite01/apiRestBlog/assets/112857106/ffd5d584-4ea5-44ac-976a-d882c88b60fc)



<br><b><i>par Antunes Mathieu, Trochel Paul, groupe C</i></b>

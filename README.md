# Mediatekformation
## Présentation
Lien vers le dépôt d'origine dont le "README" contient la présentation de l'application d'origine :<br>
https://github.com/CNED-SLAM/mediatekformation.git<br>
## La fonctionnalité ajoutée à l'application côté front office
Voici la fonctionnalité ajoutée à la partie front office de l'application.
### Ajout d'une colonne affichant le nombre de formations par playlist dans la page des playlists avec tris croissant et décroissant et affichage de cette information sur la page de chaque playlist
La colonne souhaitée est ajoutée entre celle listant les catégories des playlists et les boutons "Voir détail" de chacune des playlists.<br>
Un bouton permettant le tri croissant sur le nombre de formations par playlist et un bouton de tri décroissant sur ce même nombre sont ajoutés juste au-dessus de la liste du nombre de formations par playlist.<br> 
![00](https://github.com/user-attachments/assets/cd1ec8a1-16f4-4dcd-97ae-02d444d67a76)<br>
La nouvelle information est également affichée sur la page de chaque playlist, en-dessous de la description de la playlist.<br>
![01](https://github.com/user-attachments/assets/2ec68dcb-0cad-4096-9e1a-0b42e9f738b0)
## Les fonctionnalités ajoutées à l'application côté back office
Voici l'ensemble des fonctionnalités ajoutées à l'application côté back office et correspondant aux différents cas d'utilisation du diagramme de cas d'utilisation suivant :<br>
![Diagramme complêt](https://github.com/user-attachments/assets/f6d5bee6-873a-4523-976d-e2b39709de4c)
### Page 1 : la gestion des formations
Cette page présente la liste des formations tout comme dans la partie front office, en permettant toutefois d'ajouter, de modifier et de supprimer des formations.<br>
La partie haute est identique à la page d'accueil (bannière), hormis le menu de navigation propre à la partie back office, le titre "Gestion des formations, playlists et catégories" et le bouton "Se déconnecter" permettant la déconnexion de l'administrateur connecté (bouton également présent dans la partie front office lorsque l'administrateur est connecté).<br>
Un bouton "Ajouter une nouvelle formation" permettant d'ajouter une formation à la liste des formations est également présent sur la page.<br>
La partie centrale contient un tableau composé de 5 colonnes :<br>
•	La 1ère colonne ("formation") contient le titre de chaque formation.<br>
•	La 2ème colonne ("playlist") contient le nom de la playlist dans laquelle chaque formation se trouve.<br>
•	La 3ème colonne ("catégories") contient la ou les catégories concernées par chaque formation (langage…).<br>
•	La 4ème colonne ("date") contient la date de parution de chaque formation.<br>
•	La 5ème colonne contient les boutons de suppression et de modification pour chaque formation.<br>
Au niveau des colonnes "formation", "playlist" et "date", 2 boutons permettent de trier les lignes en ordre croissant ("<") ou décroissant (">").<br>
Au niveau des colonnes "formation" et "playlist", il est possible de filtrer les lignes en tapant un texte : seules les lignes qui contiennent ce texte sont affichées. Si la zone est vide, le fait de cliquer sur "filtrer" permet de retrouver la liste complète.<br> 
Au niveau de la catégorie, la sélection d'une catégorie dans le combo permet d'afficher uniquement les formations qui ont cette catégorie. Le fait de sélectionner la ligne vide du combo permet d'afficher à nouveau toutes les formations.<br>
Par défaut la liste est triée sur la date par ordre décroissant (la formation la plus récente en premier).<br>
Le fait de cliquer sur le bouton d'ajout d'une formation permet d'accéder au formulaire d'ajout d'une formation détaillé plus loin.<br>
Le fait de cliquer sur le bouton de modification d'une formation permet d'accéder au formulaire de modification d'une formation détaillé plus loin.<br>
Le fait de cliquer sur le bouton de suppression d'une formation supprime la formation en question et redirige vers la page de gestion des formations mise à jour.<br>
![1](https://github.com/user-attachments/assets/bb0327c8-bc00-42c0-83e7-6dc153fb85f5)
### Formulaire 1 : ajout d'une formation
Ce formulaire n'est pas accessible par le menu mais uniquement en cliquant sur le bouton d'ajout d'une formation dans la page de gestion des formations.<br>
La partie haute est identique à la page de gestion des formations (bannière, titre, menu et bouton de déconnexion).<br>
Le bouton d'ajout d'une formation n'est toutefois logiquement plus présent.<br>
Le reste de la page contient le formulaire avec le titre "Nouvelle formation :" et les champs permettant d'indiquer le titre, la date de publication, la playlist, la ou les catégories (facultatives), la description (facultative), ainsi que l'ID de la vidéo de la formation.<br>
Tous les champs sont soit vides, soit affichent une valeur par défaut.<br>
Enfin, un bouton "Enregistrer" est présent en bas du formulaire afin d'enregistrer la nouvelle formation.<br>
![2](https://github.com/user-attachments/assets/438e4738-0671-4332-8a72-e34efc05f938)
### Formulaire 2 : modification d'une formation
Ce formulaire n'est pas accessible par le menu mais uniquement en cliquant sur le bouton de modification d'une formation dans la page de gestion des formations.<br>
La partie haute est identique à la page de gestion des formations (bannière, titre, menu et bouton de déconnexion).<br>
Le bouton d'ajout d'une formation n'est toutefois pas présent.<br>
Le reste de la page contient le formulaire avec le titre "Détail formation :" et les champs permettant d'indiquer le titre, la date de publication, la playlist, la ou les catégories (facultatives), la description (facultative), ainsi que l'ID de la vidéo de la formation.<br>
Tous les champs sont préremplis avec les informations actuelles de la formation.<br>
L'image de la formation en cours de modification est par ailleurs affichée sur la droite du formulaire.<br>
Enfin, un bouton "Enregistrer" est présent en bas du formulaire afin d'enregistrer les modifications effectuées.<br>
![3](https://github.com/user-attachments/assets/788e3edf-9fa0-4271-8daa-40ed617c4699)
### Page 2 : la gestion des playlists
Cette page présente la liste des playlists tout comme dans la partie front office, en permettant toutefois d'ajouter, de modifier et de supprimer des playlists.<br>
La partie haute est identique à la page de gestion des formations (bannière, titre, menu et bouton de déconnexion).<br>
Un bouton "Ajouter une nouvelle playlist" permettant d'ajouter une playlist à la liste des playlists est également présent sur la page.<br>
La partie centrale contient un tableau composé de 3 colonnes :<br>
•	La 1ère colonne ("playlist") contient le nom de chaque playlist.<br>
•	La 2ème colonne ("catégories") contient la ou les catégories concernées par chaque playlist (langage…).<br>
•	La 3ème colonne ("nombre de formations") le nombre de formations que compte chaque playlist.<br>
•	La 4ème colonne contient les boutons de suppression et de modification pour chaque playlist.<br>
Au niveau de la colonne "playlist", 2 boutons permettent de trier les lignes en ordre croissant ("<") ou décroissant (">"). Il est aussi possible de filtrer les lignes en tapant un texte : seules les lignes qui contiennent ce texte sont affichées. Si la zone est vide, le fait de cliquer sur "filtrer" permet de retrouver la liste complète.<br> 
Au niveau de la catégorie, la sélection d'une catégorie dans le combo permet d'afficher uniquement les playlists qui ont cette catégorie. Le fait de sélectionner la ligne vide du combo permet d'afficher à nouveau toutes les playlists.<br>
Par défaut la liste est triée sur le nom de la playlist.<br>
Le fait de cliquer sur le bouton d'ajout d'une playlist permet d'accéder au formulaire d'ajout d'une playlist détaillé plus loin.<br>
Le fait de cliquer sur le bouton de modification d'une playlist permet d'accéder au formulaire de modification d'une playlist détaillé plus loin.<br>
Le fait de cliquer sur le bouton de suppression d'une playlist (cliquable uniquement si la playlist ne contient aucune formation) supprime la playlist en question et redirige vers la page de gestion des playlists mise à jour.<br>
![4](https://github.com/user-attachments/assets/2abcb4ab-4b22-4604-b64c-28ff0ddd04e0)
### Formulaire 3 : ajout d'une playlist
Ce formulaire n'est pas accessible par le menu mais uniquement en cliquant sur le bouton d'ajout d'une playlist dans la page de gestion des playlists.<br>
La partie haute est identique à la page de gestion des playlists (bannière, titre, menu et bouton de déconnexion).<br>
Le bouton d'ajout d'une playlist n'est toutefois logiquement plus présent.<br>
Le reste de la page contient le formulaire avec le titre "Nouvelle playlist :" et les champs permettant d'indiquer le nom et la description (facultative) de la playlist.<br>
Tous les champs sont vides.<br>
Enfin, un bouton "Enregistrer" est présent en bas du formulaire afin d'enregistrer la nouvelle playlist.<br>
![5](https://github.com/user-attachments/assets/04c1a8af-8059-4931-8be6-1f412af0dd9c)
### Formulaire 4 : modification d'une playlist
Ce formulaire n'est pas accessible par le menu mais uniquement en cliquant sur le bouton de modification d'une playlist dans la page de gestion des playlists.<br>
La partie haute est identique à la page de gestion des playlists (bannière, titre, menu et bouton de déconnexion).<br>
Le bouton d'ajout d'une playlist n'est toutefois pas présent.<br>
Le reste de la page contient le formulaire avec le titre "Détail playlist :" et les champs permettant d'indiquer le nom et la description (facultative) de la playlist.<br>
Tous les champs sont préremplis avec les informations actuelles de la playlist.<br>
Les images des formations de la playlist en cours de modification sont par ailleurs affichées sur la droite du formulaire.<br>
Enfin, un bouton "Enregistrer" est présent en bas du formulaire afin d'enregistrer les modifications effectuées.<br>
![6](https://github.com/user-attachments/assets/e83bf125-023e-467e-80e0-0453941b0277)
### Page 3 : la gestion des catégories
Cette page présente la liste des catégories en permettant d'ajouter, de modifier et de supprimer des catégories.<br>
La partie haute est identique à la page de gestion des formations et à la page de gestion des playlists (bannière, titre, menu et bouton de déconnexion).<br>
Un champ permettant de saisir le nom d'une nouvelle catégorie et un bouton "Ajouter" permettant d'ajouter la nouvelle catégorie en question à la liste des catégories est également présent sur la page.<br>
La partie centrale contient un tableau composé de 2 colonnes :<br>
•	La 1ère colonne ("Nom") contient le nom de chaque catégorie.<br>
•	La 2ème colonne ("Action") contient le bouton de suppression pour chaque catégorie.<br>
Le fait de cliquer sur le bouton d'ajout d'une catégorie ajoute la catégorie en question et redirige vers la page de gestion des catégories mise à jour.<br>
Le fait de cliquer sur le bouton de suppression d'une catégorie (cliquable uniquement si la catégorie n'est comportée par aucune formation) supprime la catégorie en question et redirige vers la page de gestion des catégories mise à jour.<br>
![7](https://github.com/user-attachments/assets/b0b0e1c3-176c-4c34-9d9c-6534adbf68ff)
### Page 4 : l'authentification
Cette page présente le formulaire d'authentification permettant à l'utilisateur administrateur de se connecter à la partie back office ("admin") de l'application, une fois le bon login et le bon mot de passe saisis.<br>
La partie haute de la page ne contient que la bannière présente sur l'ensemble des pages de l'application.<br>
La partie centrale de la page contient un premier champ permettant de saisir le login et un second champ permettant de saisir le mot de passe, ainsi qu'un bouton "Se connecter" qui permet de valider les informations saisies et d'autoriser l'accès à la partie back office si ces dernières sont correctes.<br>
![8](https://github.com/user-attachments/assets/3a0162ab-5e3c-426d-bdd6-f611cd1d9b6f)
## Mode opératoire d'installation et d'utilisation de l'application en local
- Vérifier que Composer, Git et Wamserver (ou équivalent) sont installés sur l'ordinateur.<br>
- Télécharger le code de l'application en dossier "zip" et le dézipper dans le dossier dédié à contenir les projets d’application du serveur local (pour Wampserver, il s’agit du dossier "www" du dossier "wamp64") puis renommer le dossier en "mediatekformation".<br>
![9](https://github.com/user-attachments/assets/94c64519-7bd7-4a62-a9e9-88d96bf29670)<br>
- Ouvrir une fenêtre de commandes en mode administrateur, se positionner dans le dossier du projet et taper la commande "composer install" pour reconstituer le dossier vendor.<br>
- Dans l’IDE (comme Netbeans par exemple), cliquer sur l'onglet "File", puis "New Project".<br>
![10](https://github.com/user-attachments/assets/d633864c-b69f-46df-94d4-4b7db1fd8a09)<br>
- Dans la fenêtre qui s'affiche, sélectionner comme catégorie "PHP" et comme type de projet "PHP Application".<br>
![11](https://github.com/user-attachments/assets/55fbf3a2-7641-4760-b098-3358099401f9)<br>
- Dans la fenêtre suivante, saisir le nom du projet "mediatekformation" dans "Project Name", sélectionner le dossier du projet dans "Sources Folder" à l'aide du bouton "Browse" et indiquer la bonne version de PHP dans "PHP Version" (la même version de PHP que celle du serveur utilisé).<br>
- Cliquer ensuite sur le bouton "Next" jusqu'à atteindre la dernière fenêtre et cliquer sur le bouton "Finish".<br>
- Démarrer le serveur local utilisé (comme Wampserver par exemple) et se rendre dans PHPMyAdmin, se connecter à MySQL et créer la base de données "mediatekformation".<br>
- Copier le code SQL du fichier "mediatekformation.sql" présent dans le dossier du projet, le coller dans l’onglet "SQL" de la base de données "mediatekformation" sur PHPMyAdmin et cliquer sur "Exécuter".<br>
- Si PHPMyAdmin ne renvoie pas d’erreur, il est alors possible d’utiliser l’application en local, en y accédant soit par le biais de l’IDE (bouton d’exécution), soit à l’aide de l’URL http://localhost/mediatekformation/public/index.php
## Indications pour tester l'application en ligne
- Accéder à l’application mise en ligne grâce à l’URL https://mediatekformationml.infinityfreeapp.com et y naviguer.<br>
- Il est possible d'accéder à la partie back office "admin" en ajoutant "/admin" à l’URL une fois présent sur la page d’accueil de l’application et en indiquant les bonnes informations de connexion (login et mot de passe).<br>
- Il est possible d'accéder à la documentation technique de l’application grâce à l’URL https://mediatekformationml.infinityfreeapp.com/documentation-technique.<br>

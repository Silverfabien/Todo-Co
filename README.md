Todo&Co

-------

<h3>Projet 8 OpenClassroom</h3>

-------------------------------------------------------------------------------

<b>1 > Installation du projet</b>

Pour installer le projet, il vous suffit de cloner le projet graçe a cette commande dans votre invite de commande :

    git clone https://github.com/Silverfabien/Todo-Co.git

-------------------------------------------------------------------------------

<b>2 > Générer les paramètres</b>

Pour générer le fichier parameters.yml, qui contient les information de connexion à la bdd, faites la commande suivante :

    composer install

Quand le fichier parameters.yml a été générer, vous devez modifier les lignes suivantes qui devront correspondre aux
informations de votre bdd :

    parameters:
        database_host: 127.0.0.1 #Ip de la base de donnée : 127.0.0.1 = Localhost
        database_port: null      #Port : MySQL = 3306, MariaDb
        database_name: 'todo&co' #Nom de votre bdd 
        database_user: root      #Identifiant de connexion
        database_password: root  #Mot de passe de connexion

-------------------------------------------------------------------------------

<b>3 > Créer la bdd</b>

Pour créer la bdd, faites la commande suivante :

    php bin/console doctrine:database:create

Ensuite faites cette commande pour ajouter les tables :

    php bin/console doctrine:schema:update --force

Si vous souhaitez ajouté un jeux de données dans votre bdd, faites cette commande :

    php bin/console doctrine:fixtures/load
    
-------------------------------------------------------------------------------
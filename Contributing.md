<h1>Contributing</h1>

<h4>Installation du projet</h4>

Pour contribuer au projet, clone le projet sur votre machine.

Ensuite pour installer les dépendances, faites la commande `composer update`.

Modifier les données dans le fichier "parameters.yml' puis lancé les commandes suivantes :
- `php bin/console doctrine:database:create`
- `php bin/console doctrine:schema:update --force`
- `php bin/console doctrine:fixtures:load`

Ensuite connecter vous avec les identifiants : `user = admin && password = admin`.

Pour toutes modifications faites, le code devra être envoyé dans une branche sous le nom de `contributing\<NomDeVotreBranche>`.

<h4>Modification</h4>

Toutes modification devra être tester avec PhpUnit. Les tests devront être executé avec la commande `vendor/bin/phpunit`
pour vous assurer que vos modifications ne créer pas de bugs sur nos tests.

Quand vos modification sont terminer et que les tests sont valides, vous pouvez soumettre votre pull request et attendre
qu'elle soit accepter.

<h4>Les règles à respecter</h4>

Respect des norme PSR-1 / PSR-2 / PSR-4.
Veuillez vérifier si vos pratiques utilisé si elles sont faites pour symfony 3.4.
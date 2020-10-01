# LiveQuestion-Symfony4 

Réalisation d'un petit réseau social avec le framework Symfony, les utilisateurs peuvent s'inscrire, modifier leur profil, poser des questions et repondre à celles des autres et les liker.

## Contexte :

Projet personnel encadré (PPE) réalisé en équipe de 4 pour le BTS SIO SLAM.

### Technologies utilisées :

* Intégration : Bootstrap, HTML5, CSS3
* Javascript, jQuery, Ajax avec la librairie AXIOS

### Outils utilisés :

* Slack pour les échanges entre les membres
* Versionning : git, Bitbucket
* Gestion de projet : Trello

### Les développeurs :

* Axel Blanchardon
* Allan Beliez
* Youssef Guerzou
* Arnaud Lagarde


### Installation : 

Pour installer et tester notre projet: 


```
Composer install
```

Pour créer la base de donnée :

```
php bin/console doctrine:database:create
```

Pour créer la base de donnée :

```
php bin/console doctrine:database:create

php bin/console doctrine:schema:update
```

Enfin pour charger les fausses données de test avec les fixtures:

```
php bin/console doctrine:fixtures:load
```

Lancer le serveur Symfony pour lancer le projet :

```
symfony serve 
```
ou

```
php bin/console server:run
```


## Pour Tester :

les comptes pour tester le projet : 


* Mot de passe des comptes user : **Userdemo1** 
* Mot de passe du compte **Admin** : **AdminPassword**

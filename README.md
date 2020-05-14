Projet LiveQuestion dans le cadre du BTS SIO option SLAM
Description :
Réalisation d'un réseau social avec le framework Symfony, les utilisateurs une fois inscris peuvent se connecter, poser des questions et repondre à celles des autres.

Contexte :
Projet personnel encadré (PPE) réalisé en équipe de 4 pour le BTS SIO SLAM.

Technologies utilisées :
Intégration : Bootstrap, HTML5, CSS3

Animation : Javascript, jQuery, Ajax avec la librairie AXIOX

Outils utilisés :
Slack pour les échanges entre les membres de l'équipe

Versionning : git, Bitbucket

Suivi des bugs : Issues dans Bitbucket

Gestion de projet : Trello

Membres de l'équipe :
Axel Blanchardon
Allan Beliez
Youssef Guerzou
Arnaud Lagarde

Pour installer et tester notre projet:
Installer les dossiers var et vendors :
Composer install

Pour créer la base de donnée et charger les fixtures :
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load

Lancer le serveur Symfony pour lancer le projet:
symfony serve
ou bien :
php bin/console server:run

Comptes pour tester le projet
Mot de passe des comptes utilisateurs des fixtures : Userdemo1
Mot de passe Administrateur : AdminPassword


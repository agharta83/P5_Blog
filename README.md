#Projet 5 Openclassrooms - Création d'un blog personnel en PHP
Parcours Développeur d'application PHP - Symfony d'OpenClassrooms.
Architecture MVC Orienté objet.

##Code Quality
La qualité du code a été validé par Codacy. Accéder au rapport de contrôle via le badge

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1da544ccd71f461baae60e7e7a146c8c)](https://app.codacy.com/manual/agharta83/P5_Blog?utm_source=github.com&utm_medium=referral&utm_content=agharta83/P5_Blog&utm_campaign=Badge_Grade_Dashboard)

##Organisation du projet
- app => Développement du thème statique avec Bootstrap 4, SASS, jQuery, Fontawesome, ScrollMagic, Shufflejs, Trumbowyg.
Contient tous les assets (polices, images, icones).
- public => Dossier contenant le code compilé du dossier "/app" et tous les assets.
- src => Dossier contenant le MVC (dépendances utilisées : AltoRouter, League\Plates, SwiftMailer, PagerFanta)

##Installation du projet complet
- Cloner le repository 
- En ligne de commande dans le dossier désiré, saisir la commande
`git clone [NOM_DU_REPO] [NOM_DU_DOSSIER]`
- Installer la BDD exemple
- Configurer les dossiers de config en éditant et renomant les fichiers config.default.ini (pour la database) en config.ini et config-mail.default.php (pour les mails) en config-mail.php
- Installation des dépendances front (attention, assurez vous d'avoir nodejs et NPM installé avec les commandes `node -v` et `npm -v`, sinon se rendre sur le site officiel et les installer)
    - `npm install` => installer les dépendances
    - `npm start` => démarre le serveur localhost
- Installation des dépendances back (attention, assurez vous d'avoir composer installé avec la commande `composer -v`, sinon se rendre sur le site officiel et suivre les instructions pour installer Composer)
    - `composer install` => installer les dépendances PHP
- Se rendre sur votre serveur localhost pour voir le projet

###Accès à l'administration du blog sur la BDD exemple
- Login : agharta
- Password : 2121

###Accès au blog en production


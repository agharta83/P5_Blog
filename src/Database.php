<?php

namespace MyBlog;

class Database {

    public static $pdo;

    // Retourne les informations de connexion
    public static function getConfig() {

        return parse_ini_file(__DIR__ . '/config.ini');
    }

    // Connexion BDD
    public static function getDb() {

        // Si il n'y a pas de connexion
        if (empty(self::$pdo)) {

            try {

                // Infos de connexion
                $config = self::getConfig();

                // Création la connexion à la BDD
                self::$pdo = new \PDO(
                    'mysql:host='.$config['DBHOST'].';dbname='.$config['DBNAME'].';charset=utf8', // Chaine de connexion
                    $config['DBUSER'], // Nom de l'utilisateur
                    $config['DBPASSWORD'] // Mot de passe de l'utilisateur
                );
            }
            catch(\Exception $error) {

                // Il y a une erreur de connexion, on affiche un message d'erreur
                echo "Erreur de connexion à la BDD";
                var_dump($error);
                exit();
            }
        }

        // On retourne la connexion
        return self::$pdo;
    }
}
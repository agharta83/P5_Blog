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
                    $config['DBPASSWORD'], // Mot de passe de l'utilisateur
                    array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING) // Affiche les erreurs SQL à l'écran
                );
            }
            catch(\Exception $exception) {

                die('Erreur de connexion...' . $exception->getMessage());
            }
        }

        // On retourne la connexion
        return self::$pdo;
    }
}
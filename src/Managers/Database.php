<?php

namespace MyBlog\Managers;

use \PDO;
use \Exception;

abstract class Database {

    private $connexion;

    // Retourne les informations de connexion
    private function getConfig() {

        return parse_ini_file(__DIR__ . '/config.ini');
    }

    // Connexion BDD
    private function getConnexion() {

        // Si il n'y a pas de connexion
        if (empty($this->connexion)) {

            try {

                // Infos de connexion
                $config = $this->getConfig();

                // Création la connexion à la BDD
                $this->connexion = new PDO(
                    'mysql:host='.$config['DBHOST'].';dbname='.$config['DBNAME'].';charset=utf8', // Chaine de connexion
                    $config['DBUSER'], // Nom de l'utilisateur
                    $config['DBPASSWORD'], // Mot de passe de l'utilisateur
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) // Affiche les erreurs SQL à l'écran
                );
            }
            catch(Exception $exception) {

                die('Erreur de connexion : ' . $exception->getMessage());
            }
        }

        // On retourne la connexion
        return $this->connexion;
    }

    private function checkConnexion() {

        if($this->connexion === null) {
            return $this->getConnexion();
        }

        return $this->connexion;
    }

    protected function createQuery($sql, $parameters = null) {

        if ($parameters) {
            $stmt = $this->checkConnexion()->prepare($sql);
            
            $stmt->execute($parameters);

            return $stmt;
        }

        $stmt = $this->checkConnexion()->query($sql);

        return $stmt;
    }
}
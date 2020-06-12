<?php

namespace MyBlog\Managers;

use \PDO;
use \Exception;

/**
 * Connexion à la database
 */
abstract class Database {

    private $connexion;

    /**
     * Retourne les infos du fichier config pour la connexion
     *
     * @return void
     */
    private function getConfig() {

        return parse_ini_file(__DIR__ . '/config.ini');
    }

    /**
     * Récupére la connexion à la database
     *
     * @return void
     */
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

    /**
     * Vérifie si une connexion existe
     *
     * @return object
     */
    private function checkConnexion() {

        if($this->connexion === null) {
            return $this->getConnexion();
        }

        return $this->connexion;
    }

    /**
     * Création de la requete
     *
     * @param string $sql
     * @param mixed $parameters
     * @return object
     */
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
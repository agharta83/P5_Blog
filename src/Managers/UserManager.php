<?php

namespace MyBlog\Managers;

use Myblog\Models\UserModel;

/**
 * Permet de manager UserModel
 * en faisant le lien avec le controller
 */
class UserManager extends Database {

    /**
     * Convertit chaque champ de la table en propriété de l'objet UserModel
     *
     * @param strint|int|bool $row
     * @return object UserModel
     */
    private function buildObject($row)
    {
        $user = new UserModel();

        $user->setId($row['id']);
        $user->setLogin($row['login']);
        $user->setPassword($row['password']);
        $user->setEmail($row['email']);
        $user->setStatut_user($row['statut_user']);
        $user->setUser_role($row['user_role']);
        $user->setCreated_on($row['created_on']);
        $user->setFirstname($row['firstname']);
        $user->setLastname($row['lastname']);
        $user->setAvatar($row['avatar']);

        return $user;

    }    

    /**
     * Retourne un utilisateur en fonction de son Id
     *
     * @param int $id
     * @return Object UserModel
     */
    public function getUser($id) {
        
        // Construction de la requete
        $sql = '
            SELECT * FROM user 
            WHERE id = :id
        ';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $result = $this->createQuery($sql, $parameters);

        $post = $result->fetch();

        $result->closeCursor();

        return $this->buildObject($post);
    }

    // Retourne l'utilisateur associé au login
    public function findByLogin($login) {
        
        $sql = 'SELECT * FROM user WHERE login LIKE :login';

        // Traitement de la requête
        $parameters = [':login' => $login];
        $result = $this->createQuery($sql, $parameters);

        $user = $result->fetch();

        $result->closeCursor();

        return $this->buildObject($user);

    }

    // Enregistre les infos de l'user en session
    public static function login($user) {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'login' => $user->getLogin(),
            'firsname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'avatar' => $user->getAvatar(),
            'is_admin' => (bool) $user->isAdmin()
        ];
    }
}
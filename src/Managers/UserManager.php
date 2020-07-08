<?php

namespace MyBlog\Managers;

use MyBlog\Models\UserModel;
use MyBlog\Services\PaginatedQuery;
use Pagerfanta\Pagerfanta;
use MyBlog\Services\Parameter;
use MyBlog\Services\Request;

/**
 * Permet de manager UserModel
 * en faisant le lien avec le controller
 */
class UserManager extends CoreManager
{

    /**
     * Convertit chaque champ de la table en propriété de l'objet UserModel
     * et définit des valeurs par défault à certaines propriétés
     *
     * @param strint|int|bool $row
     * @return object UserModel
     */
    public function buildObject($row)
    {

        $user = new UserModel();

        $user->setId($row->id ?? null);
        $user->setLogin($row->login ?? null);
        $user->setPassword($row->password ?? null);
        $user->setEmail($row->email);
        $user->setStatut_user($row->statut_user ?? 1);
        $user->setUser_role($row->user_role ?? UserModel::USER);
        $user->setCreated_on($row->created_on ?? null);
        $user->setFirstname($row->firstname ?? null);
        $user->setLastname($row->lastname ?? null);
        $user->setAvatar($row->avatar ?? null);

        return $user;
    }

    /**
     * Retourne un utilisateur en fonction de son Id
     *
     * @param integer $id
     * @return UserModel
     */
    public function getUser($id)
    {
        // Construction de la requete
        $sql = '
            SELECT * FROM user 
            WHERE id = :id
        ';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $result = $this->createQuery($sql, $parameters);

        $user = $result->fetch(\PDO::FETCH_OBJ);

        $result->closeCursor();

        return $this->buildObject($user);
    }

    /**
     * Retourne l'utilisateur associé au login
     *
     * @param string $login
     * @return UserModel
     */
    public function findByLogin(string $login)
    {

        $sql = 'SELECT * FROM user WHERE login LIKE :login';

        // Traitement de la requête
        $parameters = [':login' => $login];
        $result = $this->createQuery($sql, $parameters);

        $user = $result->fetch(\PDO::FETCH_OBJ);

        $result->closeCursor();

        return $this->buildObject($user);
    }

    /**
     * Vérifie si un utilisateur avec cet email existe en BDD et le retourne
     *
     * @param string $email
     * @return UserModel|false
     */
    private function checkUser(string $email)
    {
        if ($user = $this->findUserByEmail($email)) {
            return $user;
        }

        return false;
    }


    /**
     * Retourne un utilisateur associé à un email
     *
     * @param string $email
     * @return UserModel|false
     */
    private function findUserByEmail(string $email)
    {
        $sql = 'SELECT * FROM user WHERE email LIKE :email';

        // Traitement de la requête
        $parameters = [':email' => $email];
        $result = $this->createQuery($sql, $parameters);

        $user = $result->fetch();

        if ($user) {
            $result->closeCursor();

            return $this->buildObject($user);
        }

        return false;
    }


    /**
     * Ajoute un utilisateur en BDD
     *
     * @param Parameter $post
     * @return UserModel
     */
    public function addUser(Parameter $post)
    {
        // On récup les infos de l'utilisateur pour les enregistrer en bdd
        $user = [];
        $user['firstname'] = $post->getParameter('firstname');
        $user['lastname'] = $post->getParameter('lastname');
        $user['email'] = $post->getParameter('email');

        //On va vérifier si l'utilisateur est déjà enregistrer ou pas
        $userObject = $this->checkUser($user['email']) ?? false;

        // Il n'est pas enregistré, on l'insére en BDD
        if (!$userObject) {
            // Initialisation des datas
            $user['created_on'] = date("Y-m-d H:i:s");

            $userObject = $this->buildObject($user);

            // On crée la requête
            $sql = "
                INSERT INTO user (
                    id,
                    login,
                    password,
                    email,
                    statut_user,
                    user_role,
                    created_on,
                    firstname,
                    lastname,
                    avatar
                )
                VALUES (
                    :id,
                    :login,
                    :password,
                    :email,
                    :statut_user,
                    :user_role,
                    :created_on,
                    :firstname,
                    :lastname,
                    :avatar
            )";

            // Traitement de la requete
            $parameters = [
                ':id' => $userObject->getId(),
                ':login' => $userObject->getLogin(),
                ':password' => $userObject->getPassword(),
                ':email' => $userObject->getEmail(),
                ':statut_user' => $userObject->getStatut_user(),
                ':user_role' => $userObject->getUser_role(),
                ':created_on' => $userObject->getCreated_on(),
                ':firstname' => $userObject->getFirstname(),
                ':lastname' => $userObject->getLastname(),
                ':avatar' => $userObject->getAvatar()
            ];
            $idUser = $this->createQuery($sql, $parameters);

            $userObject = $this->getUser($idUser);
        }

        // Il est déjà présent, on returne l'user
        return $userObject;
    }

    /**
     * Retourne le nombre d'utilisateurs
     *
     * @return integer
     */
    public function countNbUsers()
    {
        // Construction de la requête
        $sql = '
             SELECT COUNT(*) FROM user
        ';

        // Traitement de la requête
        $result = $this->createQuery($sql);

        // Return les résultats
        return $result->fetchColumn();
    }

    /**
     * Retourne la liste des utilisateurs avec la pagination
     *
     * @param integer $perpage
     * @param integer $currentPage
     * @return Pagerfanta
     */
    public function findAllUsersPaginated(int $perPage, int $currentPage)
    {
        $query = new PaginatedQuery(
            $this->checkConnexion(),
            'SELECT * FROM user ORDER BY created_on DESC',
            'SELECT COUNT(id) FROM user'
        );

        return (new Pagerfanta($query))->setMaxPerPage($perPage)->setCurrentPage($currentPage);
    }

    /**
     * Desactive un utilisateur
     *
     * @param integer $id
     * @return void
     */
    public function disable(int $id)
    {
        // On construit la requête
        $sql = 'UPDATE user SET statut_user = 0 WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $this->createQuery($sql, $parameters);
    }

    /**
     * Activation d'un utilisateur
     *
     * @param integer $id
     * @return void
     */
    public function enable(int $id)
    {
        // On construit la requête
        $sql = 'UPDATE user SET statut_user = 1 WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $this->createQuery($sql, $parameters);
    }

    /**
     * Rétrograde l'utilisateur
     *
     * @param integer $id
     * @return void
     */
    public function downgrade(int $id)
    {
        // On construit la requête
        $sql = 'UPDATE user SET user_role = :user WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id, ':user' => UserModel::USER];
        $this->createQuery($sql, $parameters);
    }

    /**
     * Création d'un nouvel utilisateur et enregistrement en BDD
     *
     * @param Parameter $post
     * @return void
     */
    public function createUser(Parameter $post)
    {

        // Initialisation
        $post->setParameter('created_on', date('Y-m-d H:i:s'));
        $post->setParameter('password', password_hash($this->generatePassword(8), PASSWORD_DEFAULT));
        // TODO Gérer l'envoi pas mail du mot de passe

        $user = $this->buildObject($post);

        $sql = '
           INSERT INTO user (
               id,
               login,
               password,
               email,
               statut_user,
               user_role,
               created_on,
               firstname,
               lastname,
               avatar
           ) VALUES (
               :id,
               :login,
               :password,
               :email,
               :statut_user,
               :user_role,
               :created_on,
               :firstname,
               :lastname,
               :avatar
           )
       ';

        $parameters = [
            ':id' => $user->getId(),
            ':login' => $user->getLogin(),
            ':password' => $user->getPassword(),
            ':email' => $user->getEmail(),
            ':statut_user' => $user->getStatut_user(),
            ':user_role' => $user->getUser_role(),
            ':created_on' => $user->getCreated_on(),
            ':firstname' => $user->getFirstname(),
            ':lastname' => $user->getLastname(),
            ':avatar' => $user->getAvatar()
        ];

        $this->createQuery($sql, $parameters);
    }

    /**
     * Génére un mot de passe
     *
     * @param integer $nbChar
     * @return string
     */
    private function generatePassword(int $nbChar)
    {
        return substr(
            str_shuffle(
                'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
            ),
            1,
            $nbChar
        );
    }

    /**
     * Met à jour en BDD les enregistrements d'un utilisateur avec les informations saisies dans le formulaire
     *
     * @param integer $id
     * @param Parameter $post
     * @param Parameter $files
     * @return void
     */
    public function updateUser($id, Parameter $post, Parameter $files)
    {
        $user = $this->findUserById($id);

        $user->setLogin($post->getParameter('login'));
        $user->setEmail($post->getParameter('email'));
        $user->setPassword(password_hash($post->getParameter('password'), PASSWORD_DEFAULT));
        $user->setFirstname($post->getParameter('firstname'));
        $user->setLastname($post->getParameter('lastname'));
        if (isset($files) && !empty($files)) {
            $user->setAvatar($files->getParameter('files')['name'][0]);
        }

        // On enregistre
        $this->save($user);
    }

    /**
     * Modifie les enregistrements liés à un utilisateur
     *
     * @param UserModel $user
     * @return void
     */
    private function save(UserModel $user)
    {
        // On crée la requête SQL
        $sql = "
                REPLACE INTO user (
                    id,
                    login,
                    password,
                    email,
                    statut_user,
                    user_role,
                    created_on,
                    firstname,
                    lastname,
                    avatar
                )
                VALUES (
                    :id,
                    :login,
                    :password,
                    :email,
                    :statut_user,
                    :user_role,
                    :created_on,
                    :firstname,
                    :lastname,
                    :avatar
                )";

        // Traitemennt de la requete
        $parameters = [
            ':login' => $user->getLogin(),
            ':password' => $user->getPassword(),
            ':email' => $user->getEmail(),
            ':statut_user' => $user->getStatut_user(),
            ':user_role' => $user->getUser_role(),
            ':created_on' => $user->getCreated_on(),
            ':firstname' => $user->getFirstname(),
            ':lastname' => $user->getLastname(),
            ':avatar' => $user->getAvatar(),
            ':id' => $user->getId()
        ];

        $this->createQuery($sql, $parameters);
    }

    /**
     * Retourne un utilisateur à partir de son Id
     *
     * @param integer $id
     * @return UserModel
     */
    private function findUserById(int $id)
    {
        $sql = 'SELECT * FROM user WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $result = $this->createQuery($sql, $parameters);

        $user = $result->fetch();

        if ($user) {
            $result->closeCursor();

            return $this->buildObject($user);
        }

        return false;
    }

    /**
     * Réinitilisation du mot de passe
     *
     * @param string $password
     * @param string $login
     * @return void
     */
    public function resetPassword($password, $login)
    {
        // Hash du password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'UPDATE user SET password = :password WHERE login = :login';

        $parameters = [':password' => $password, ':login' => $login];

        $this->createQuery($sql, $parameters);
    }

    public function sendEmail($name, $email, $message)
    {
        $data = require __DIR__ . '/config-mail.php';

        $transport = (new \Swift_SmtpTransport($data['SMTP'], 465, 'ssl'))
            ->setUsername($data['email'])
            ->setPassword($data['password']);

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Message du Blog de ' . $name))
            ->setFrom($email)
            ->setTo($data['email'])
            ->setBody($message);

        $mailer->send($message);
    }

    /**
     * Retourne les infos de l'utilisateur connecté / enregistré en session
     *
     * @return UserModel|false
     */
    public function getUserConnected()
    {

        if ($this->getSession()) {
            if (null !== $this->getSession()->get('user')) {
                return $this->getUser($this->getSession()->get('user')['id']);
            }
        }

        return false;
    }
}

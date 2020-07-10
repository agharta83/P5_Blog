<?php

namespace MyBlog\Controllers\Admin;

use Myblog\Models\UserModel;

class UserController extends CoreController
{
        /**
     * Retourne la liste des utilisateurs paginées
     *
     * @param [type] $params
     * @return void
     */
    public function list($params)
    {

        $pagination = $this->userManager->findAllUsersPaginated(6, (int) $params['page']);

        $results = $pagination->getCurrentPageResults();

        $users = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach ($results as $row) {
            $userId = $row['id'];
            $users[$userId] = $this->userManager->buildObject($row);
        }

        return $this->renderView('admin/users', [
            'users' => $users,
            'pagination' => $pagination
        ]);
    }

    /**
     * Desactive un utilisateur
     *
     * @param array $params
     * @return void
     */
    public function disable($params)
    {
        // Id de l'utilisateur à désactiver
        $id = $params['id'];
        // Page courante
        $currentPage = $params['page'];

        // On récup et désactive l'utilisateur
        $this->userManager->disable($id);

        // On redirige
        return $this->redirect('users_list', ['page' => $currentPage]);
    }

    /**
     * Activer l'utilisateur
     *
     * @param array $params
     * @return void
     */
    public function enable($params)
    {
        // Id de l'utilisateur à activer
        $id = $params['id'];
        // Page courante
        $currentPage = $params['page'];

        // On récup et active l'utilisateur
        $this->userManager->enable($id);

        // On redirige
        return $this->redirect('users_list', ['page' => $currentPage]);
    }

    /**
     * Promotion d'un utilisateur en Administrateur
     *
     * @param [type] $params
     * @return void
     */
    public function promote($params)
    {
        // Id de l'utilisateur à promouvoir
        $id = $params['id'];
        // Page courante
        $currentPage = $params['page'];

        // On récup et promeut l'utilisateur
        $this->userManager->promote($id);

        // On redirige
        return $this->redirect('users_list', ['page' => $currentPage]);
    }

    /**
     * Retrograde l'utilisateur en role User
     *
     * @param array $params
     * @return void
     */
    public function downgrade($params)
    {
        // Id de l'utilisateur à rétrograder
        $id = $params['id'];
        // Page courante
        $currentPage = $params['page'];

        // On récup et rétrograde l'utilisateur
        $this->userManager->downgrade($id);

        // On redirige
        return $this->redirect('users_list', ['page' => $currentPage]);
    }

    /**
     * Création d'un nouvel utilisateur
     *
     * @param [type] $params
     * @return void
     */
    public function create($params)
    {
        $currentPage = $params['page'];

        $user = $this->userManager->createUser($this->post);

        // On redirige
        return $this->redirect('users_list', ['page' => $currentPage]);
    }

    /**
     * Mise à jour d'un utilisateur
     *
     * @param array $params
     * @return void
     */
    public function update($params)
    {
        // Page courante
        $currentPage = $params['page'];

        if (!empty($this->post)) {
            // On check $_FILES
            $this->upload($this->files);

            $post = $this->post;

            $idPost = $post->getParameter('userId');

            $this->userManager->updateUser($idPost, $post, $this->files);
        }

        // On redirige
        return $this->redirect('users_list', ['page' => $currentPage]);
    }
}
<?php

namespace MyBlog\Controllers\Admin;

class PostController extends CoreController {

    /**
     * Permet d'afficher la liste de tous les posts avec pagination
     *
     * @param array $params
     * @return void
     */
    public function list($params)
    {

        try {
            // Récup la liste des posts en db
            $pagination = $this->postManager->findAllPostsPaginated(6, (int) $params['page']);
        } catch (\Exception $e) {
            // Gére le cas ou l'admin à supprimer le dernier article d'une page, 
            // On renvoie sur la derniére page
            $page = (int) $params['page'] - 1;
            $pagination = $this->postManager->findAllPostsPaginated(6, $page);
        }

        $results = $pagination->getCurrentPageResults();

        $posts = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach ($results as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->postManager->buildObject($row);
        }

        // On affiche le template
        return $this->renderView('admin/posts', [
            'posts' => $posts,
            'pagination' => $pagination
        ]);
    }

        /**
     * Permet de créer un post
     *
     * @return void
     */
    public function createNewPost($params)
    {
        $currentPage = $params['page'];

        // Le formulaire de création du post a été soumis
        $post = $this->post;

        if ( null !== $post->getParameter('submit') && !empty($post->getParameter('submit')) ) {

            // On check $_FILES et on upload l'image
            $this->upload($this->files);

            $this->postManager->addPost($post, $this->files);

            // On redirige
            return $this->redirect('admin_blog_list', ['page' => $currentPage]);
        }
        
        if (null !== $post->getParameter('preview') && !empty($post->getParameter('preview'))) {
            // L'utilisateur veut prévisualiser le post
            if (null !== $this->files->getParameter('name') && !empty($this->files->getParameter('name'))) {
                $this->upload($this->files);
            }

            $post = $this->postManager->preview($post, $this->files);

            // Récup des posts similaires
            $similarPosts = $this->postManager->findByCategory($post->getCategory(), $post->getSlug());

            // On affiche le template
            return $this->renderView('blog/read', ['post' => $post, 'similarPosts' => $similarPosts]);
        }
        
        // On affiche la page de création d'un nouveau post
        $headTitle = 'Dashboard / Nouveau post';

        return $this->renderView('admin/new_post', [
            'title' => $headTitle,
            'page' => $currentPage
        ]);
        
    }

    /**
     * Permet d'afficher la page d'un post dans la partie administration
     *
     * @param array $params
     * @return void
     */
    public function read($params)
    {

        // Slug du post à afficher
        $slug = $params['slug'];

        // Récup du post
        $post = $this->postManager->findBySlug($slug);

        // On affiche le template
        return $this->renderView('blog/read', ['post' => $post]);
    }

    /**
     * Supprime un post à partir de son Id
     *
     * @param array $params
     * @return void
     */
    public function delete($params)
    {
        // Id du post à supprimer
        $idPost = $params['id'];
        // Page courante
        $currentPage = $params['page'];

        // On récup et supprime le post
        $this->postManager->delete($idPost);

        // On redirige
        return $this->redirect('admin_blog_list', ['page' => $currentPage]);
    }

    /**
     * Met à jour un post en BDD
     *
     * @param array $params
     * @return void
     */
    public function update($params)
    {
        // Id du post à éditer
        $id = $params['id'];

        $currentPage = $params['page'];

        // On récupére le post
        $post = $this->postManager->find($id);

        if (null !== $this->post->getParameter('update')) {
            // On check $_FILES
            $this->upload($this->files);

            $this->postManager->updatePost($id, $this->post, $this->files);

            // On redirige
            return $this->redirect('admin_blog_list', ['page' => 1]);
        }
        
        if (null !== $this->post->getParameter('preview')) {
            // L'utilisateur veut prévisualiser le post
            if (null !== $this->files->getParameter('name') && !empty($this->files->getParameter('name'))) {
                $this->upload($this->files);
            }

            $post = $this->postManager->preview($post, $this->files);

            // Récup des posts similaires
            $similarPosts = $this->postManager->findByCategory($post->getCategory(), $post->getSlug());

            // On affiche le template
            return $this->renderView('blog/read', ['post' => $post, 'similarPosts' => $similarPosts]);
    
        }

        // On redirige
        $headTitle = 'Dashboard / Edition de post';

        return $this->renderView('admin/update_post', [
            'title' => $headTitle,
            'post' => $post
        ]);
        
    }


}
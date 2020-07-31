<?php

namespace MyBlog\Controllers;

/**
 * Classe permettant d'afficher et piloter les posts
 */
class PostController extends CoreController
{
    /**
     * Affiche la page "Blog" avec la liste des posts publiés
     *
     * @return void
     */
    public function list($params)
    {

        // Récup la liste des posts en db
        $pagination = $this->postManager->findAllPostsPublishedAndPaginated(6, (int) $params['page']);

        $results = $pagination->getCurrentPageResults();

        $posts = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach ($results as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->postManager->buildObject($row);
        }

        // On affiche le template
        return $this->renderView('blog/list', [
            'title' => 'Blog',
            'posts' => $posts,
            'pagination' => $pagination
        ]);
    }

    /**
     * Affiche la page d'un article
     *
     * @param array $params
     * @return void
     */
    public function read($params)
    {

        // Slug du post à afficher
        $slug = $params['slug'] ?? $params;

        // Récup du post
        $post = $this->postManager->findBySlug($slug);

        // Recup des commentaires
        $comments = $this->commentManager->findValidCommentsForPost($post->getId());
        // Recup du nombre de commentaires
        $nbComments = $this->commentManager->countNbCommentsForPost($post->getId());
        // Récup des posts similaires
        $similarPosts = $this->postManager->findByCategory($post->getCategory(), $post->getSlug());

        // On affiche le template
        return $this->renderView('blog/read', [
            'post' => $post,
            'comments' => $comments,
            'nbComments' => $nbComments,
            'similarPosts' => $similarPosts,
            'currentPage' => $params['page']
        ]);
    }

    public function readSingle($params) {
      // Slug du post à afficher
      $slug = $params['slug'] ?? $params;

      // Récup du post
      $post = $this->postManager->findBySlug($slug);

      // Recup des commentaires
      $comments = $this->commentManager->findValidCommentsForPost($post->getId());
      // Recup du nombre de commentaires
      $nbComments = $this->commentManager->countNbCommentsForPost($post->getId());
      // Récup des posts similaires
      $similarPosts = $this->postManager->findByCategory($post->getCategory(), $post->getSlug());

      // On affiche le template
      return $this->renderView('blog/single', [
        'post' => $post,
        'comments' => $comments,
        'nbComments' => $nbComments,
        'similarPosts' => $similarPosts
      ]);
    }
}

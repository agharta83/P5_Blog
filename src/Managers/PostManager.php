<?php

namespace MyBlog\Managers;

use MyBlog\Models\PostModel;
use MyBlog\Services\PaginatedQuery;
use Pagerfanta\Pagerfanta;
use MyBlog\Services\Parameter;
use MyBlog\Services\Validator;

/**
 * Permet de manager PostModel
 * en relation avec le controller
 */
class PostManager extends CoreManager
{

    /**
     * Convertit chaque champ de la table en propriété de l'objet PostModel
     *
     * @param Parameter|Array $row
     * @return PostModel
     */
    public function buildObject($row)
    {
        $post = new PostModel();

        if (is_array($row)) {
            $post->setId($row['id'] ?? null);
            $post->setTitle(Validator::sanitize($row['title']));
            $post->setChapo(Validator::sanitize($row['chapo']));
            $post->setContent(Validator::sanitize($row['content']));
            $post->setCreated_on($row['created_on'] ?? date('Y-m-d'));
            $post->setLast_update($row['last_update'] ?? null);
            $post->setImg(Validator::sanitize($row['img']) ?? null);
            $post->setNumber_reviews($row['number_reviews'] ?? 0);
            $post->setPublished_date($row['published_date'] ?? null);
            $post->setPublished($row['published']);
            $post->setSlug(Validator::sanitize($row['slug']));
            $post->setCategory($row['category']);
            $post->setUser_id($row['user_id']);
        }

        if ($row instanceof Parameter) {
            $post->setId($row->getParameter('id') ?? null);
            $post->setTitle(Validator::sanitize($row->getParameter('title')));
            $post->setChapo(Validator::sanitize($row->getParameter('chapo')));
            $post->setContent(Validator::sanitize($row->getParameter('content')));
            $post->setCreated_on($row->getParameter('created_on') ?? date('Y-m-d'));
            $post->setLast_update($row->getParameter('last_update') ?? null);
            $post->setImg(Validator::sanitize($row->getParameter('img')) ?? null);
            $post->setNumber_reviews($row->getParameter('number_reviews') ?? 0);
            $post->setPublished_date($row->getParameter('published_date') ?? null);
            $post->setPublished($row->getParameter('published'));
            $post->setSlug(Validator::sanitize($row->getParameter('slug')));
            $post->setCategory($row->getParameter('category'));
            $post->setUser_id($row->getParameter('user_id'));
        }

        return $post;
    }

    /**
     * Retourne la liste de tous les posts publiés avec la pagination
     *
     * @param integer $perPage
     * @param integer $currentPage
     * @return Pagerfanta
     */
    public function findAllPostsPublishedAndPaginated(int $perPage, int $currentPage)
    {

        $query = new PaginatedQuery(
            $this->checkConnexion(),
            'SELECT * FROM post WHERE published = 1',
            'SELECT COUNT(id) FROM post WHERE published = 1'
        );

        return (new Pagerfanta($query))->setMaxPerPage($perPage)->setCurrentPage($currentPage);
    }

    /**
     * Retourne la liste de tous les posts paginés
     *
     * @param integer $perPage
     * @param integer $currentPage
     * @return Pagerfanta
     */
    public function findAllPostsPaginated(int $perPage, int $currentPage)
    {
        $query = new PaginatedQuery(
            $this->checkConnexion(),
            'SELECT * FROM post ORDER BY created_on DESC',
            'SELECT COUNT(id) FROM post'
        );

        return (new Pagerfanta($query))->setMaxPerPage($perPage)->setCurrentPage($currentPage);
    }

    /**
     * Retourne un post publié à partit de son slug
     *
     * @param string $slug
     * @return PostModel
     */
    public function findBySlug($slug)
    {
        // Construction de la requete
        $sql = '
                SELECT * FROM post
                WHERE published = 1
                AND slug = :slug
            ';

        // Traitement de la requête
        $parameters = [':slug' => $slug];
        $result = $this->createQuery($sql, $parameters);

        $post = $result->fetch();

        $result->closeCursor();

        return $this->buildObject($post);
    }

  /**
   * Retourne un post à partir de son slug
   * @param $slug
   * @return PostModel
   */
    public function findBySlugForPreview($slug)
    {
      // Construction de la requete
      $sql = 'SELECT * FROM post WHERE slug = :slug';

      // Traitement de la requête
      $parameters = [':slug' => $slug];
      $result = $this->createQuery($sql, $parameters);

      $post = $result->fetch();

      $result->closeCursor();

      return $this->buildObject($post);
    }

    /**
     * Retourne un post en fonction de son ID
     *
     * @param integer $id
     * @return PostModel
     */
    public function findById(int $id)
    {
        // Construction de la requete
        $sql = '
                SELECT * FROM post
                WHERE published = 1
                AND id = :id
            ';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $result = $this->createQuery($sql, $parameters);

        $post = $result->fetch();

        $result->closeCursor();

        return $this->buildObject($post);
    }

    /**
     * Retourne le nombre de posts publiés
     *
     * @return int
     */
    public function countNbPublishedPost()
    {
        // Construction de la requête
        $sql = '
                SELECT COUNT(*) FROM post
                WHERE published = 1
            ';

        // Traitement de la requête
        $result = $this->createQuery($sql);

        // Return les résultats
        return $result->fetchColumn();
    }

    /**
     * Permet d'hydrater l'objet PostModel et l'insere en BDD en appelant la méthode save()
     *
     * @param Parameter $post
     * @param Parameter $files
     * @return void
     */
    public function addPost(Parameter $post, Parameter $files)
    {
        // On gère les datas qui ne sont pas dans le formulaire mais initialisé à chaque création d'un post
        $post->setParameter('img', $files->getParameter('files')['name'][0]);
        $post->setParameter('slug', $post->getParameter('title'));
        $post->setParameter('number_reviews', 0);

        $userManager = new UserManager();
        $post->setParameter('user_id', $userManager->getUserConnected()->getId());

        // Si le post est publié immédiatement aprés sa création, on met à jour sa date de publication et son statut
        if (null !== $post->getParameter('published') && !empty($post->getParameter('published') && $post->getParameter('published') == 'on')) {
            $post->setParameter('published_date', date("Y-m-d"));
            $post->setParameter('published', 1);
        } else if (null === ($post->getParameter('published'))) {
            $post->setParameter('published', 0);
        }

        // On va build l'objet Post avant de l'insérer
        $newPost = $this->buildObject($post);

        // On l'insére en BDD
        $this->save($newPost);
    }

    /**
     * Ajoute un nouveau post un BDD ou le modifie si il existe déjà
     *
     * @param PostModel $post
     * @return void
     */
    private function save(PostModel $post)
    {
        // On crée la requête SQL
        $sql = "
                UPDATE post SET
                    title = :title,
                    chapo = :chapo,
                    content = :content,
                    number_reviews = :number_reviews,
                    created_on = :created_on,
                    last_update = :last_update,
                    published = :published,
                    published_date = :published_date,
                    img = :img,
                    slug = :slug,
                    category = :category,
                    user_id = :user_id
                WHERE id = :id
              ";

        // Traitemennt de la requete
        $parameters = [
            ':title' => $post->getTitle(),
            ':chapo' => $post->getChapo(),
            ':content' => $post->getContent(),
            ':number_reviews' => $post->getNumber_reviews(),
            ':created_on' => date('Y-m-d'),
            ':last_update' => $post->getLast_update() ? date('Y-m-d', strtotime($post->getLast_update())) : null,
            ':published' => $post->getPublished(),
            ':published_date' => $post->getPublished_date() ? date('Y-m-d', strtotime($post->getPublished_date())) : null,
            ':img' => $post->getImg(),
            ':slug' => $post->getSlug(),
            ':category' => $post->getCategory(),
            ':user_id' => $post->getUser_id(),
            ':id' => $post->getId()
        ];


        $this->createQuery($sql, $parameters);
    }

    /**
     * Retourne un post à partir de son Id
     *
     * @param integer $id
     * @return PostModel
     */
    public function find(int $id)
    {

        // On construit la requete
        $sql = 'SELECT * FROM post WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $result = $this->createQuery($sql, $parameters);

        $post = $result->fetch();

        $result->closeCursor();

        return $this->buildObject($post);
    }

    /**
     * Supprime un post en BDD ainsi que les commentaires associés
     * grâce à une contrainte en BDD 'ON ACTION DELETE CASCADE'
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)

    {
        // On construit la requête
        $sql = 'DELETE FROM post WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $this->createQuery($sql, $parameters);
    }

    /**
     * Permet de prévisualiser un post (sans enregistrement en BDD)
     *
     * @param Parameter|PostModel $post
     * @param Parameter $files
     * @return PostModel
     */
    public function preview($post, Parameter $files)
    {
        if ($post instanceof Parameter) {
            // On gère les datas qui ne sont pas dans le formulaire mais initialisé à chaque création d'un post
            $post->setParameter('img', $files->getParameter('files')['name'][0]);
            $post->setParameter('slug', $post->getParameter('title'));
            $post->setParameter('number_reviews', 0);

            $userManager = new UserManager();
            $post->setParameter('user_id', $userManager->getUserConnected()->getId());

            // Si le post est publié immédiatement aprés sa création, on met à jour sa date de publication et son statut
            if (null !== $post->getParameter('published') && !empty($post->getParameter('published')) && $post->getParameter('published') == 'on') {
                $post->setParameter('published_date', date("Y-m-d"));
                $post->setParameter('published', 1);
            } else if (null == $post->getParameter('published')) {
                $post->setParameter('published', 0);
            }

            // On construit l'objet Post
            $newPost = $this->buildObject($post);
        }

        if ($post instanceof PostModel) {
            // On gère les datas qui ne sont pas dans le formulaire mais initialisé à chaque création d'un post
            $post->setImg($files->getParameter('files')['name'][0]);
            $post->setSlug($post->getTitle());
            $post->setNumber_reviews(0);

            $userManager = new UserManager();
            $post->setUser_id($userManager->getUserConnected()->getId());

            // Si le post est publié immédiatement aprés sa création, on met à jour sa date de publication et son statut
            if (null !== $post->getPublished() && !empty($post->getPublished()) && $post->getPublished() == 'on') {
                $post->setPublished_date(date("Y-m-d"));
                $post->setPublished(1);
            } else if (null == $post->getPublished()) {
                $post->setPublished(0);
            }

            $newPost = $post;
        }


        return $newPost;
    }

    /**
     * Mise à jour d'un post
     *
     * @param integer $id
     * @param Parameter $post
     * @param Parameter $files
     * @return void
     */
    public function updatePost(int $id, Parameter $post, Parameter $files)
    {
        // On récupére le post
        $postToUpdate = $this->find($id);

        $postToUpdate->setCategory($post->getParameter('category'));
        $postToUpdate->setTitle($post->getParameter('titre'));
        $postToUpdate->setChapo($post->getParameter('chapo'));
        $postToUpdate->setContent($post->getParameter('content'));
        $postToUpdate->setSlug($post->getParameter('titre'));
        $postToUpdate->setLast_update(date('Y-m-d'));

        // On incrémente les reviews
        $nbReviews = $postToUpdate->getNumber_reviews();
        $postToUpdate->setNumber_reviews($nbReviews + 1);

        $userManager = new UserManager();
        $postToUpdate->setUser_id($userManager->getUserConnected()->getId());

        if (null !== $post->getParameter('published') && !empty($post->getParameter('published') && $post->getParameter('published') == 'on')) {
            $postToUpdate->setPublished_date(date("Y-m-d"));
            $postToUpdate->setPublished(1);
        } else if (null == $post->getParameter('published')) {
            $postToUpdate->setPublished(0);
        }

        // On enregistre
        $this->save($postToUpdate);
    }

    /**
     * Retourne les 3 derniers posts publiés
     *
     * @return PostModel[]
     */
    public function findLastPublishedPost()
    {
        // Construction de la requête
        $sql = '
                SELECT * FROM post WHERE published_date < NOW() AND published = 1 ORDER BY published_date DESC LIMIT 3
            ';

        // Traitement de la requête
        $result = $this->createQuery($sql);

        $posts = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach ($result as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->buildObject($row);
        }

        $result->closeCursor();

        return $posts;
    }

    /**
     * Retourne les 3 dernies posts publiés d'une catégorie en particulier (similar posts)
     *
     * @param string $category
     * @param string $slug
     * @return PostModel[]
     */
    public function findByCategory(string $category, string $slug)
    {
        // Construction de la requête
        $sql = '
                SELECT * FROM post
                WHERE NOT slug = :slug
                AND published_date < NOW()
                AND published = 1
                AND category = :category
                ORDER BY published_date
                DESC LIMIT 3
            ';

        // Traitement de la requête
        $parameters = [':category' => $category, ':slug' => $slug];
        $result = $this->createQuery($sql, $parameters);

        $posts = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach ($result as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->buildObject($row);
        }

        $result->closeCursor();

        return $posts;
    }

}

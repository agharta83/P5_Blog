<section class="hero-area hero-admin bg-primary" id="parallax">

  <div class="container table-container bg-white">
    <div class="table-wrapper shadow p-3 mx-2">
      <div class="table-title pb-1 mb-1">
        <div class="row justify-content-between">
          <div class="col-sm-5">
            <h3 class="text-left tertiary-font"><b>Details </b>des posts </h3>
          </div>
          <div class="col-lg-3 m-auto">
            <button class="text-dark btn-new-post btn btn-primary w-100 p-1">
              <a href="<?= $router->generate('new_post', ['page' => $pagination->getCurrentPage()]); ?>" class="text-dark">Nouveau post</a>
            </button>
          </div>
        </div>
      </div>
      <table class="table table-hover table-fixed">
        <thead class="uppercase">
          <tr>
            <th>Titre</th>
            <th>Date de création</th>
            <th>Date de publication</th>
            <th>Dernière mise à jour</th>
            <th>Auteur</th>
            <th>Categorie</th>
            <th>Statut</th>
            <th>Corrections</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($posts as $post) {
            $this->insert('partials/admin/post_row', ['post' => $post, 'pagination' => $pagination]);
          }
          ?>
        </tbody>
      </table>

      <!-- Insert pagination -->
      <?php
      $prevPage = $pagination->hasPreviousPage() ? (string) $pagination->getPreviousPage() : null;
      $nextPage = $pagination->hasNextPage() ? (string) $pagination->getNextPage() : null;
      $nbPages = $pagination->getNbPages() ?? null;
      ?>
      <div class="clearfix">
        <div class="hint-text">Affichage de <b><?= $pagination->getCurrentPageOffsetEnd(); ?></b> posts sur <b><?= $pagination->getNbResults(); ?></b></div>
        <ul class="pagination">
          <?php if ($pagination->hasPreviousPage()) : ?>
            <li class="page-item"><a href="<?= $router->generate('admin_blog_list', ['page' => $prevPage]); ?>" class="page-link">Précédent</a></li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $nbPages; $i++) : ?>
            <?php
            $active = $pagination->getCurrentPage() == $i ? 'active' : null;
            ?>
            <li class="page-item <?= $active; ?>"><a href="<?= $router->generate('admin_blog_list', ['page' => $i]); ?>" class="page-link"><?= $i; ?></a></li>
          <?php endfor; ?>
          <?php if ($pagination->hasNextPage()) : ?>
            <li class="page-item"><a href="<?= $router->generate('admin_blog_list', ['page' => $nextPage]); ?>" class="page-link">Suivant</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="layer-bg layer-bg-admin w-100">
    <img class="img-fluid w-100" src="<?= $basePath ?>/public/images/illustrations/leaf-bg.png" alt="bg-shape">
  </div>


</section>

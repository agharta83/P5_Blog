<?php

use MyBlog\Models\PostModel; ?>

<section class="section">
  <div class="container">

    <!-- blog posts-->
    <div class="row">

      <?php foreach ($posts as $post) : ?>
        <?php $this->insert('partials/blog/list-post', ['post' => $post, 'pagination' => $pagination]); ?>
      <?php endforeach; ?>

    </div>
    <!-- /blog posts-->

    <!-- Insert pagination -->
  <?php
  $prevPage = $pagination->hasPreviousPage() ? (string) $pagination->getPreviousPage() : null;
  $nextPage = $pagination->hasNextPage() ? (string) $pagination->getNextPage() : null;
  $nbPages = $pagination->getNbPages() ?? null;
  ?>
  <div class="mt-4">
    <div class="hint-text">Affichage de <b><?= $pagination->getCurrentPageOffsetEnd(); ?></b> posts sur <b><?= $pagination->getNbResults(); ?></b></div>
    <ul class="pagination">
      <?php if ($pagination->hasPreviousPage()) : ?>
        <li class="page-item"><a href="<?= $router->generate('blog_list', ['page' => $prevPage]); ?>" class="page-link">Précédent</a></li>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $nbPages; $i++) : ?>
        <?php
        $active = $pagination->getCurrentPage() == $i ? 'active' : null;
        ?>
        <li class="page-item <?= $active; ?>"><a href="<?= $router->generate('blog_list', ['page' => $i]); ?>" class="page-link"><?= $i; ?></a></li>
      <?php endfor; ?>
      <?php if ($pagination->hasNextPage()) : ?>
        <li class="page-item"><a href="<?= $router->generate('blog_list', ['page' => $nextPage]); ?>" class="page-link">Suivant</a></li>
      <?php endif; ?>
    </ul>
  </div>
  </div>

  </div>
</section>

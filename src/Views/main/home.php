<?php
// Page d'accueil avec gestion des erreurs selon si le formulaire de connexion a retourné des erreurs ou non
if (!empty($errors)) {
  $this->layout('layout', [
    'title' => $title,
    'errors' => $errors,
    'fields' => $fields
  ]);
} else {
  $this->layout('layout', ['title' => $title]);
}
 ?>

  <!-- hero area -->
  <?php $this->insert('partials/home/hero'); ?>
  <!-- /hero area -->

  <!-- about -->
  <?php $this->insert('partials/home/about'); ?>
  <!-- /about -->

  <!-- skills -->
  <?php $this->insert('partials/home/skills'); ?>
  <!-- /skills -->

  <!-- experience -->
  <?php $this->insert('partials/home/experience'); ?>
  <!-- ./experience -->

  <!-- education -->
  <?php $this->insert('partials/home/education'); ?>
  <!-- /education -->

  <!-- portfolio -->
  <?php //$this->insert('partials/home/portfolio'); ?>
  <!-- /portfolio -->

  <!-- blogs -->
  <?php $this->insert('partials/home/blogs', ['posts' => $posts]); ?>
  <!-- /blog -->

  <!-- contact -->
  <?php $this->insert('partials/contact'); ?>
  <!-- /contact -->

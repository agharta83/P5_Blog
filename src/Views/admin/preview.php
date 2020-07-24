<?php $this->layout('layout'); ?>

<!-- page title -->
<?php $this->insert('partials/hero2'); ?>
<!-- /page title -->

<?php $this->insert('partials/admin/preview', [
  'post' => $post ?? null,
  'comments' => $comments ?? null,
  'nbComments' => $nbComments ?? null,
  'similarPosts' => $similarPosts ?? null,
  'currentPage' => $currentPage ?? null
]) ?>

<!-- contact -->
<?php $this->insert('partials/contact'); ?>
<!-- /contact -->

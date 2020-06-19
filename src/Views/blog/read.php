<?php $this->layout('layout'); ?>

<!-- page title -->
<?php $this->insert('partials/hero2'); ?>
  <!-- /page title -->

<?php $this->insert('partials/blog/blog-single', [
  'post' => $post ?? null,
  'comments' => $comments ?? null,
  'nbComments' => $nbComments ?? null,
  'similarPosts' => $similarPosts ?? null
]) ?>

<!-- contact -->
<?php $this->insert('partials/contact'); ?>
<!-- /contact -->
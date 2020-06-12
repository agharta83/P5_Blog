<?php $this->layout('layout'); ?>

<!-- page title -->
<?php $this->insert('partials/hero2'); ?>
  <!-- /page title -->

<?php $this->insert('partials/blog/blog-single', [
  'post' => $post,
  'comments' => $comments,
  'nbComments' => $nbComments
]) ?>

<!-- contact -->
<?php $this->insert('partials/contact'); ?>
<!-- /contact -->
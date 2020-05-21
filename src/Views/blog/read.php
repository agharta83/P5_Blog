<?php $this->layout('layout'); ?>

<!-- page title -->
<?php $this->insert('partials/hero2'); ?>
  <!-- /page title -->

<?php $this->insert('partials/blog/blog-single', ['cpt' => $id]) ?>

<!-- contact -->
<?php $this->insert('partials/contact'); ?>
<!-- /contact -->
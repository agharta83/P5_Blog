<?php $this->layout('portfolio_layout'); ?>

<!-- page title -->
<?php $this->insert('partials/hero2'); ?>
  <!-- /page title -->

<?php $this->insert('partials/portfolio/project-single', ['cpt' => $id]) ?>

<!-- contact -->
<?php $this->insert('partials/contact'); ?>
<!-- /contact -->
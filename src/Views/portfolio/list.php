<?php $this->layout('layout', ['title' => $title]); ?>

  <!-- page title -->
  <?php $this->insert('partials/hero2', ['title' => $title]); ?>
  <!-- /page title -->

    <!-- portfolio -->
    <?php $this->insert('partials/portfolio/list'); ?>
  <!-- /portfolio -->

 <!-- contact -->
 <?php $this->insert('partials/contact'); ?>
<!-- /contact -->
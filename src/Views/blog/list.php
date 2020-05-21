<?php $this->layout('layout', ['title' => $title]); ?>
 
 <!-- page title -->
  <?php $this->insert('partials/hero2', ['title' => $title]); ?>
  <!-- /page title -->

  <!-- blog -->
  <?php $this->insert('partials/blog/list'); ?>
  <!-- /blog -->

  <!-- contact -->
  <?php $this->insert('partials/contact'); ?>
  <!-- /contact -->
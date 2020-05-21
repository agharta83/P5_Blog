<?php $this->layout('blog_layout', ['title' => $title]); ?>
 
 <!-- page title -->
  <?php $this->insert('partials/hero2', ['title' => $title]); ?>
  <!-- /page title -->

  <!-- blog -->
  <?php $this->insert('partials/blog/blogList'); ?>
  <!-- /blog -->

  <!-- contact -->
  <?php $this->insert('partials/contact'); ?>
  <!-- /contact -->
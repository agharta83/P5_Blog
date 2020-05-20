<?php $this->layout('about_layout', ['title' => $title]); ?>

    <!-- page title -->
    <?php $this->insert('partials/about/hero'); ?>
    <!-- /page title -->

    <!-- about -->
    <?php $this->insert('partials/about/about'); ?>
    <!-- /about -->

    <!-- services -->
    <?php $this->insert('partials/about/services'); ?>
    <!-- /services -->

    <!-- contact -->
    <?php $this->insert('partials/contact'); ?>
    <!-- /contact -->

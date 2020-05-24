<?php use MyBlog\Models\PostModel; ?>

<section class="section">
    <div class="container">
      <!-- btn tabs shuffle -->
      <div class="row mb-5">
        <div class="col-8 mx-auto">
          <div class="btn-group btn-group-toggle justify-content-center d-flex" data-toggle="buttons">
            <label class="btn btn-sm btn-primary active">
              <input type="radio" name="shuffle-filter" value="all" checked="checked" />Tout
            </label>
            <label class="btn btn-sm btn-primary">
              <input type="radio" name="shuffle-filter" value="<?= PostModel::FRONT; ?>" />Front
            </label>
            <label class="btn btn-sm btn-primary">
              <input type="radio" name="shuffle-filter" value="<?= PostModel::BACK; ?>" />Back
            </label>
            <label class="btn btn-sm btn-primary">
              <input type="radio" name="shuffle-filter" value="<?= PostModel::GESTION_DE_PROJET; ?>" />Gestion de projet
            </label>
          </div>
        </div>
      </div>
      <!-- /btn tabs shuffle -->

      <!-- blog posts-->
      <div class="row shuffle-wrapper">

        <?php foreach($posts as $post) : ?>
          <?php $this->insert('partials/blog/list-post', ['post' => $post]); ?>
        <?php endforeach; ?>

      </div>
      <!-- /blog posts-->
    </div>
  </section>
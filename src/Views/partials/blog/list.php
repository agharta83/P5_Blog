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
              <input type="radio" name="shuffle-filter" value="front" />Front
            </label>
            <label class="btn btn-sm btn-primary">
              <input type="radio" name="shuffle-filter" value="back" />Back
            </label>
            <label class="btn btn-sm btn-primary">
              <input type="radio" name="shuffle-filter" value="gestion" />Gestion de projet
            </label>
          </div>
        </div>
      </div>
      <!-- /btn tabs shuffle -->

      <!-- blog posts-->
      <div class="row shuffle-wrapper">

        <?php for ($i = 0; $i <= 5; $i++) : ?>
          <?php $this->insert('partials/blog/list-post', ['cpt' => $i]); ?>
        <?php endfor; ?>

      </div>
      <!-- /blog posts-->
    </div>
  </section>
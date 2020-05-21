<section class="section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-8 mx-auto">
            <div class="btn-group btn-group-toggle justify-content-center d-flex" data-toggle="buttons">
              <label class="btn btn-sm btn-primary active">
              <input type="radio" name="shuffle-filter" value="all" checked="checked" />All
            </label>
            <label class="btn btn-sm btn-primary">
              <input type="radio" name="shuffle-filter" value="design" />UI/UX Design
            </label>
            <label class="btn btn-sm btn-primary">
              <input type="radio" name="shuffle-filter" value="branding" />BRANDING
            </label>
            <label class="btn btn-sm btn-primary">
              <input type="radio" name="shuffle-filter" value="illustration" />ILLUSTRATION
            </label>
          </div>
        </div>
      </div>
      <div class="row shuffle-wrapper">

      <?php for ($i = 0; $i <= 10; $i++) : ?>
        <?php if ($i == 0 || $i == 6) : ?>
          <?php $this->insert('partials/portfolio/list-project-2', ['cpt' => $i]); ?>
          <?php else : ?>
            <?php $this->insert('partials/portfolio/list-project', ['cpt' => $i]); ?>
          <?php endif; ?>
      <?php endfor; ?>

      </div>
    </div>
    </section>
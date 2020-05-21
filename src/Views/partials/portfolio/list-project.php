<div class="col-lg-4 col-6 mb-4 card-container shuffle-item" data-groups="[&quot;branding&quot;]">
          <div class="card-flip">
            <!-- Front card-->
            <div class="card-front">
              <img src="<?=$basePath?>/public/images/portfolio/item-2.png" alt="portfolio-image" class="img-fluid rounded w-100">
              <h4 class="front-card-title text-white bold">Project n°<?= $cpt; ?></h4>
            </div>
            <!-- Back card -->
            <div class="card-back">
              <div class="card-header">
                Featured
              </div>
              <div class="card-block">
                <h4 class="card-title">Special title treatment</h4>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a class="btn btn-light btn-sm" href="<?= $router->generate('portfolio_read', ['id' => $cpt]); ?>">voir le projet</a>
              </div>
            </div>
          </div>
        </div>
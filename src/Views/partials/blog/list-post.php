<div class="col-lg-4 col-sm-6 mb-4 shuffle-item" data-groups="[&quot;front&quot;]">
          <article class="card shadow-post">
            <img class="rounded card-img-top" src="<?=$basePath?>/public/images/blog/post-5.jpg" alt="post-thumb">
            <div class="card-body">
              <h4 class="card-title"><a class="text-dark" href="blog-single.html">Post n°<?= $cpt; ?></a>
              </h4>
              <p class="cars-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                incididunt ut labore et
                dolore magna aliqua.</p>
              <p class="card-text">
                <small>
                  <i class="fas fa-eye px-1"></i>1000
                  <i class="far fa-user pl-3 pr-1"></i>admin
                  <i class="fas fa-calendar-alt pl-3 pr-1"></i>Jan 20, 2018
                </small>
              </p>
              <div class="post-footer d-flex justify-content-between">
                <a href="<?= $router->generate('blog_read', ['id' => $cpt]); ?>" class="btn btn-xs btn-primary">Lire la suite</a>
                <span class="badge badge-secondary d-table px-3 py-2">Front</span>
              </div>
              
            </div>
          </article>
        </div>
<?php use MyBlog\Services\Validator; ?>
<div class="col-lg-4 col-sm-6 mb-4 shuffle-item" data-groups="[&quot;<?= $post->getCategory();?>&quot;]">
          <article class="card shadow-post">
            <img class="rounded card-img-top" src="<?=$basePath . $post->getImg(); ?>" alt="post-thumb">
            <div class="card-body">
              <h4 class="card-title"><a class="text-dark" href="<?= $router->generate('blog_read', ['slug' => $post->getSlug()]); ?>"><?= $post->getTitle() ?></a>
              </h4>
              <p class="cars-text"><?php echo $post->cut_string(Validator::decode($post->getChapo()), 250); ?></p>
              <p class="card-text">
                <small>
                  <i class="fas fa-eye px-1"></i><?= $post->getNumber_reviews(); ?>
                  <i class="far fa-user pl-3 pr-1"></i><?= $post->getPostAuthor(); ?>
                  <i class="fas fa-calendar-alt pl-3 pr-1"></i><?= $post->getPublished_date(); ?>
                </small>
              </p>
              <div class="post-footer d-flex justify-content-between">
                <a href="<?= $router->generate('blog_read', ['page' => $pagination->getCurrentPage(), 'slug' => $post->getSlug()]); ?>" class="btn btn-xs btn-primary">Lire la suite</a>
                <span class="badge badge-secondary d-table px-3 py-2"><?= $post->getCategory()?></span>
              </div>
              
            </div>
          </article>
        </div>
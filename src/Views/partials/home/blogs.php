<?php use MyBlog\Services\Validator; ?>
<section class="blog-section section bg-primary position-relative testimonial-bg-shapes">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h2 class="section-title text-white mb-5">Blogs</h2>
        </div>
        <?php foreach($posts as $post) : ?>
        <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
          <article class="card shadow">
            <img class="rounded card-img-top" src="<?=$basePath?>/public/images/uploads/" . <?= Validator::decode($post->getImg()); ?> alt="post-thumb">
            <div class="card-body">
              <h4 class="card-title"><a class="text-dark" href="<?= $router->generate('blog_read', ['slug' => $post->getSlug()]); ?>"><?= Validator::decode($post->getTitle()); ?></a>
              </h4>
              <p class="cars-text"><?= Validator::decode($post->getChapo()); ?></p>
              <a href="<?= $router->generate('blog_read', ['slug' => $post->getSlug()]); ?>" class="btn btn-xs btn-primary">Lire</a>
            </div>
          </article>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <!-- bg shapes -->
    <img src="<?=$basePath?>/public/images/backgrounds/map.png" alt="map" class="img-fluid bg-map">
    <img src="<?=$basePath?>/public/images/illustrations/dots-group-v.png" alt="bg-shape" class="img-fluid bg-shape-1">
    <img src="<?=$basePath?>/public/images/illustrations/leaf-orange.png" alt="bg-shape" class="img-fluid bg-shape-2">
    <img src="<?=$basePath?>/public/images/illustrations/dots-group-sm.png" alt="bg-shape" class="img-fluid bg-shape-3">
    <img src="<?=$basePath?>/public/images/illustrations/leaf-pink-round.png" alt="bg-shape" class="img-fluid bg-shape-4">
    <img src="<?=$basePath?>/public/images/illustrations/leaf-cyan.png" alt="bg-shape" class="img-fluid bg-shape-5">
  </section>
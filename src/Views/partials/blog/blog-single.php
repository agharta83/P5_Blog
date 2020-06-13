  <!-- post -->
  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="font-tertiary mb-5">

            <?= $post->getTitle(); ?></h3>
          <p class="font-secondary">Publié le <?= $post->getPublished_date(); ?> par
            <span class="text-primary">
              <?= $post->getPostAuthor(); ?>
            </span>
            <div class="content">
              <img src="<?= $basePath . $post->getImg(); ?>" alt="post-thumb" class="img-fluid rounded float-left mr-5 mb-4">
              <p><?= $post->getContent(); ?></p>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /post -->

  <!-- comments -->
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4 class="font-weight-bold mb-3">Commentaires<span class="ml-2 badge badge-dark rounded-circle"><?= $nbComments; ?></span></h4>
          <div class="bg-gray p-5 mb-4">
            <?php
            foreach ($comments as $comment) :
              $id1 = "#respondTo" . $comment->getId();
              $id2 = "respondTo" . $comment->getId();
            ?>
              <div class="media py-4">
                <img src="<?= $basePath ?>/public/images/user-1.jpg" class="img-fluid align-self-start rounded-circle mr-3" alt="">
                <div class="media-body">
                  <h5 class="mt-0"><?= $comment->getCommentAuthor(); ?></h5>
                  <p><?= ucfirst($comment->getFormatedDate()); ?></p>
                  <p><?= $comment->getContent(); ?></p>
                  <a href="<?= $id1; ?>" class="btn btn-transparent btn-sm pl-0" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="<?= $id1; ?>">Répondre</a>
                  <div class="collapse" id="<?= $id2; ?>">
                    <form action="<?= $router->generate("add_comment"); ?>" method="post" class="row">
                      <div class="col-md-6">
                        <input type="hidden" value="<?= $post->getId(); ?>" id="post_id" name="post_id">
                        <input type="hidden" value="<?= $comment->getId(); ?>" id="respond_to1" name="respond_to">
                        <input type="text" class="form-control mb-3" placeholder="Prénom" name="firstname" id="firstname">
                        <input type="text" class="form-control mb-3" placeholder="Nom" name="lastname" id="lastname">
                        <input type="text" class="form-control mb-3" placeholder="Email *" name="email" id="email">
                      </div>
                      <div class="col-md-6">
                        <textarea name="content" id="content" placeholder="Message" class="form-control mb-4"></textarea>
                        <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                      </div>
                    </form>
                  </div>
                  <!-- Respond to -->
                  <?php
                  if ($respond_to = $commentManager->thisCommentHasAnswer($comment->getId())) :
                    $id3 = "#respondTo" . $respond_to->getId();
                    $id4 = "respondTo" . $respond_to->getId();
                  ?>
                    <div class="media my-5">
                      <img src="<?= $basePath ?>/public/images/user-2.jpg" class="img-fluid align-self-start rounded-circle mr-3" alt="">
                      <div class="media-body">
                        <h5 class="mt-0"><?= $respond_to->getCommentAuthor(); ?></h5>
                        <p><?= ucfirst($respond_to->getFormatedDate()); ?></p>
                        <p><?= $respond_to->getContent(); ?></p>
                        <a href="<?= $id3; ?>" class="btn btn-transparent btn-sm pl-0" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="<?= $id3; ?>">Répondre</a>
                      </div>
                    </div>
                    <div class="collapse" id="<?= $id4; ?>">
                      <form action="<?= $router->generate("add_comment"); ?>" method="post" class="row">
                        <div class="col-md-6">
                          <input type="hidden" value="<?= $post->getId(); ?>" id="post_id" name="post_id">
                          <input type="hidden" value="<?= $comment->getId(); ?>" id="respond_to2" name="respond_to">
                          <input type="text" class="form-control mb-3" placeholder="Prénom" name="firstname" id="firstname">
                          <input type="text" class="form-control mb-3" placeholder="Nom" name="lastname" id="lastname">
                          <input type="text" class="form-control mb-3" placeholder="Email *" name="email" id="email">
                        </div>
                        <div class="col-md-6">
                          <textarea name="content" id="content" placeholder="Message" class="form-control mb-4"></textarea>
                          <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                        </div>
                      </form>
                    </div>
                  <?php endif; ?>
                  <!-- /Respond to -->
                </div>
              </div>
            <?php
            endforeach;
            ?>
          </div>
          <h4 class="font-weight-bold mb-3 border-bottom pb-3">Laisser un commentaire</h4>
          <form action="<?= $router->generate("add_comment"); ?>" method="post" class="row">
            <div class="col-md-6">
              <input type="hidden" value="<?= $post->getId(); ?>" id="post_id" name="post_id">
              <input type="text" class="form-control mb-3" placeholder="Prénom" name="firstname" id="firstname">
              <input type="text" class="form-control mb-3" placeholder="Nom" name="lastname" id="lastname">
              <input type="text" class="form-control mb-3" placeholder="Email *" name="email" id="email">
            </div>
            <div class="col-md-6">
              <textarea name="content" id="content" placeholder="Message" class="form-control mb-4"></textarea>
              <button type="submit" class="btn btn-primary w-100">Envoyer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- /comments -->

  <!-- posts similaires -->
  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h2 class="section-title">Posts similaires</h2>
        </div>
        <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
          <article class="card shadow">
            <img class="rounded card-img-top" src="<?= $basePath ?>/public/images/blog/post-3.jpg" alt="post-thumb">
            <div class="card-body">
              <h4 class="card-title"><a class="text-dark" href="blog-single.html">Amazon increase income 1.5 Million</a>
              </h4>
              <p class="cars-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                incididunt ut labore et
                dolore magna aliqua.</p>
              <a href="blog-single.html" class="btn btn-xs btn-primary">Read More</a>
            </div>
          </article>
        </div>
        <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
          <article class="card shadow">
            <img class="rounded card-img-top" src="<?= $basePath ?>/public/images/blog/post-4.jpg" alt="post-thumb">
            <div class="card-body">
              <h4 class="card-title"><a class="text-dark" href="blog-single.html">Amazon increase income 1.5 Million</a>
              </h4>
              <p class="cars-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                incididunt ut labore et
                dolore magna aliqua.</p>
              <a href="blog-single.html" class="btn btn-xs btn-primary">Read More</a>
            </div>
          </article>
        </div>
        <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
          <article class="card shadow">
            <img class="rounded card-img-top" src="<?= $basePath ?>/public/images/blog/post-2.jpg" alt="post-thumb">
            <div class="card-body">
              <h4 class="card-title"><a class="text-dark" href="blog-single.html">Amazon increase income 1.5 Million</a>
              </h4>
              <p class="cars-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                incididunt ut labore et
                dolore magna aliqua.</p>
              <a href="blog-single.html" class="btn btn-xs btn-primary">Read More</a>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>
  <!-- /posts similaires -->
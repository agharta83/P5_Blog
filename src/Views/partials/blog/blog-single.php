  <!-- post -->
  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="font-tertiary mb-5"><?= $post->getTitle(); ?></h3>
          <p class="font-secondary">Publié le <?= $post->getPublished_date(); ?> par 
          <span class="text-primary">
            <?= $post->getPostAuthor()->getFirstname() .' '. $post->getPostAuthor()->getLastname(); ?>
          </span>
          <div class="content">
            <img src="<?=$basePath . $post->getImg(); ?>" alt="post-thumb" class="img-fluid rounded float-left mr-5 mb-4">
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
          <h4 class="font-weight-bold mb-3">Commentaires<span class="ml-2 badge badge-dark rounded-circle">03</span></h4>
          <div class="bg-gray p-5 mb-4">
            <div class="media border-bottom py-4">
              <img src="<?=$basePath?>/public/images/user-1.jpg" class="img-fluid align-self-start rounded-circle mr-3" alt="">
              <div class="media-body">
                <h5 class="mt-0">Carole Marvin.</h5>
                <p>15 january 2015 At 10:30 pm</p>
                <p>Ne erat velit invidunt his. Eum in dicta veniam interesset, harum fuisset te nam ea cu lupta
                  definitionem.</p>
                <a href="#" class="btn btn-transparent btn-sm pl-0">Répondre</a>
                <div class="media my-5">
                  <img src="<?=$basePath?>/public/images/user-2.jpg" class="img-fluid align-self-start rounded-circle mr-3" alt="">
                  <div class="media-body">
                    <h5 class="mt-0">Jaquan Rolfson.</h5>
                    <p>15 january 2015 At 10:30 pm</p>
                    <p>Ne erat velit invidunt his. Eum in dicta veniam interesset, harum fuisset te nam ea cu lupta
                      definitionem.</p>
                    <a href="#" class="btn btn-transparent btn-sm pl-0">Répondre</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="media py-4">
              <img src="<?=$basePath?>/public/images/user-3.jpg" class="img-fluid align-self-start rounded-circle mr-3" alt="">
              <div class="media-body">
                <h5 class="mt-0">Bruce Bernier.</h5>
                <p>15 january 2015 At 10:30 pm</p>
                <p>Ne erat velit invidunt his. Eum in dicta veniam interesset, harum fuisset te nam ea cu lupta
                  definitionem.</p>
                <a href="#" class="btn btn-transparent btn-sm pl-0">Répondre</a>
              </div>
            </div>
          </div>
          <h4 class="font-weight-bold mb-3 border-bottom pb-3">Laisser un commentaire</h4>
          <form action="#" class="row">
            <div class="col-md-6">
              <input type="text" class="form-control mb-3" placeholder="Prénom" name="fname" id="fname">
              <input type="text" class="form-control mb-3" placeholder="Nom" name="lname" id="lname">
              <input type="text" class="form-control mb-3" placeholder="Email *" name="mail" id="mail">
            </div>
            <div class="col-md-6">
              <textarea name="comment" id="comment" placeholder="Message" class="form-control mb-4"></textarea>
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
            <img class="rounded card-img-top" src="<?=$basePath?>/public/images/blog/post-3.jpg" alt="post-thumb">
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
            <img class="rounded card-img-top" src="<?=$basePath?>/public/images/blog/post-4.jpg" alt="post-thumb">
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
            <img class="rounded card-img-top" src="<?=$basePath?>/public/images/blog/post-2.jpg" alt="post-thumb">
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
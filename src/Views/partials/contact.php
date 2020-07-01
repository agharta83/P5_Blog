<section class="section section-on-footer" data-background="<?=$basePath?>/public/images/backgrounds/bg-dots.png">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h2 class="section-title">Contact</h2>
        </div>
        <div class="col-lg-8 mx-auto">
          <div class="bg-white rounded text-center p-5 shadow-down">
            <form action="<?= $router->generate('contact_form');?>" method="post" class="row" name="contact_form">
              <div class="col-md-6">
                <input type="text" id="name" name="name" placeholder="Nom" class="form-control px-0 mb-4">
              </div>
              <div class="col-md-6">
                <input type="email" id="email" name="email" placeholder="Adresse Email" class="form-control px-0 mb-4">
              </div>
              <div class="col-12">
                <textarea name="message" id="message" class="form-control px-0 mb-4"
                  placeholder="Votre message ici"></textarea>
              </div>
              <div class="col-lg-6 col-10 mx-auto">
                <button type="submit" class="btn btn-primary w-100">envoyer</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
<section class="hero-area hero-admin-new-post bg-primary" id="parallax">

  <div class="container-fluid">

    <div class="row m-auto w-100">

      <div class="col-10 card card-post">
        <div class="card-header d-flex justify-content-between">
          <h3>
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            Création d'un nouveau post
          </h3>

          <div class="custom-control custom-switch custom-switch-lg align-self-center">
            <input type="checkbox" class="custom-control-input" id="published">
            <label class="custom-control-label" for="published">Publié ?</label>
          </div>

        </div>

        <div class="card-body">

          <p class="text-muted card-text">
            <small>* Les champs dotés d'une astérisque sont obligatoires.</small>
          </p>

          <form name="new_post_form" method="post" data-api-url="" enctype="multipart/form-data">

            <div class="form-group row">
              <label class="col-sm-3 col-form-legend required">Catégories *</label>
              <div class="col-sm-9">
                <div id="new_post_form_title">
                  <div class="form-check form-check-inline">
                    <input type="radio" id="category_0" name="new_post_form[category]" required="required" class="form-check-input" value="Gestion de projet">
                    <label class="form-check-label required">
                      Gestion de projet
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input type="radio" id="category_1" name="new_post_form[category]" required="required" class="form-check-input" value="Back">
                    <label class="form-check-label required">
                      Back
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input type="radio" id="category_2" name="new_post_form[category]" required="required" class="form-check-input" value="Front">
                    <label class="form-check-label required">
                      Front
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input type="radio" id="category_3" name="new_post_form[category]" required="required" class="form-check-input" value="Autre">
                    <label class="form-check-label required">
                      Autre
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label col-sm-3 form-control-label align-self-center required" for="identite_form_titre">Titre de l'article *</label>
              <div class="col-sm-9">
                <input type="text" id="identite_form_titre" name="new_post_form[titre]" required placeholder="Titre" class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label col-sm-3 form-control-label" for="new_post_form_chapo">Chapo *</label>
              <div class="col-sm-9">
                <input type="text" id="new_post_form_chapo" name="new_post_form[chapo]" placeholder="Chapo" class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label col-sm-3 form-control-label required" for="new_post_form_content">Contenu *</label>
              <div class="col-sm-9">
                <textarea type="text" id="new_post_form_content" name="new_post_form[content]" required="required" placeholder="Prénom" class="form-control">
                    Hello world !
                </textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label col-sm-3 col-form-legend">Image du post</label>
              <div class="col-sm-4">
                <div class="document">

                  <div class="document-file ">
                    <div class="row">
                      <div class="col pr-0">
                        <div class="custom-file">
                          <input type="file" id="new_post_form_img" name="new_post_form[img][file]" accept="jpg, jpeg" data-original-name="" class="custom-file-input" lang="fr">
                          <label id="new_post_form_img_file-label" class="custom-file-label" for="customFile" data-label-default="Choisissez un fichier">
                            Choisissez un fichier
                          </label> </div>
                      </div>
                      <div class="col-auto pl-0">
                        <button id="new_post_form_img_file-action-delete" class="btn btn-outline-danger ml-2" style="display: none; height: calc(2.25rem + 2px);" title="Supprimer le fichier actuel" data-file-input-id="new_post_form_img_file">
                          <i class="fa fa-remove" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>

                  <div id="new_post_form_img_file-help">
                    <small class="text-muted">
                      Taille du fichier limitée à 488 Ko.
                    </small>
                  </div>
                </div>
              </div>
            </div>

            <hr class="mt-4">

            <div class="row mt-5">
              <div class="col-sm-12 d-flex justify-content-around">
                <a href="<?= $router->generate('admin_blog_list'); ?>" class="btn btn-secondary">Retour</a>
                <button type="submit" id="new_post_form_submit" name="new_post_form[submit]" class="btn-primary btn">Enregistrer</button>
              </div>
            </div>

          </form>
        </div>
      </div>

    </div>

  </div>
  <div class="layer-bg layer-bg-admin w-100">
    <img class="img-fluid w-100" src="<?= $basePath ?>/public/images/illustrations/leaf-bg.png" alt="bg-shape">
  </div>

</section>
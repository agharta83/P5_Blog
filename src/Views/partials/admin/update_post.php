<?php

use MyBlog\Models\PostModel;

?>

<section class="hero-area hero-admin-new-post bg-primary" id="parallax">

    <div class="container-fluid">

        <div class="row m-auto w-100">

            <div class="col-10 card card-post">
                <div class="card-header d-flex justify-content-between">
                    <h3>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Mise à jour de l'article
                    </h3>
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
                                        <?php $checked = $post->getCategory() == PostModel::GESTION_DE_PROJET ? 'checked' : null ?>
                                        <input type="radio" id="category_0" name="category" required="required" class="form-check-input" value="<?= PostModel::GESTION_DE_PROJET; ?>" <?= $checked; ?>>
                                        <label class="form-check-label required">
                                            Gestion de projet
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php $checked = $post->getCategory() == PostModel::BACK ? 'checked' : null ?>
                                        <input type="radio" id="category_1" name="category" required="required" class="form-check-input" value="<?= PostModel::BACK; ?>" <?= $checked; ?>>
                                        <label class="form-check-label required">
                                            Back
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php $checked = $post->getCategory() == PostModel::FRONT ? 'checked' : null ?>
                                        <input type="radio" id="category_2" name="category" required="required" class="form-check-input" value="<?= PostModel::FRONT; ?>" <?= $checked; ?>>
                                        <label class="form-check-label required">
                                            Front
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php $checked = $post->getCategory() == PostModel::AUTRE ? 'checked' : null ?>
                                        <input type="radio" id="category_3" name="category" required="required" class="form-check-input" value="<?= PostModel::AUTRE; ?>" <?= $checked; ?>>
                                        <label class="form-check-label required">
                                            Autre
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-3 form-control-label align-self-center required" for="new_post_form_titre">Titre de l'article *</label>
                            <div class="col-sm-9">
                                <input type="text" id="new_post_form_titre" name="titre" required placeholder="Titre" class="form-control" value="<?= $post->getTitle(); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-3 form-control-label" for="new_post_form_chapo">Chapo *</label>
                            <div class="col-sm-9">
                                <input type="text" id="new_post_form_chapo" name="chapo" placeholder="Chapo" class="form-control" value="<?= $post->getChapo(); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-3 form-control-label required" for="new_post_form_content">Contenu *</label>
                            <div class="col-sm-9">
                                <input type="text" id="new_post_form_content" name="content" required="required" placeholder="Contenu" class="form-control" value="<?= $post->getContent(); ?>">
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-3 col-form-legend"><i class="fas fa-image pr-2"></i>Image à la une</label>

                            <div class="col-sm-4">
                                <div class="custom-file">
                                    <input type="file" name="files[]" accept="image/*" multiple class="custom-file-input form-control" id="customFile">
                                    <label class="custom-file-label" for="customFile"><?= $post->getImg(); ?></label>
                                </div>
                            </div>

                            <div class="col-sm-5 wrapper-preview text-center">

                            </div>

                        </div>

                        <hr class="mt-4">

                        <div class="custom-control custom-switch custom-switch-lg">
                            <?php $published = $post->isPublished() ? 'checked' : null; ?>
                            <input type="checkbox" class="custom-control-input" id="published" name="published" value="off" <?= $published; ?>>
                            <label class="custom-control-label" for="published">Publié ?</label>
                        </div>

                        <div class="row mt-5">
                            <div class="col-sm-12 d-flex justify-content-around">
                                <a href="<?= $router->generate('admin_blog_list', ['page' => 1]); ?>" class="btn btn-secondary">Retour</a>
                                <h3><button name="preview" type="submit" value="preview" class="view" title="Voir" data-toggle="tooltip"><i class="far fa-eye"></i></a></h3>
                                <button type="submit" id="update" name="update" class="btn-primary btn">Enregistrer</button>
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

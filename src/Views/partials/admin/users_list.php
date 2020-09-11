<?php

use Myblog\Models\UserModel; ?>

<section class="hero-area hero-admin bg-primary" id="parallax">

    <div class="container table-container table-users bg-white">
        <div class="table-wrapper shadow p-3 mx-2">
            <div class="table-title pb-1 mb-1">
                <div class="row justify-content-between">
                    <div class="col-sm-4">
                        <h3 class="text-left tertiary-font"><b>Utilisateurs</b></h3>
                    </div>
                    <div class="col-lg-2 mx-auto">
                        <button class="text-dark btn-new-post btn btn-primary w-100 p-1">
                            <a href="#new_user" class="text-dark trigger-btn" data-toggle="modal">Ajouter</a>
                        </button>
                    </div>
                </div>
            </div>

            <table class="table table-hover table-wrapper">
                <thead class="uppercase">
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Rôle</th>
                        <th>Date de création</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                        $this->insert('partials/admin/user_row', ['user' => $user, 'pagination' => $pagination]);
                    }
                    ?>
                </tbody>
            </table>

            <!-- Insert pagination -->
            <?php
            $prevPage = $pagination->hasPreviousPage() ? (string) $pagination->getPreviousPage() : null;
            $nextPage = $pagination->hasNextPage() ? (string) $pagination->getNextPage() : null;
            $nbPages = $pagination->getNbPages() ?? null;
            ?>
            <div class="clearfix">
                <div class="hint-text">Affichage de <b><?= $pagination->getCurrentPageOffsetEnd(); ?></b> utilisateurs sur <b><?= $pagination->getNbResults(); ?></b></div>
                <ul class="pagination">
                    <?php if ($pagination->hasPreviousPage()) : ?>
                        <li class="page-item"><a href="<?= $router->generate('users_list', ['page' => $prevPage]); ?>" class="page-link">Précédent</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $nbPages; $i++) : ?>
                        <?php
                        $active = $pagination->getCurrentPage() == $i ? 'active' : null;
                        ?>
                        <li class="page-item <?= $active; ?>"><a href="<?= $router->generate('users_list', ['page' => $i]); ?>" class="page-link"><?= $i; ?></a></li>
                    <?php endfor; ?>
                    <?php if ($pagination->hasNextPage()) : ?>
                        <li class="page-item"><a href="<?= $router->generate('users_list', ['page' => $nextPage]); ?>" class="page-link">Suivant</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="layer-bg layer-bg-admin w-100">
        <img class="img-fluid w-100" src="<?= $basePath ?>/public/images/illustrations/leaf-bg.png" alt="bg-shape">
    </div>

</section>

<!-- Modal HTML -->
<div id="new_user" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-login">
        <div class="modal-content">
            <form name="login" action="<?= $router->generate('create_user', ['page' => $pagination->getCurrentPage()]); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un nouveau utilisateur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <?php
                if (!empty($errors)) {
                    foreach ($errors as $error) : ?>
                        <div class="alert alert-danger">
                            <?= $error; ?>
                        </div>
                    <?php endforeach; ?>
                <?php
                }
                ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" required="required" value="<?= $fields['email'] ?? ''; ?>">
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="col-sm-4 col-form-legend required">Rôle de l'utilisateur</label>
                        <div class="col-sm-8 d-flex">
                            <div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="admin" name="user_role" required="required" class="form-check-input" value="<?= UserModel::ADMIN; ?>">
                                    <label class="form-check-label required">
                                        <?= UserModel::ADMIN; ?>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="user" name="user_role" required="required" class="form-check-input" value="<?= UserModel::USER; ?>">
                                    <label class="form-check-label required">
                                        <?= UserModel::USER; ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <p>Un mot de passe sera généré en envoyer à l'adresse email</p>
                    <input type="submit" class="btn btn-primary text-white" value="Ajouter">
                </div>
            </form>
        </div>
    </div>
</div>

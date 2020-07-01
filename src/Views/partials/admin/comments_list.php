<?php use MyBlog\Models\PostModel; ?>

<section class="hero-area hero-admin bg-primary" id="parallax">

    <div class="container table-container bg-white">
        <div class="table-wrapper shadow p-3 mx-2">
            <div class="table-title pb-1 mb-1">
                <div class="row justify-content-between">
                    <div class="col-sm-5">
                        <h3 class="text-left tertiary-font"><b>Commentaires</b></h3>
                    </div>
                    <div class="col-5 mx-auto">
                        <div class="btn-group btn-group-toggle justify-content-center d-flex" data-toggle="buttons">
                            <label class="btn btn-sm btn-primary active">
                                <input type="radio" name="all" value="all" checked="checked" />Tout
                            </label>
                            <label class="btn btn-sm btn-primary">
                                <input type="radio" name="NotValid" value="0" />A valider
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead class="uppercase">
                    <tr>
                        <th>Post</th>
                        <th>Date de création</th>
                        <th>Est validé</th>
                        <th>Auteur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($comments as $comment) {
                        $this->insert('partials/admin/comment_row', ['comment' => $comment, 'pagination' => $pagination]);
                    }
                    ?>
                </tbody>
            </table>

            <!-- Insert pagination -->
            <?php
                $prevPage = $pagination->hasPreviousPage() ? (string)$pagination->getPreviousPage() : null;
                $nextPage = $pagination->hasNextPage() ? (string)$pagination->getNextPage() : null;
                $nbPages = $pagination->getNbPages() ?? null;
            ?>
            <div class="clearfix">
                <div class="hint-text">Affichage de <b><?= $pagination->getCurrentPageOffsetEnd(); ?></b> commentaires sur <b><?= $pagination->getNbResults(); ?></b></div>
                <ul class="pagination">
                    <?php if ($pagination->hasPreviousPage()) : ?>
                        <li class="page-item"><a href="<?= $router->generate('comments_list', ['page' => $prevPage]); ?>" class="page-link">Précédent</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $nbPages; $i++) : ?>
                        <?php
                            $active = $pagination->getCurrentPage() == $i ? 'active' : null;   
                        ?>
                        <li class="page-item <?= $active; ?>"><a href="<?= $router->generate('comments_list', ['page' => $i]); ?>" class="page-link"><?= $i; ?></a></li>
                    <?php endfor; ?>
                    <?php if ($pagination->hasNextPage()) : ?>
                        <li class="page-item"><a href="<?= $router->generate('comments_list', ['page' => $nextPage]); ?>" class="page-link">Suivant</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="layer-bg layer-bg-admin w-100">
        <img class="img-fluid w-100" src="<?= $basePath ?>/public/images/illustrations/leaf-bg.png" alt="bg-shape">
    </div>

</section>
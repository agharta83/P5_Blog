<?php
$content = '#content' . $user->getId();
$content1 = 'content' . $user->getId();
?>

<tr data-toggle="collapse" data-target="<?= $content; ?>" class="accordion-toggle" data-groups="<?= $user->isAdmin() ? 1 : 0; ?>">
    <td><?= $user->getLogin(); ?></td>
    <td><?= $user->getEmail(); ?></td>
    <td><?= $user->getStatut(); ?></td>
    <td><?= $user->getUser_role(); ?></td>
    <td><?= $user->getCreated_on(); ?></td>
    <td><?= $user->getFirstname(); ?></td>
    <td><?= $user->getLastname(); ?></td>
    <td class="d-flex">
        <a href="<?= $router->generate('downgrade_user', ['id' => $user->getId(), 'page' => $pagination->getCurrentPage()]); ?>" class="view" title="Rétrograder" data-toggle="tooltip"><i class="fas fa-thumbs-down"></i></a>
        <a href="<?= $router->generate('promote_user', ['id' => $user->getId(), 'page' => $pagination->getCurrentPage()]); ?>" class="view" title="Promouvoir" data-toggle="tooltip"><i class="fas fa-user-shield"></i></a>
        <a href="<?= $router->generate('enable_user', ['id' => $user->getId(), 'page' => $pagination->getCurrentPage()]); ?>" class="edit" title="Activer" data-toggle="tooltip"><i class="fas fa-thumbs-up"></i></a>
        <a href="<?= $router->generate('disable_user', ['id' => $user->getId(), 'page' => $pagination->getCurrentPage()]); ?>" class="delete" title="Désactiver" data-toggle="tooltip"><i class="fas fa-times-circle"></i></a>
    </td>
</tr>

<tr>
    <td colspan="10" class="hiddenRow">
        <div class="accordian-body collapse pb-2" id="<?= $content1; ?>">
            <form name="update_user" action="<?= $router->generate('update_user', ['page' => $pagination->getCurrentPage()]); ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-2">
                        <h5 class="text-left">Modifier :</h5>
                    </div>
                    <div class="col-4">
                        <input name="login" type="text" class="form-control form_update" value="<?= $user->getLogin() ?? ''; ?>" placeholder='Login'>
                    </div>
                    <div class="col-4">
                        <input name="email" type="email" class="form-control form_update" required="required" value="<?= $user->getEmail() ?? ''; ?>" placeholder="Email">
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <input name="password" type="password" class="form-control form_update" placeholder="Mot de passe">
                    </div>
                    <div class="col-4">
                        <input name="firstname" type="text" class="form-control form_update" value="<?= $user->getFirstname() ?? ''; ?>" placeholder="Prénom">
                    </div>
                    <div class="col-4 pr-0">
                        <input name="lastname" type="text" class="form-control form_update w-90" value="<?= $user->getLastname() ?? ''; ?>" placeholder="Nom">
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-6">
                        <input type="file" class="form-control-file ml-2">
                    </div>
                    <div class="col-6">
                        <input type="submit" class="btn btn-primary text-white btn_update" value="Modifier">
                    </div>
                </div>
                <input type="hidden" name="userId" value="<?= $user->getId(); ?>">
            </form>
        </div>
    </td>
</tr>

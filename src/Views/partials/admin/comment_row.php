<?php
$content = '#content' . $comment->getId();
$content1 = 'content' . $comment->getId();
?>

<tr data-toggle="collapse" data-target="<?= $content; ?>" class="accordion-toggle">
    <td><?= $postManager->findById($comment->getPost_id())->getTitle(); ?></td>
    <td><?= $comment->getCreated_on(); ?></td>
    <td><?= $comment->getIs_valid(); ?></td>
    <td><?= $comment->getCommentAuthor(); ?></td>
    <td>
        <a href="<?= $router->generate('valid_comment', ['id' => $comment->getId()]); ?>" class="edit" title="Valider" data-toggle="tooltip"><i class="fas fa-check"></i></a>
        <a href="<?= $router->generate('delete_comment', ['id' => $comment->getId()]); ?>" class="delete" title="Supprimer" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
    </td>
</tr>

<tr>
    <td colspan="6" class="hiddenRow">
        <div class="accordian-body collapse pb-2" id="<?= $content1; ?>">
            <p>Commentaire :</p>
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyehhelvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
        </div>
    </td>
</tr>

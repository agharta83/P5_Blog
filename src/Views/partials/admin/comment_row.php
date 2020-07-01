<?php
$content = '#content' . $comment->getId();
$content1 = 'content' . $comment->getId();

$modal = '#deleteComment' . $comment->getId();
$modal1 = 'deleteComment' . $comment->getId();

$modal2 = '#validComment' . $comment->getId();
$modal3 = 'validComment' . $comment->getId();
?>

<tr data-toggle="collapse" data-target="<?= $content; ?>" class="accordion-toggle" data-groups="<?= $comment->getIs_valid();?>">
    <td><?= $postManager->findById($comment->getPost_id())->getTitle(); ?></td>
    <td><?= $comment->getCreated_on(); ?></td>
    <td><?= $comment->getIs_valid(); ?></td>
    <td><?= $comment->getCommentAuthor(); ?></td>
    <td>
        <a href="#" data-toggle="modal" data-target="<?= $modal2; ?>" class="edit" title="Valider" data-toggle="tooltip" data-backdrop="false"><i class="fas fa-check"></i></a>
        <a href="#" data-toggle="modal" data-target="<?= $modal; ?>" class="delete" title="Supprimer" data-toggle="tooltip" data-backdrop="false"><i class="fas fa-trash-alt"></i></a>
    </td>
</tr>

<tr>
    <td colspan="6" class="hiddenRow">
        <div class="accordian-body collapse pb-2" id="<?= $content1; ?>">
            <p>Commentaire :</p>
            <?= $comment->getContent(); ?>
        </div>
    </td>
</tr>

<!-- Modal -->
<div class="modal fade" id="<?= $modal1; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Supprimer un commentaire</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Voulez vous supprimer ce commentaire ?
      </div>
      <div class="modal-footer">
        <a href="<?= $router->generate('delete_comment', ['id' => $comment->getId(), 'page' => $pagination->getCurrentPage()]); ?>" role="button" class="btn btn-primary">Supprimer</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="<?= $modal3; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Valider un commentaire</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Voulez vous valider ce commentaire ?
      </div>
      <div class="modal-footer">
        <a href="<?= $router->generate('valid_comment', ['id' => $comment->getId(), 'page' => $pagination->getCurrentPage()]); ?>" role="button" class="btn btn-primary">Valider</a>
      </div>
    </div>
  </div>
</div>
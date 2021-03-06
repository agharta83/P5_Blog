<tr>
    <td><?= $post->getTitle(); ?></td>
    <td><?= $post->getCreated_on(); ?></td>
    <td><?= $post->getPublished_date(); ?></td>
    <td><?= $post->getLast_update(); ?></td>
    <td><?= $post->getPostAuthor(); ?></td>
    <td><?= $post->getCategory(); ?></td>
    <td><?= $post->getPublished(); ?></td>
    <td><?= $post->getNumber_reviews(); ?></td>
    <td>
		<a href="<?= $router->generate('preview_post', ['slug' => $post->getSlug()]); ?>" class="view" title="Voir" data-toggle="tooltip"><i class="far fa-eye"></i></a>
        <a href="<?= $router->generate('update_post', ['id' => $post->getId(), 'page' => $pagination->getCurrentPage()]); ?>" class="edit" title="Editer" data-toggle="tooltip"><i class="far fa-edit"></i></a>
        <a href="<?= $router->generate('delete_post', ['id' => $post->getId(), 'page' => $pagination->getCurrentPage()]); ?>" class="delete" title="Supprimer" data-toggle="tooltip"><i class="far fa-trash-alt"></i></a>
    </td>
</tr>

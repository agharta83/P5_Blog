

<tr>
    <td><?= $post->getTitle(); ?></td>
    <td><?= $post->getCreated_on(); ?></td>
    <td><?= $post->getPublished_date(); ?></td>
    <td><?= $post->getLast_update(); ?></td>
    <td><?= $post->getPostAuthor(); ?></td>
    <td><?= $post->getCategory(); ?></td>
    <td><?= $post->getPublished(); ?></td>
    <td>
		<a href="#" class="view" title="Voir" data-toggle="tooltip"><i class="far fa-eye"></i></a>
        <a href="#" class="edit" title="Editer" data-toggle="tooltip"><i class="far fa-edit"></i></a>
        <a href="#" class="delete" title="Supprimer" data-toggle="tooltip"><i class="far fa-trash-alt"></i></a>
    </td>
</tr>
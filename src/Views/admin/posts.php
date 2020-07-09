<?php $this->layout('admin'); ?>

<?php $this->insert('partials/admin/posts_list', [
    'posts' => $posts,
    'pagination' => $pagination
]); ?>


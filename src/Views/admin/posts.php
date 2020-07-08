<?php $this->layout('admin', ['title' => $title]); ?>

<?php $this->insert('partials/admin/posts_list', [
    'posts' => $posts,
    'pagination' => $pagination
]); ?>


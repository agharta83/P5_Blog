<?php $this->layout('admin', ['title' => $title]); ?>

<?php $this->insert('partials/admin/comments_list', ['comments' => $comments]); ?>
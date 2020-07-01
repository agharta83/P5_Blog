<?php $this->layout('admin', ['title' => $title]); ?>

<?php $this->insert('partials/admin/users_list', ['users' => $users, 'pagination' => $pagination]); ?>


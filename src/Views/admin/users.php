<?php $this->layout('admin'); ?>

<?php $this->insert('partials/admin/users_list', ['users' => $users, 'pagination' => $pagination]); ?>


<?php
require 'function.php';
$user = getUserById($_GET['id']);
deleteUser($_GET['id'], $user['avatar']);

if (checkUserRole()) {
    setFlashMessage('success', 'Профиль успешно удалён');
    redirect('/users.php');
    exit;
}
redirect('logout.php');

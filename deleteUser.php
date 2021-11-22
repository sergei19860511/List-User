<?php
require 'function.php';
deleteUser($_GET['id']);
$user = getUserById($_GET['id']);

if (checkUserRole()) {
    setFlashMessage('success', 'Профиль успешно удалён');
    redirect('/users.php');
    exit;
}
redirect('logout.php');

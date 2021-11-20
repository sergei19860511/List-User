<?php
require 'function.php';
if (!empty($_POST)) {
    updateUserInformation($_POST['name'], $_POST['jobs'], $_POST['phone'],$_POST['address'], $_POST['id']);
    setFlashMessage('success', 'Профиль успешно обновлён');
    redirect('/users.php');
}
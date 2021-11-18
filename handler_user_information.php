<?php
require 'function.php';

//var_dump($_FILES);
//echo uploadAvaUser($_FILES);
if (!empty($_POST)) {
    $user = getUserByEmail($_POST['email']);
    if (!empty($user)) {
        setFlashMessage('danger', 'Такой Email уже занят');
        redirect('create_user.php');
        exit;
    }
    $id_user = addUser($_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT));
    setUserInformation($id_user, $_POST['name'], $_POST['jobs'], $_POST['phone'], $_POST['address']);
    setStatusUser($id_user, $_POST['status']);
    setSocialLinksUser($id_user, $_POST['vk'], $_POST['telegram'], $_POST['instagram']);

    if (uploadAvaUser($id_user, $_FILES) == 'ERROR_TYPE') {
        setFlashMessage('danger', 'Пользователь добавлен, но аватар не был загружен из-за неправильного расширения');
        redirect('create_user.php');
        exit;
    } elseif (uploadAvaUser($id_user, $_FILES) == 'ERROR_SIZE') {
        setFlashMessage('danger', 'Пользователь добавлен, но аватар не был загружен из-за превышения размера файла');
        redirect('create_user.php');
        exit;
    }
    setFlashMessage('success', 'Пользователь успешно добавлен');
    redirect('create_user.php');
}
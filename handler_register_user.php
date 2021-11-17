<?php
require 'function.php';
if (!empty($_POST['email_user'])) {
    $email_user = $_POST['email_user'];
    $pass_user = password_hash($_POST['pass_user'], PASSWORD_DEFAULT);

    $user = getUserByEmail($email_user);
    if (!$user) {
        addUser($email_user, $pass_user);
        setFlashMessage('success', 'Регистрация успешна');
        redirect('login_user.php');
        exit;
    }
    setFlashMessage('danger', 'Этот эл. адрес уже занят другим пользователем.');
    redirect('register_user.php');
}
redirect('register_user.php');

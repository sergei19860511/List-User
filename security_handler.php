<?php
require 'function.php';
if (!empty($_POST)) {

    $id = $_POST['id'];
    $email = $_POST['email'];
    $pass = empty($_POST['pass']) ? '' : password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $user = getUserByEmail($_POST['email']);
    if (!empty($user) && $_POST['email'] != $_SESSION['email'] && !checkUserRole()) {
        setFlashMessage('danger', 'Такой Email уже занят');
        redirect('/users.php');
    }
    updateAuthorized($email, $pass, $id);
    setFlashMessage('success', 'Профиль успешно изменён');
    redirect('/login_user.php');
}

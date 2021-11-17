<?php
require 'function.php';
$email = $_POST['email'];
$password = $_POST['password'];

if (!empty($email) && !empty($password)) {
    $user = checkUser($email, $password);
    if ($user) {
        redirect('/users.php');
        exit;
    }
    setFlashMessage('danger', 'Неверный логин или пароль');
    redirect('/login_user.php');
}
redirect('/login_user.php');

<?php
require 'setting.php';
session_start();
function getUserByEmail($email)
{
    global $db;

    $sql = 'SELECT * FROM users WHERE email = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;

}

function addUser($email, $pass)
{
    global $db;
    if (!empty($email) && !empty($pass)) {
        $sql = 'INSERT INTO users (email, pass) VALUES (?,?)';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $pass);
        $stmt->execute();
        return $db->lastInsertId();
    }
    return false;
}

function setFlashMessage($kei, $message)
{
    $_SESSION[$kei] = $message;
}

function displayFlashMessage($kei)
{
    if (isset($_SESSION[$kei])) {
        echo "<div class=\"alert alert-{$kei} text-dark\" role=\"alert\">{$_SESSION[$kei]}</div>";
        unset($_SESSION[$kei]);
    }
}

function redirect($path)
{
    header("Location: {$path}");
}

function checkUser($email, $password)
{
    global $db;

    $sql = 'SELECT * FROM users WHERE email = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($email === $user['email'] && password_verify($password, $user['pass'])) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['pass'] = $user['pass'];
        return true;
    }
    return  false;
}

function is_not_logged_in()
{
    if (!isset($_SESSION['email']) && empty($_SESSION['email'])) {
        return true;
    }
    return false;
}

function checkUserRole()
{
    global $db;

    $sql = 'SELECT * FROM users WHERE email = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $_SESSION['email']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user['role'] == 'admin') {
        return true;
    }
    return false;
}

function getUserAll()
{
    global $db;
    $sql = 'SELECT * FROM users';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

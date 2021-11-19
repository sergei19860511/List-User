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
    $sql = 'SELECT users.id, email, name, jobs, phone, address, avatar, vk, telegram, instagram FROM users
            LEFT JOIN information_user ON information_user.user_id = users.id
            LEFT JOIN avatar_user ON avatar_user.user_id = users.id
            LEFT JOIN social_links ON social_links.user_id = users.id';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function setUserInformation($userId, $userName, $userJob, $userPhone, $userAddress)
{
    global $db;
    if ($userId) {
        $sql = 'INSERT INTO information_user (user_id, name, jobs, phone, address) VALUES (?,?,?,?,?)';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $userName);
        $stmt->bindParam(3, $userJob);
        $stmt->bindParam(4, $userPhone);
        $stmt->bindParam(5, $userAddress);
        return $stmt->execute();
    }
    return false;
}

function setStatusUser($userId, $status)
{
    global $db;
    if ($userId) {
        $sql = 'INSERT INTO status_user (user_id, status) VALUES (?, ?)';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $status);
        $stmt->execute();
    }
}

function getStatusUser($userId)
{
    global $db;
    $sql = 'SELECT status FROM status_user WHERE user_id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $userId);
    $stmt->execute();
    $statusUser = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($statusUser['status'] == 'Отошел') {
        return 'warning';
    } elseif ($statusUser['status'] == 'Не беспокоить') {
        return 'danger';
    }
    return 'success';
}

function setSocialLinksUser($userId, $vk, $telegram, $instagram)
{
    global $db;
    if ($userId) {
        $sql = 'INSERT INTO social_links (user_id, vk, telegram, instagram) VALUES (?, ?, ?, ?)';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $vk);
        $stmt->bindParam(3, $telegram);
        $stmt->bindParam(4, $instagram);
        $stmt->execute();
    }
}

function uploadAvaUser($userId, $ava)
{
    global $db;
    if (empty($ava)) {
        return false;
    }
    $path = $ava['avatar']['name'];
    $exp = pathinfo($path, PATHINFO_EXTENSION);
    $types = ['jpeg', 'jpg', 'png'];
    $avaName = uniqid().'.'.$exp;
    $newPath = __DIR__. '/img/imgAvatar/'.$avaName;
    if (!in_array($exp, $types)) {
        return false;
    } elseif ($ava['avatar']['size'] == 0) {
        return false;
    } elseif (move_uploaded_file($ava['avatar']['tmp_name'], $newPath)) {
        $sql = 'INSERT INTO avatar_user (user_id, avatar) VALUES (?, ?)';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $avaName);
        return $stmt->execute();
    } else {
        return false;
    }
}

<?php
require 'function.php';
if (is_not_logged_in()) {
    header('Location: /login_user.php');
}
header('Location: /users.php');

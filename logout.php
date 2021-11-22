<?php
require 'function.php';
unset($_SESSION['email'], $_SESSION['id']);
redirect('/login_user.php');
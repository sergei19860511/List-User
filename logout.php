<?php
require 'function.php';
unset($_SESSION['email'], $_SESSION['pass']);
redirect('/login_user.php');
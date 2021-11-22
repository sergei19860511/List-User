<?php
require 'function.php';
updateUserStatus($_POST['status'],$_POST['id']);
setFlashMessage('success', 'Профиль успешно изменён');
redirect('/users.php');
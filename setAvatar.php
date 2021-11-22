<?php
require 'function.php';
if (!uploadAvaUser($_POST['id'], $_FILES)) {
    setFlashMessage('danger', 'Аватар не обновлён, выберите файл с другим расширением или меньший размер');
} else {
    setFlashMessage('success', 'Профиль успешно обновлён');
}
redirect('/users.php');
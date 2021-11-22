<?php
require 'function.php';
if (is_not_logged_in()) {
    redirect('/login_user.php');
}
if (!checkUserRole() && !is_author($_SESSION['id'], $_GET['id'])) {
    setFlashMessage('danger', 'Редактировать личные данные можно только в своём профиле');
    redirect('/users.php');
}
?>
<?php
require 'header.php';
$status = [
    'Онлайн',
    'Отошел',
    'Не беспокоить',
];
$userStatus = getStatusUser($_GET['id']);
?>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-sun'></i> Установить статус
            </h1>

        </div>
        <form action="setStatus.php" method="post">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Установка текущего статуса</h2>
                            </div>
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- status -->
                                        <div class="form-group">
                                            <label class="form-label" for="example-select">Выберите статус</label>
                                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                            <select class="form-control" name="status" id="example-select">
                                                <?php foreach ($status as $item): ?>
                                                    <option <?= $userStatus[1] == $item ? 'selected' : '' ?>><?= $item; ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning">Set Status</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </main>

<?php
require 'footer.php';
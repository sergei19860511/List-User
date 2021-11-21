<?php
require 'function.php';
if (is_not_logged_in()) {
    redirect('/login_user.php');
}
if (!checkUserRole() && !is_author($_SESSION['id'], $_GET['id'])) {
    setFlashMessage('danger', 'Редактировать данные для входа можно только в своём профиле');
    redirect('/users.php');
}
?>
<?php
require 'header.php';
?>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <?php
        ?>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-lock'></i> Безопасность
            </h1>
        </div>
        <?php
        $user = getUserById($_GET['id']);
        ?>
        <form action="security_handler.php" method="post">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Обновление эл. адреса и пароля</h2>
                            </div>
                            <div class="panel-content">
                                <!-- email -->
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Email</label>
                                    <input type="text" name="email" id="simpleinput" class="form-control" value="<?= $user['email'] ?>">
                                </div>

                                <!-- password -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Пароль</label>
                                    <input type="password" name="pass" id="simpleinput" class="form-control">
                                </div>

                                <!-- password confirmation-->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Подтверждение пароля</label>
                                    <input type="password" id="simpleinput" class="form-control">
                                </div>


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Изменить</button>
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

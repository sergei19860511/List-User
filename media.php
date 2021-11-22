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
?>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-image'></i> Загрузить аватар
            </h1>
        </div>
        <?php
        $user = getUserById($_GET['id']);
        ?>
        <form action="setAvatar.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Текущий аватар</h2>
                            </div>
                            <div class="panel-content">
                                <div class="form-group">
                                    <img src="img/imgAvatar/<?= empty($user['avatar']) ? 'no-avatar.png' : $user['avatar'] ?>" alt="" class="img-responsive" width="200">
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                    <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                    <input type="file" name="avatar" id="example-fileinput" class="form-control-file">
                                </div>

                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Загрузить</button>
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
<?php
require "php/db.php";
include_once 'php/functions.php';

if (array_key_exists('logged_user', $_SESSION)) {
    $user = $_SESSION['logged_user'];
    $data = $_POST;
    $studentid_num = get_studentid_by_id($user['studentid_id'])['student_id_num'];
    $user_status = get_user_status_by_id($user['user_status'])['status'];

    //errors
    $errors = array();
    $old_password_error = null;
    $new_password_error = null;
    $repeat_password_error = null;

    // tabs
    if (!isset($_GET['tab'])) {
        $tab = "profile";
    } else {
        $tab = $_GET['tab'];
    }

    // EDIT USER INFO
    if (isset($data['do_update'])) {
        console_log($user);
        $newTelegram = $data['telegram'];
        $newEmail = $data['email'];

        if ($newEmail != $user['email']) {
            if (trim($newEmail) == '') {
                $errors[] = 'Введіть електронну адресу.';
            }
            if (count_users_by_email($newEmail) > 0) {
                $errors[] = "Електронна адреса вже використовується.";
            }
        }

        if ($newTelegram != $user['telegram_username']) {
            if (trim($newTelegram) == '') {
                $errors[] = 'Введіть телеграм логін.';
            }
            if (count_users_by_telegram($newTelegram) > 0) {
                $errors[] = "Телеграм логін вже використовується";
            }
        }

        if (empty($errors)) {
            update_email($user['id'], $newEmail);
            update_telegram($user['id'], $newTelegram);

            header("location: profile.php#" . $tab);
        }
    }

    // CHANGE PASSWORD
    if (isset($data['do_change_pass'])) {
        $curPass = $user['password'];
        $oldPass = $data['password_old'];
        $newPass = $data['password_new'];
        $conPass = $data['password_confirmation'];

        if (password_verify($oldPass, $curPass)) {
            if ($newPass == '') {
                header("location: profile.php#password");
                $new_password_error = 'Поле нового паролю не може бути порожнім';
            }
            if (
                !empty(preg_match('/[^a-zA-Z0-9]/', $newPass)) or strlen($newPass) < 8
                or strlen($newPass) > 20 or empty(preg_match("/[a-z]/", $newPass))
                or empty(preg_match("/[A-Z]/", $newPass)) or empty(preg_match("/[0-9]/", $newPass))
            ) {
                header("location: profile.php#password");
                $new_password_error = 'Новий пароль не відповідає вимогам';
            }
            if ($newPass != $conPass) {
                header("location: profile.php#password");
                $repeat_password_error = "Підтвердження нового паролю не співпадає";
            }
            if (!($new_password_error or $repeat_password_error)) {
                $pass = password_hash($newPass, PASSWORD_DEFAULT);
                update_password($user['id'], $pass);
                $user['password'] = $pass;
                header("location: profile.php#password");
            }
        } else {
            $old_password_error = "Неправильний пароль";
            header("location: profile.php#password");
        }
    }

    $user_announcements = get_user_annoncements($user['id']);
} else {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Профіль | StepHub</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">

    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="css/profile.css" rel="stylesheet">
</head>

<body>
    <!-- Preloader -->
    <?php include_once 'templates/preloader.html'; ?>

    <!-- Back to top button -->
    <a id="back-to-top-button"></a>

    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Errors -->
    <?php include_once "templates/errors.php"; ?>

    <!-- Page Content -->
    <div class="container">
        <div class="row pb-5">
            <div class="col-md-3 px-0 pl-md-3 pr-md-0">

                <div class="card mt-md-5 profile-left-menu shadow-sm border-xs-0">
                    <div class="card-body diagonal-gradient-gray-light">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link my-1 active" id="profile-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="profile" aria-selected="true"><i class="material-icons mr-2">account_circle</i>Мій профіль</a>
                            <a class="nav-link my-1" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false"><i class="material-icons mr-2">lock</i>Змінити пароль</a>
                            <a class="nav-link my-1" id="alerts-tab" data-toggle="pill" href="#alerts" role="tab" aria-controls="alerts" aria-selected="false"><i class="material-icons mr-2">notifications</i>Сповіщення<span class="badge badge-secondary ml-2">1</span></a>
                            <a class="nav-link my-1" id="announcements-tab" data-toggle="pill" href="#announcements" role="tab" aria-controls="announcements" aria-selected="false"><i class="material-icons mr-2">list</i>Мої оголошення<?= ($user_announcements) ? "<span class='badge badge-secondary ml-2'>" . count($user_announcements) . "</span>" : "" ?></a>
                            <a class="nav-link my-1" id="delete-tab" data-toggle="pill" href="#delete" role="tab" aria-controls="delete" aria-selected="false"><i class="material-icons mr-2">cancel</i>Видалити акаунт</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9 px-0 pl-md-0 pr-md-3">

                <div class="card mt-md-5 profile-right-menu shadow-sm border-xs-0">
                    <div class="card-body px-2 px-md-3 py-4 py-md-3">
                        <div class="tab-content" id="v-pills-tabContent">

                            <div class="tab-pane fade <?= ($tab == "profile") ? "active show" : "" ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="container">
                                    <form id="form-update-profile" class="form" action="profile.php" method="POST">
                                        <div class="form-group row">
                                            <label class="col-12 col-md-3 col-form-label text-left text-md-right" for="inputLogin">Ваше ім'я</label>
                                            <div class="col-12 col-md-9">
                                                <input name="login" class="form-control" type="text" id="inputLogin" value="<?= $user['login'] ?>" required aria-describedby="loginHelp" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-md-3 col-form-label text-left text-md-right" for="inputEmail">Ел. пошта</label>
                                            <div class="col-12 col-md-9">
                                                <input name="email" class="form-control" type="email" id="inputEmail" value="<?= $user['email'] ?>" placeholder="example@gmail.com" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-md-3 col-form-label text-left text-md-right" for="inputTelegram">Телеграм</label>
                                            <div class="col-12 col-md-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">@</div>
                                                    </div>
                                                    <input name="telegram" class="form-control" type="text" id="inputTelegram" value="<?= $user['telegram_username'] ?>" placeholder="example" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row ">
                                            <label class="col col-md-3 col-form-label text-right" for="inputStudNum">Студентський</label>
                                            <div class="col col-md-3">
                                                <input name="stud_num" class="form-control disabled" type="text" id="inputStudNum" value="<?= $studentid_num ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col col-md-3 col-form-label text-right" for="inputReg">Дата реєстрації</label>
                                            <div class="col col-md-3">
                                                <input name="status" class="form-control" type="text" id="inputReg" value="<?= show_date($user['reg_date']) ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col col-md-3 col-form-label text-right" for="inputStudNum">Статус профілю</label>
                                            <div class="col col-md-3">
                                                <input name="status" class="form-control" type="text" value="<?= $user_status ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <?php if ($user['banned_to']) : ?>
                                                <label class="col col-md-3 col-form-label text-right" for="inputBan">Забанено до</label>
                                                <div class="col col-md-3">
                                                    <input name="status" class="form-control" type="text" id="inputBan" value="<?= show_date($user['banned_to']) ?>" readonly>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="row justify-content-center">
                                            <a type="button" class="btn btn-xs-block my-btn-blue mx-3 mb-3" data-toggle="modal" data-target="#updateModal">Зберегти зміни</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade <?= ($tab == "password") ? "active show" : "" ?>" id="password" role="tabpanel" aria-labelledby="password-tab">
                                <div class="container">
                                    <form class="form" action="profile.php" method="post">
                                        <div class="form-group row px-md-3">
                                            <label class="col-sm-3 col-form-label text-left text-md-right" for="inputPassword">Старий пароль</label>
                                            <div class="col-sm-9">
                                                <input name="password_old" class="form-control" type="password" id="inputPasswordOld" placeholder="Введіть ваш пароль" required aria-describedby="passHelp1">
                                                <small id="passHelp1" class="form-text text-danger"><?= $old_password_error ?></small>
                                            </div>
                                        </div>
                                        <div class="form-group row px-md-3">
                                            <label class="col-sm-3 col-form-label text-left text-md-right" for="inputPassword">Новий пароль</label>
                                            <div class="col-sm-9">
                                                <input name="password_new" class="form-control" type="password" id="inputPasswordNew" placeholder="Введіть новий пароль" required aria-describedby="passHelp2">
                                                <?php if ($new_password_error) : ?>
                                                    <small id="passHelp1" class="form-text text-danger"><?= $new_password_error ?></small>
                                                <?php else : ?>
                                                    <small id="passHelp2" class="form-text text-muted">
                                                        Ваш пароль має бути довжиною 8-20 символів, може містити літери та цифри, і не може містити пробіли, спеціальні символи, або емоджі.
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group row px-md-3">
                                            <label class="col-sm-3 col-form-label text-left text-md-right" for="inputPasswordConfirm">Підтвердження</label>
                                            <div class="col-sm-9">
                                                <input name="password_confirmation" class="form-control" type="password" id="inputPasswordConfirm" placeholder="Повторіть новий пароль" required aria-describedby="passHelp3">
                                                <small id="passHelp3" class="form-text text-danger"><?= $repeat_password_error ?></small>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <button class="btn btn-xs-block my-btn-blue float-right mx-3 mt-3 mb-3" type="submit" name="do_change_pass">Змінити пароль</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade <?= ($tab == "alerts") ? "active show" : "" ?>" id="alerts" role="tabpanel" aria-labelledby="alerts-tab">
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col px-0 px-md-3">
                                            <div class="alert alert-warning mb-0" role="alert">
                                                Функціонал сповіщень знаходиться на стадії розробки
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade <?= ($tab == "announcements") ? "active show" : "" ?>" id="announcements" role="tabpanel" aria-labelledby="announcements-tab">
                                <div class="container">
                                    <div class="row">
                                        <div class="col px-0 px-md-3">
                                            <?php if ($user_announcements) :
                                                foreach ($user_announcements as $announcement) : ?>
                                                    <div class="card text-left mb-3 clickable bg-white announcement-card" onclick="location.href='announcement.php?id=<?= $announcement['id'] ?>'">
                                                        <div class="card-body p-2 p-md-3">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <h5 class="card-title"><?= $announcement['title'] ?></h5>
                                                                    <p class="card-text"><?= $announcement['details'] ?></p>
                                                                </div>
                                                                <div class="col-md-4 align-self-end">
                                                                    <a href="announcement.php?id=<?= $announcement['id'] ?>" class="btn my-btn-blue float-right">Детальніше</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>

                                            <?php else : ?>
                                                <div class="container text-center">
                                                    <h4 class="mb-4">Не знайдено ваших оголошень</h4>
                                                    <p>Ваші розміщенні оголошення будуть відображатись тут. Хочете створити оголошення зараз?</p>
                                                    <a class="btn btn-xs-block my-btn-dark mt-5" href="create-announcement.php"><i class="material-icons mr-2">post_add</i>Розмістити оголошення</a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade <?= ($tab == "delete") ? "active show" : "" ?>" id="delete" role="tabpanel" aria-labelledby="delete-tab">
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="mb-4">Видалення облікового запису StepHub</h4>
                                            <p>Видаливши ваш акаунт, ви втратите все ваші дані назавжди, відмінити цю дію не можливо.</p>
                                            <button data-toggle="modal" data-target="#deleteModal" class="btn btn-xs-block my-btn-red mt-5 mb-3">Видалити акаунт</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Update Profile -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Зберегти зміни</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ви дійсно хочете оновити дані вашого акаунту?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Скасувати</button>
                    <button class="btn my-btn-blue" type="submit" form="form-update-profile" name="do_update">Зберегти</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Delete Account -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Видалити акаунт</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Ви дійсно хочете видалити ваш обліковий запис?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Скасувати</button>
                    <a type="button" class="btn my-btn-red" href="php/delete-account.php">Видалити</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Main sctipt -->
    <script src="js/script.js"></script>
    <!-- Back to top button -->
    <script src="js/top.js"></script>
    <!-- Enable link to tab -->
    <script src="js/profile.js"></script>
</body>

</html>
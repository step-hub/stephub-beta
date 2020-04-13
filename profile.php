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

    // EDIT USER INFO
    if (isset($data['do_update'])) {
        console_log($user);
        $newTelegram = $data['telegram'];
        $newEmail = $data['email'];

        if ($newEmail != $user['email']) {
            if (trim($newEmail) == '') {
                $errors[] = 'email field is empty!!!';
            }
            if (count_users_by_email($newEmail) > 0) {
                $errors[] = "user with such email already exist!!!";
            }
        }

        if ($newTelegram != $user['telegram_username']) {
            if (trim($newTelegram) == '') {
                $errors[] = 'telegram field is empty!!!';
            }
            if (count_users_by_telegram($newTelegram) > 0) {
                $errors[] = "user with such telegram already exist!!!";
            }
        }

        if (empty($errors)) {
            update_email($user['id'], $newEmail);
            update_telegram($user['id'], $newTelegram);

            header("Refresh:0");
        }
    }

    // CHANGE PASSWORD
    if (isset($data['do_change_pass'])) {
        $curPass = $user['password'];
        $oldPass = $data['password_old'];
        $newPass = $data['password_new'];
        $conPass = $data['password_confirmation'];

        if (password_verify($oldPass, $curPass)) {
            if ($newPass != null) {
                if ($newPass == $conPass) {
                    $pass = password_hash($newPass, PASSWORD_DEFAULT);
                    console_log($pass);
                    update_password($user['id'], $pass);
                    $user['password'] = $pass;
                } else {
                    $repeat_password_error = "Your password doesn't match.";
                }
            } else {
                $new_password_error = "Empty password. Please enter your new password.";
            }
        } else {
            $old_password_error = "Wrong password!";
        }
    }
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

<body class="">
    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Page Content -->

    <div class="container">
        <div class="row pb-5">
            <div class="col-md-3 pr-0">

                <div class="card mt-5 profile-left-menu shadow">
                    <div class="card-body diagonal-gradient-gray-light">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link my-1 active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true"><i class="material-icons mr-2">account_circle</i>Мій профіль</a>
                            <a class="nav-link my-1" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="false"><i class="material-icons mr-2">lock</i>Змінити пароль</a>
                            <a class="nav-link my-1" id="v-pills-notifications-tab" data-toggle="pill" href="#v-pills-notifications" role="tab" aria-controls="v-pills-notifications" aria-selected="false"><i class="material-icons mr-2">notifications</i>Сповіщення</a>
                            <a class="nav-link my-1" id="v-pills-announce-tab" data-toggle="pill" href="#v-pills-announce" role="tab" aria-controls="v-pills-announce" aria-selected="false"><i class="material-icons mr-2">list</i>Мої оголошення</a>
                            <a class="nav-link my-1" id="v-pills-delete-tab" data-toggle="pill" href="#v-pills-delete" role="tab" aria-controls="v-pills-delete" aria-selected="false"><i class="material-icons mr-2">cancel</i>Видалити акаунт</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9 pl-0">

                <div class="card mt-5 profile-right-menu shadow">
                    <div class="card-body">
                        <div class="tab-content" id="v-pills-tabContent">

                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <form id="form-update-profile" class="form" action="profile.php" method="POST">
                                    <?php if ($errors) : ?>
                                        <div class="alert alert-danger shadow-sm" role="alert">
                                            <?= @$errors[0]; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="form-group row px-3">
                                        <label class="col-sm-3 col-form-label text-right" for="inputLogin">Ваше ім'я</label>
                                        <div class="col-sm-9">
                                            <input name="login" class="form-control" type="text" id="inputLogin" value="<?= $user['login'] ?>" required aria-describedby="loginHelp" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row px-3">
                                        <label class="col-sm-3 col-form-label text-right" for="inputEmail">Ел. пошта</label>
                                        <div class="col-sm-9">
                                            <input name="email" class="form-control" type="email" id="inputEmail" value="<?= $user['email'] ?>" placeholder="example@gmail.com" required>
                                        </div>
                                    </div>
                                    <div class="form-group row px-3">
                                        <label class="col-sm-3 col-form-label text-right" for="inputTelegram">Телеграм</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">@</div>
                                                </div>
                                                <input name="telegram" class="form-control" type="text" id="inputTelegram" value="<?= $user['telegram_username'] ?>" placeholder="example" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row px-3">
                                        <label class="col-sm-3 col-form-label text-right" for="inputStudNum">Студентський</label>
                                        <div class="col-sm-3">
                                            <input name="stud_num" class="form-control disabled" type="text" id="inputStudNum" value="<?= $studentid_num ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row px-3">
                                        <label class="col-sm-3 col-form-label text-right" for="inputReg">Дата реєстрації</label>
                                        <div class="col-sm-3">
                                            <input name="status" class="form-control" type="text" id="inputReg" value="<?= show_date($user['reg_date']) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row px-3">
                                        <label class="col-sm-3 col-form-label text-right" for="inputStudNum">Статус профілю</label>
                                        <div class="col-sm-3">
                                            <input name="status" class="form-control" type="text" value="<?= $user_status ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row px-3">
                                        <?php if ($user['banned_to']) : ?>
                                            <label class="col-sm-3 col-form-label text-right" for="inputBan">Забанено до</label>
                                            <div class="col-sm-3">
                                                <input name="status" class="form-control" type="text" id="inputBan" value="<?= show_date($user['banned_to']) ?>" readonly>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row justify-content-center">
                                        <a type="button" class="btn my-btn-blue mx-3 mb-3" data-toggle="modal" data-target="#updateModal">Зберегти зміни</a>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                                <form class="form" action="profile.php" method="post">
                                    <div class="form-group row px-3">
                                        <label class="col-sm-3 col-form-label text-right" for="inputPassword">Старий пароль</label>
                                        <div class="col-sm-9">
                                            <input name="password_old" class="form-control" type="password" id="inputPasswordOld" placeholder="Введіть ваш пароль" required aria-describedby="passHelp1">
                                            <small id="passHelp1" class="form-text text-danger"><?= $old_password_error ?></small>
                                        </div>
                                    </div>
                                    <div class="form-group row px-3">
                                        <label class="col-sm-3 col-form-label text-right" for="inputPassword">Новий пароль</label>
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
                                    <div class="form-group row px-3">
                                        <label class="col-sm-3 col-form-label text-right" for="inputPasswordConfirm">Підтвердження</label>
                                        <div class="col-sm-9">
                                            <input name="password_confirmation" class="form-control" type="password" id="inputPasswordConfirm" placeholder="Повторіть новий пароль" required aria-describedby="passHelp3">
                                            <small id="passHelp3" class="form-text text-danger"><?= $repeat_password_error ?></small>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <button class="btn my-btn-blue float-right mr-3" type="submit" name="do_change_pass">Змінити пароль</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="v-pills-notifications" role="tabpanel" aria-labelledby="v-pills-notifications-tab">
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <div class="alert alert-warning shadow-sm" role="alert">
                                                Функціонал сповіщень знаходиться на стадії розробки
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-announce" role="tabpanel" aria-labelledby="v-pills-announce-tab">

                            </div>

                            <div class="tab-pane fade" id="v-pills-delete" role="tabpanel" aria-labelledby="v-pills-delete-tab">
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="mb-5">Видалення облікового запису StepHub</h4>
                                            <p>Видаливши ваш акаунт, ви втратите все ваші дані назавжди, відмінити цю дію не можливо.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            <button data-toggle="modal" data-target="#deleteModal" class="btn my-btn-red shadow-sm">Видалити акаунт</button>
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
                    <a type="button" class="btn my-btn-red" href="php/logout.php">Видалити</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
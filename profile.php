<?php
require "php/db.php";
include_once 'php/functions.php';


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
    $newTelegram = $data['telegram'];
    $newEmail = $data['email'];

//    alert($newTelegram);
    console_log($user);

    if($newEmail != $user['email']) {
        if (trim($newEmail) == '') {
            $errors[] = 'email field is empty!!!';
        }
        if (count_users_by_email($newEmail) > 0) {
            $errors[] = "user with such email already exist!!!";
        }
    }

    if($newTelegram != $user['telegram_username']) {
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

        alert($user['telegram_username']);
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
?>

<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>StepHub | Профіль</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
</head>

<body class="">
    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Page Content -->
    <?php if (array_key_exists('logged_user', $_SESSION)): ?>
        <div class="container">
            <div class="card mt-5">
                <div class="row">

                    <div class="col-md-8">
                        <div class="card-body shadow-sm">
                            <form class="form" action="profile.php" method="POST">

                                <?php if ($errors): ?>
                                    <p class="mt-0 mb-0 font-weight-bold text-danger"><?= @$errors[0]; ?></>
                                <?php endif; ?>

                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputLogin">Ваше ім'я</label>
                                    <div class="col-sm-9">
                                        <input name="login" class="form-control" type="text" id="inputLogin" value="<?= $user['login']?>" required aria-describedby="loginHelp" readonly>
                                    </div>
                                </div>
                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputEmail">Ел. пошта</label>
                                    <div class="col-sm-9">
                                        <input name="email" class="form-control" type="email" id="inputEmail" value="<?= $user['email']?>" placeholder="example@gmail.com" required>
                                    </div>
                                </div>
                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputTelegram">Телеграм</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">@</div>
                                            </div>
                                            <input name="telegram" class="form-control" type="text" id="inputTelegram" value="<?= $user['telegram_username']?>" placeholder="example" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputStudNum">Студентський</label>
                                    <div class="col-sm-3">
                                        <input name="stud_num" class="form-control disabled" type="text" id="inputStudNum" value="<?= $studentid_num?>" readonly>
                                    </div>
                                    <label class="col-sm-3 col-form-label text-right" for="inputStudNum">Статус профілю</label>
                                    <div class="col-sm-3">
                                        <input name="status" class="form-control" type="text" value="<?= $user_status?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputReg">Дата реєстрації</label>
                                    <div class="col-sm-3">
                                        <input name="status" class="form-control" type="text" id="inputReg" value="<?= show_date($user['reg_date']) ?>" readonly>
                                    </div>
                                    <?php if($user['banned_to']): ?>
                                    <label class="col-sm-3 col-form-label text-right" for="inputBan">Забанено до</label>
                                    <div class="col-sm-3">
                                        <input name="status" class="form-control" type="text" id="inputBan" value="<?= show_date($user['banned_to']) ?>" readonly>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn my-btn-blue float-right mx-3 mb-3" type="submit" name="do_update"><i class="fa fa-save mr-2"></i>Зберегти</button>
                                    </div>
                                </div>
                            </form>

                            <form class="form" action="profile.php" method="post">
                                <div class="card">
                                    <div class="card-header my-bg-gray">
                                        <i class="fa fa-key mr-2"></i>
                                        Змінити пароль
                                    </div>
                                    <div class="card-body my-bg-light px-0">
                                        <div class="form-group row px-3">
                                            <label class="col-sm-3 col-form-label" for="inputPassword">Старий пароль</label>
                                            <div class="col-sm-9">
                                                <input name="password_old" class="form-control" type="password" id="inputPasswordOld" placeholder="Введіть ваш пароль" required aria-describedby="passHelp1">
                                                <small id="passHelp1" class="form-text text-danger"><?= $old_password_error ?></small>
                                            </div>
                                        </div>
                                        <div class="form-group row px-3">
                                            <label class="col-sm-3 col-form-label" for="inputPassword">Новий пароль</label>
                                            <div class="col-sm-9">
                                                <input name="password_new" class="form-control" type="password" id="inputPasswordNew" placeholder="Введіть новий пароль" required aria-describedby="passHelp2">
                                                <?php if($new_password_error): ?>
                                                    <small id="passHelp1" class="form-text text-danger"><?= $new_password_error ?></small>
                                                <?php else: ?>
                                                    <small id="passHelp2" class="form-text text-muted">
                                                        Ваш пароль має бути довжиною 8-20 символів, може містити літери та цифри, і не може містити пробіли, спеціальні символи, або емоджі.
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group row px-3">
                                            <label class="col-sm-3 col-form-label" for="inputPasswordConfirm">Підтвердження</label>
                                            <div class="col-sm-9">
                                                <input name="password_confirmation" class="form-control" type="password" id="inputPasswordConfirm" placeholder="Повторіть новий пароль" required aria-describedby="passHelp3">
                                                <small id="passHelp3" class="form-text text-danger"><?= $repeat_password_error ?></small>
                                            </div>
                                        </div>
                                        <button class="btn my-btn-blue float-right mr-3" type="submit" name="do_change_pass">Змінити пароль</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-4 p-0">
                    </div>
                </div>
            </div>
        </div>
    <?php else:
        header("location: index.php");
    endif;?>
    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
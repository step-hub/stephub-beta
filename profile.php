<?php
require "php/db.php";
include_once 'php/functions.php';
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
                <div class="card-body shadow-sm">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form" action="profile.php" method="POST">
                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputLogin">Ваше ім'я</label>
                                    <div class="col-sm-9">
                                        <input name="login" class="form-control" type="text" id="inputLogin" value="" placeholder="Ім'я користувача" required aria-describedby="loginHelp">
                                        <small id="loginHelp" class="form-text text-muted">
                                            Ваш логін може складитись із латинських літер та цифр.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputEmail">Ел. пошта</label>
                                    <div class="col-sm-9">
                                        <input name="email" class="form-control" type="email" id="inputEmail" value="" placeholder="example@gmail.com" required>
                                    </div>
                                </div>
                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputTelegram">Телеграм</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">@</div>
                                            </div>
                                            <input name="telegram" class="form-control" type="text" id="inputTelegram" value="" placeholder="example" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputStudNum">Студентський</label>
                                    <div class="col-sm-3">
                                        <input name="stud_num" class="form-control disabled" type="text" id="inputStudNum" value="AБ12345678" readonly>
                                    </div>
                                    <label class="col-sm-3 col-form-label text-right" for="inputStudNum">Статус профілю</label>
                                    <div class="col-sm-3">
                                        <input name="status" class="form-control" type="text" value="user" readonly>
                                    </div>
                                </div>

                                <div class="form-group row px-3">
                                    <label class="col-sm-3 col-form-label text-right" for="inputReg">Дата реєстрації</label>
                                    <div class="col-sm-3">
                                        <input name="status" class="form-control" type="text" id="inputReg" value="<?= show_date(124312) ?>" readonly>
                                    </div>
                                    <label class="col-sm-3 col-form-label text-right" for="inputBan">Забанено до</label>
                                    <div class="col-sm-3">
                                        <input name="status" class="form-control" type="text" id="inputBan" value="<?= show_date(124312) ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <button class="btn my-btn-blue float-right mx-3 mb-3" type="submit" name="do_update">Оновити</button>
                                </div>
                            </form>

                            <form class="form" action="profile.php" method="post">
                                <div class="card">
                                    <div class="card-header my-bg-gray">
                                        Змінити пароль
                                    </div>
                                    <div class="card-body my-bg-light px-0">
                                        <div class="form-group row px-3">
                                            <label class="col-sm-3 col-form-label" for="inputPassword">Пароль</label>
                                            <div class="col-sm-9">
                                                <input name="password" class="form-control" type="password" id="inputPassword" placeholder="Пароль" required aria-describedby="passHelp">
                                                <small id="passHelp" class="form-text text-muted">
                                                    Ваш пароль має бути довжиною 8-20 символів, може містити літери та цифри, і не може містити пробіли, спеціальні символи, або емоджі.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="form-group row px-3">
                                            <label class="col-sm-3 col-form-label" for="inputPasswordConfirm">Підтвердження</label>
                                            <div class="col-sm-9">
                                                <input name="password_confirmation" class="form-control" type="password" id="inputPasswordConfirm" placeholder="Повторіть пароль" required>
                                            </div>
                                        </div>
                                        <button class="btn my-btn-blue float-right mr-3" type="submit" name="do_change_pass">Змінити пароль</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                    <div class="row">

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
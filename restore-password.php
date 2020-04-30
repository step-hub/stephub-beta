<?php
require "php/db.php";
include_once 'php/functions.php';

$data_post = $_POST;
$data_get = $_GET;
$errors = array();

if (isset($data_get['token'])) {
    $user_to_restore = R::findOne('users', 'token LIKE ?', array($data_get['token']));
}

if (isset($data_post['do_send_token'])) {
    if ($data_post['email'] != null) {
        $user = R::findOne('users', 'email = ?', array($data_post['email']));
        if (!empty($user)) {
            if ($user['token'] == null) {
                $user_token = generate_random_string(80);
                $user['token'] = $user_token;
                $link = 'https://stephub.000webhostapp.com/restore-password.php?token=' . $user_token;
                mail($user['email'], 'Restore password', 'Restore password ' . $link, 'From: stephub.com@gmail.com');
                //               show message that email is sent and redirect to main page
                R::store($user);
            } else {
                $errors[] = 'Ваш аккаунт не активовано';
            }
        } else {
            $errors[] = 'Користувача з таким email не знайдено';
        }
    } else {
        $errors[] = 'email не може бути пустим';
    }
}

if (isset($data_post['do_restore'])) {
    $user = R::findOne('users', 'id = ?', array($data_post['user_id']));
    if (!empty($user)) {
        if ($data_post['password'] == $data_post['password_confirmation']) {
            $user['password'] = password_hash($data_post['password'], PASSWORD_DEFAULT);
            $user['token'] = null;
            R::store($user);
        } else {
            $errors[] = 'Паролі не збігаються';
        }
    }
}
?>
<!doctype html>
<html lang="ua">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Відновити пароль | StepHub</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">

    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
</head>

<body class="text-center">

    <!-- Preloader -->
    <?php include_once 'templates/preloader.html'; ?>

    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Errors -->
    <?php include_once "templates/errors.php"; ?>

    <!-- Page Content -->
    <div class="container pt-0 pt-md-5">
        <div class="row justify-content-md-center">
            <div class="col col-md-6 px-0 px-md-3">
                <div class="card shadow-sm border-xs-0">
                    <div class="card-header">
                        <i class="fas fa-key mr-2"></i>Відновлення паролю
                    </div>
                    <div class="card-body">
                        <?php if (isset($data_post['do_restore'])) : ?>
                            <!--  Show message that password was restored  -->
                            <h1><i class="fas fa-check-circle display-2 text-success"></i></h1>
                            <h3>Ваш пароль успішно змінено!</h3>
                            <a href="index.php" class="btn btn-outline-success mt-5">На головну</a>
                        <?php elseif (empty($user_to_restore)) : ?>
                            <!--  Send mail  -->
                            <form class="form-group mb-0" action="restore-password.php" method="POST">
                                <p>Будь ласка, введіть електронну адресу, яку ви використовували для входу на сайт.</p>
                                <input type="email" id="email" name="email" class="form-control" placeholder="example@mail.com">
                                <div class="row">
                                    <div class="col-12 col-md-6 order-12 order-md-1 pt-3">
                                        <a href="index.php" class="btn btn-xs-block btn-outline-secondary float-left"><i class="fas fa-chevron-left mr-2"></i>Назад</a>
                                    </div>
                                    <div class="col-12 col-md-6 order-1 order-md-12 pt-3">
                                        <button class="btn btn-xs-block my-btn-blue float-right" type="submit" name="do_send_token">Відправити</button>
                                    </div>
                                </div>
                            </form>
                        <?php else : ?>
                            <!--  Change password  -->
                            <form class="form-group mb-0" action="restore-password.php" method="POST">
                                <input type="hidden" value="<?= $user_to_restore['id'] ?>" name="user_id">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Новий пароль">
                                <small id="passHelp" class="form-text text-muted">
                                    Ваш пароль має бути довжиною 8-20 символів, має містити цифри та літери, одна з яких велика, і не може містити пробіли, спеціальні символи, або емоджі.
                                </small>
                                <input type="password" id="password-confirmation" name="password_confirmation" class="form-control mt-3" placeholder="Підтвердження паролю">
                                <div class="row">
                                    <div class="col-12 col-md-6 order-12 order-md-1 pt-3">
                                        <a href="index.php" class="btn btn-xs-block btn-outline-secondary float-left"><i class="fas fa-chevron-left mr-2"></i>Назад</a>
                                    </div>
                                    <div class="col-12 col-md-6 order-1 order-md-12 pt-3">
                                        <button class="btn btn-xs-block my-btn-blue float-right" type="submit" name="do_restore">Відновити пароль</button>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <script src="js/script.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Main sctipt -->
    <script src="js/script.js"></script>
</body>

</html>
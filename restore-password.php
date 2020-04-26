<?php
require "php/db.php";
include_once 'php/functions.php';

$data_post = $_POST;
$data_get = $_GET;
$errors = array();

if (isset($data_get['token'])){
    $user_to_restore = R::findOne('users', 'token LIKE ?', array($data_get['token']));
}

if (isset($data_post['do_send_token'])){
    if ($data_post['email'] != null){
        $user = R::findOne('users', 'email = ?', array($data_post['email']));
        if (!empty($user)){
            if ($user['token'] == null){
                $user_token = generate_random_string(80);
                $user['token'] = $user_token;
                $link = 'https://stephub.000webhostapp.com/restore-password.php?token=' . $user_token;
                mail($user['email'], 'Restore password', 'Restore password '.$link, 'From: stephub.com@gmail.com');
//               show message that email is sent and redirect to main page
                R::store($user);
            }
            else {
                $errors[] = 'Ваш аккаунт не активовано';
            }
        }
        else {
            $errors[] = 'Користувача з таким email не знайдено';
        }
    }
    else {
        $errors[] = 'email не може бути пустим';
    }
}

if (isset($data_post['do_restore'])){
    $user = R::findOne('users', 'id = ?', array($data_post['user_id']));
    if (!empty($user)){
        if ($data_post['password'] == $data_post['password_confirmation']){
            $user['password'] = password_hash($data_post['password'], PASSWORD_DEFAULT);
            $user['token'] = null;
            R::store($user);
        }
        else {
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
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
</head>
<body class="text-center">
<div class="container">
    <div class="row justify-content-center">
        <!-- Preloader -->
        <?php include_once 'templates/preloader.html'; ?>

        <!-- Back to top button -->
        <a id="back-to-top-button"></a>

        <!-- Navigation -->
        <?php include_once 'templates/navbar.php'; ?>

        <?php if (isset($data_post['do_restore'])) :?>
            <!--    Show message that password was restored  -->
        <?php elseif (empty($user_to_restore)):?>
            <form class="form-group" action="restore-password.php" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control">
                <button class="btn btn-lg my-btn-blue shadow-sm" type="submit" name="do_send_token">Відправити</button>
            </form>
        <?php else : ?>
            <form class="form-group" action="restore-password.php" method="POST">
                <input type="hidden" value="<?= $user_to_restore['id'] ?>" name="user_id">
                <label for="password">Новий пароль</label>
                <input type="password" id="password" name="password" class="form-control">
                <label for="password-confirmation">Підтвердження паролю</label>
                <input type="password" id="password-confirmation" name="password_confirmation" class="form-control">
                <button class="btn btn-lg my-btn-blue shadow-sm" type="submit" name="do_restore">Відновити пароль</button>
            </form>
        <?php endif; ?>
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
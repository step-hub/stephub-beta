<?php
require "php/db.php";
include_once "php/functions.php";

if (array_key_exists('logged_user', $_SESSION) and $_SESSION['logged_user']->user_status < 3) {
    $data_get = $_GET;
    $data_post = $_POST;
    $errors = array();

    if (isset($data_post['do_send'])) {
        if ($data_post['subject'] == '')
            $errors[] = 'Має бути написана тема повідомлення';
        if ($data_post['message'] == '')
            $errors[] = 'Повідомлення не може бути пустим';

        if (!$errors) {
            $user = R::findOne('users', 'id = ?', array($data_post['to']));
            mail($user['email'], $data_post['subject'], $data_post['message'], 'From: stephub.com@gmail.com');
            echo "<script>window.close()</script>>";
        }
    } elseif (!array_key_exists('id', $data_get)) {
        header("location: index.php");
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

    <title>Відправити Email | StepHub</title>

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
    <div class="container pt-5 d-none d-md-block">
        <div class="card mt-0 shadow-sm">
            <form action="mail.php" method="POST" class="form-group mb-0">
                <div class="card-header diagonal-gradient-gray my-color-dark border-bottom-0">
                    <div class="container">
                        <div class="row pb-2 pt-sm-2">
                            <input type="text" name="to" class="form-control" value="<?= $data_get ? $data_get['id'] : $data_post['to'] ?>" hidden>
                            <input type="text" name="subject" id="mail_subject" value="<?= $data_post ? $data_post['subject'] : '' ?>" class="form-control form-control-lg my-bg-light my-color-dark" placeholder="Заголовок">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <textarea name="message" id="mail_message" cols="30" rows="10" class="form-control" value="<?= $data_post ? $data_post['message'] : '' ?>" placeholder="Повідомлення"></textarea>
                </div>
                <div class="card-footer p-3">
                    <div class="row px-3">
                        <button type="submit" name="do_send" class="btn my-btn-dark ml-auto">Відправити</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Mobile Does not Suppported -->
    <div class="container-fluid d-md-none p-3">
        <div class="alert alert-danger shadow-sm" role="alert">
            <p>Сторінка відправки листа не доступна в мобільній версії сайту.</p>
            <a href="index.php"> Повернутись на головну сторінку</a>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Main sctipt -->
    <script src="js/script.js"></script>
</body>

</html>
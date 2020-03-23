<?php
require "php/db.php";
include_once "php/functions.php";

if (array_key_exists('logged_user', $_SESSION) and $_SESSION['logged_user']->user_status < 3){
    $data_get = $_GET;
    $data_post = $_POST;

    if (isset($data_post['do_send'])){
        $user = R::findOne('users', 'id = ?', array($data_post['to']));
        mail($user['email'], $data_post['subject'], $data_post['message'], 'From: stephub.com@gmail.com');
        echo "<script>window.close()</script>>";
    }
    elseif (!array_key_exists('id', $data_get)){
        header("location: index.php");
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

    <title>StepHub | Відправити email</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
</head>

<body class="text-center" style="padding-top: 46px !important;">
<!-- Navigation -->
<?php include_once 'templates/navbar.php'; ?>
<?php if (array_key_exists('logged_user', $_SESSION) and $_SESSION['logged_user']->user_status < 3): ?>
    <div class="container">
        <form action="mail.php" method="POST" class="form-group">
            <input type="text" name="to" class="form-control" value="<?= $data_get['id']?>" hidden>
            <label for="mail_subject">Тема</label>
            <input type="text" name="subject" id="mail_subject"  class="form-control">
            <label for="mail_message">Повідомлення</label>
            <textarea name="message" id="mail_message" cols="30" rows="10" class="form-control"></textarea>
            <button name="do_send" type="submit" class="btn btn-info">Відправити</button>
        </form>
    </div>
<? endif; ?>

<!-- Footer -->
<?php include_once 'templates/footer.php'; ?>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
require "php/db.php";
include_once "php/functions.php";

$data = $_POST;
$error = "";

if (isset($data['do_login'])) {

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <link rel="shortcut icon" href="favicon.png">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC&display=swap" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-login" action="login.php" method="POST">
        <p class="mt-5 mb-3 font-weight-bold text-danger"><?= $error ?></p>
        <a href="index.php">
            <img class="mb-4" src="img/logo.jpg" alt="square logo" width="72" height="72">
        </a>
        <h1 class="h3 mb-3 font-weight-normal">Please log in</h1>

        <label for="inputLogin" class="sr-only">Login</label>
        <input type="login" id="inputLogin" name="login" class="form-control" placeholder="Username" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me" name="remember"> Remember me
            </label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit" name="do_login">Log in</button>
        <p class="mt-5 mb-3">Don't have an account? <a href="registration.php">Register Now</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; StepHub 2020</p>
    </form>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
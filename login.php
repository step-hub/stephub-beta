<?php
require "php/db.php";
include_once "php/functions.php";

$data = $_POST;
$errors = array();

if (isset($data['do_login'])) {
    $user = R::findOne('users', 'login = ?', array($data['login']));

    if ($user) {
        if (password_verify($data['password'], $user->password)) {
            // login session
            $_SESSION['logged_user'] = $user;
            $user->is_online = 1;
            R::store($user);

            // login cookie
            if ($data['remember']) {
                if (isset($_COOKIE['user_token']))
                    setcookie('user_token', '', 0, "/");

                $user_token = generate_random_string(80);
                $time = 31536000;
                setcookie('user_token', $user_token, time() + $time, "/");

                $login = $data['login'];

                R::exec("UPDATE `users` SET token = '$user_token' WHERE login = '$login'");
            }

            header("location: index.php");
        } else {
            $errors[] = "password is incorrect";
        }
    } else {
        $errors[] = "user with such login doesn`t exist";
    }
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
    <!-- Navigation -->
    <?php include_once 'templates/navigation.php'; ?>

    <!-- Page Content -->
    <div>
        <div class="card">
            <div class="card-body shadow-sm">
                <h1 class="h3 mb-3 font-weight-normal">Please log in</h1>

                <?php if($errors): ?>
                    <p class="mt-0 mb-0 font-weight-bold text-danger"><?= @$errors[0]; ?></>
                <?php endif; ?>

                <form class="form-login" action="login.php" method="POST">
                    <label for="inputLogin" class="sr-only">Login</label>
                    <input type="text" id="inputLogin" name="login" value="<?= @$data['login']; ?>" class="form-control bg-light" placeholder="Login" required autofocus>

                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" name="password" class="form-control bg-light" placeholder="Password" required>

                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me" name="remember"> Remember me
                        </label>
                    </div>

                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="do_login">Log in</button>
                    <p class="mt-3 mb-0">Don't have an account? <a href="registration.php">Register Now</a></p>
                </form>
            </div>
        </div>

        <p class="mt-3 text-muted">&copy; 2020 StepHub</p>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
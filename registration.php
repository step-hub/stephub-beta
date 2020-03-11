<?php
require "db.php";

$data = $_POST;
$error = "";

if (isset($data['do_signup'])) {
    if (false/*count emails in db > 0*/) {
        $error = "This email or login is used";
    } else {
        // registration
        $user = R::dispense('users');
        $user->login = $data['login'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->email = $data['email'];
        $user->telegram_username = $data['telegram'];
        $user->studentid_id = 1;
        $user->user_status = 1;
        $user->is_online = true;
        $user->reg_date = 1;
        R::store($user);

        $_SESSION['logged_user'] = $user;
        header('location: index.php');
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
	<title>Registration</title>

	<link rel="shortcut icon" href="favicon.png">

	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
	<!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="css/registration.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC&display=swap" rel="stylesheet">
</head>

<body class="text-center">
	<form class="form-login" action="registration.php" method="POST">

        <p class="mt-5 mb-3 font-weight-bold text-danger"><?= $error ?></p>
		<a href="index.php">
			<img class="mb-4" src="img/logo.jpg" alt="square logo" width="72" height="72">
		</a>
		<h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>

		<label for="inputLogin" class="sr-only">Login</label>
		<input type="login" id="inputLogin" name="login" class="form-control" placeholder="Login" required autofocus>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required>

        <label for="inputStudNum" class="sr-only">Student ID</label>
        <input type="text" id="inputStudNum" name="stud_num" class="form-control" placeholder="Student ID" required>

        <label for="inputTelegram" class="sr-only">Telegram ID</label>
        <input type="text" id="inputTelegram" name="telegram" class="form-control" placeholder="Telegram ID" required>

		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>

		<button class="btn btn-lg btn-primary btn-block" type="submit" name="do_signup">Sign up</button>
		<p class="mt-5 mb-3">Already have an account? <a href="login.php">Log In</a></p>
		<p class="mt-5 mb-3 text-muted">&copy; StepHub 2020</p>
	</form>

    <!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
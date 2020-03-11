<?php
require "php/db.php";

$data = $_POST;

if (isset($data['do_signup'])) {
    $errors = array();

    if (trim($data['login']) == ''){
        $errors[] = 'login field is empty!!!';
    }
    if (trim($data['email']) == ''){
        $errors[] = 'email field is empty!!!';
    }
    if (trim($data['stud_num']) == ''){
        $errors[] = 'stud_num field is empty!!!';
    }
    if (trim($data['telegram']) == ''){
        $errors[] = 'telegram field is empty!!!';
    }
    if ($data['password'] == ''){
        $errors[] = 'password field is empty!!!';
    }

    if ($data['password_confirmation'] != $data['password']){
        $errors[] = "password does doesn't confirm!!!";
    }

    if (R::count("users", "login = ?", array($data['login'])) > 0){
        $errors[] = "user with such login already exist!!!";
    }
    if (R::count("users", "email = ?", array($data['email'])) > 0){
        $errors[] = "user with such email already exist!!!";
    }
    if (R::count("users", "telegram_username = ?", array($data['telegram'])) > 0){
        $errors[] = "user with such telegram already exist!!!";
    }

    if (R::count("student_ids", "student_id_num = ?", array($data['stud_num'])) == 0){
        $errors[] = "user with such student num can't register!!!";
    }
    else {
        $student = R::findOne('student_ids', 'student_id_num LIKE ?', array($data['stud_num']));
        if (R::count("users", "studentid_id = ?", array($student->id)) > 0){
            $errors[] = "user with such student num has already registered!!!";
        }
    }

    if (empty($errors)){
        $user = R::dispense('users');
        $user->login = $data['login'];
        $user->email = $data['email'];
        $user->studentid_id = $student->id;
        $user->telegram_username = $data['telegram'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->is_online = 1;
        $user->user_status = 3;
        $user->reg_date = time();

        R::store($user);

        header('location: index.php');

    } else {
        $error = $errors[0];
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
        <p class="mt-5 mb-3 font-weight-bold text-danger"><?php echo @$errors[0]?></p>
		<a href="index.php">
			<img class="mb-4" src="img/logo.jpg" alt="square logo" width="72" height="72">
		</a>
		<h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>

		<label for="inputLogin" class="sr-only">Login</label>
		<input type="login" id="inputLogin" name="login" value="<?php echo @$data['login']; ?>" class="form-control" placeholder="Login" required autofocus>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email" value="<?php echo @$data['email']; ?>" class="form-control" placeholder="Email address" required>

        <label for="inputStudNum" class="sr-only">Student ID</label>
        <input type="text" id="inputStudNum" name="stud_num" value="<?php echo @$data['stud_num']; ?>" class="form-control" placeholder="Student ID" required>

        <label for="inputTelegram" class="sr-only">Telegram ID</label>
        <input type="text" id="inputTelegram" name="telegram" value="<?php echo @$data['telegram']; ?>" class="form-control" placeholder="Telegram ID" required>

		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>

		<label for="inputPasswordConfirm" class="sr-only">Confirm password</label>
		<input type="password" id="inputPasswordConfirm" name="password_confirmation" class="form-control" placeholder="Confirm password" required>

		<button class="btn btn-lg btn-primary btn-block" type="submit" name="do_signup">Sign up</button>
		<p class="mt-5 mb-3">Already have an account? <a href="login.php">Log In</a></p>
		<p class="mt-5 mb-3 text-muted">&copy; StepHub 2020</p>
	</form>

    <!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
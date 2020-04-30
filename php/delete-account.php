<?php
require_once "../vendor/redbeanphp/rb-mysql.php";

session_start();

$user = $_SESSION['logged_user'];
mail($user['email'], 'Deleted account', 'Your account was deleted', 'From: stephub.com@gmail.com');
R::trash($user);

unset($_SESSION['logged_user']);
if (isset($_COOKIE['user_token']))
    setcookie('user_token', '', 0, "/");
header('location: ../index.php');
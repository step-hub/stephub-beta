<?php
require "php/db.php";

$user = $_SESSION['logged_user'];
$user->is_online = 0;
R::store($user);

unset($_SESSION['logged_user']);
if (isset($_COOKIE['user_token']))
    setcookie('user_token', '', 0, "/");
header('location: index.php');
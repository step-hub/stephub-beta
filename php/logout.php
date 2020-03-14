<?php
require_once "../vendor/redbeanphp/rb-mysql.php";
R::setup('mysql:host=den1.mysql5.gear.host;dbname=stephub', 'stephub', 'Px475-2v?U41');
session_start();

$user = $_SESSION['logged_user'];
$user->is_online = 0;
R::store($user);

unset($_SESSION['logged_user']);
if (isset($_COOKIE['user_token']))
    setcookie('user_token', '', 0, "/");
header('location: ../index.php');
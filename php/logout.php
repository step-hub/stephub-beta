<?php
require_once "../vendor/redbeanphp/rb-mysql.php";
require_once "functions.php";

$db = get_db_connection("../db_conn.txt");
R::setup("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['username'], $db['password']);

session_start();

$user = $_SESSION['logged_user'];
$user->is_online = 0;
R::store($user);

unset($_SESSION['logged_user']);
if (isset($_COOKIE['user_token']))
    setcookie('user_token', '', 0, "/");
header('location: ../index.php');

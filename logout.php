<?php
require "php/db.php";

unset($_SESSION['logged_user']);
if (isset($_COOKIE['user_token']))
    setcookie('user_token', '', 0, "/");
header('location: index.php');
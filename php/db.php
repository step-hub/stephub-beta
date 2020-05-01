<?php
require "./vendor/redbeanphp/rb-mysql.php";
require "functions.php";

$db = get_db_connection("db_conn.txt");
R::setup("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['username'], $db['password']);

session_start();

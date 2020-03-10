<?php
require "vendor/redbeanphp/rb-mysql.php";
R::setup('mysql:host=localhost;dbname=stephub_db', 'root', '');

session_start();

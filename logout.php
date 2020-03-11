<?php
require "php/db.php";

unset($_SESSION['logged_user']);
header('location: index.php');
<?php
require "../vendor/redbeanphp/rb-mysql.php";

session_start();
$data_get = $_GET;
if (isset($data_get['token'])) {
    $user = R::findOne('users', 'token = ?', array($data_get['token']));
    if (!empty($user)) {
        $user['token'] = null;
        R::store($user);
        header("location: ../index.php?activate=true");
    } else {
        header("location: ../index.php?activate=false");
    }
} else {
    header("location: ../index.php");
}
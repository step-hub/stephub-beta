<?php

$data_get = $_GET;
if (isset($data_get['token'])) {
    $user = R::findOne('users', 'token = ?', array($data_get['token']));
    if ($user){
        $user['token'] = null;
        R::store($user);
        header("location: ../index.php?activate=true");
    }
}

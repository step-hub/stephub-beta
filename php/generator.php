<?php
// USAGE: include_once in index.php
//include_once 'php/generator.php';

for ($i = 1; $i < 51; $i++){

    $user = R::dispense('users');
    $user->login = 'login'.$i;
    $user->email = 'email'.$i.'@gmail.com';
    $user->studentid_id = $i;
    $user->telegram_username = 'username'.$i;
    $user->password = password_hash('123', PASSWORD_DEFAULT);
    $user->is_online = 0;
    $user->user_status = 3;
    $user->reg_date = time();

    R::store($user);
}

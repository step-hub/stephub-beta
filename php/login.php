<?php
date_default_timezone_set('Europe/Kiev');

$data = $_POST;
$errors = array();

if (isset($data['do_login'])) {
    $user_login = get_user_by_login($data['login']);
    $user_email = get_user_by_email($data['login']);

    if ($user_login) {
        $user = $user_login;
    } elseif ($user_email) {
        $user = $user_email;
    } else {
        $user = null;
    }

    if ($user) {
        if (password_verify($data['password'], $user->password)) {
            if ($user['token'] == null) {
                $_SESSION['logged_user'] = $user;
                $user->is_online = 1;
                R::store($user);
                
                echo '<script type="text/javascript">location.reload(true);</script>';
            } else {
                $errors[] = "Ваш акаунт не активовано. Перевірте вашу електронну пошту.";
            }
        } else {
            $errors[] = "Ви ввели неправильний пароль.";
        }
    } else {
        $errors[] = "Ви ввели неправильний логін або email.";
    }
}

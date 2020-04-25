<?php
date_default_timezone_set('Europe/Kiev');

$data = $_POST;
$errors = array();

if (isset($data['do_login'])) {
    $user = get_user_by_login($data['login']);

    if ($user) {
        if ($user['token'] != null){
            $errors[] = 'Ваш акаунт не активовано. Перевірте вашу електронну пошту.';
        }
        elseif (password_verify($data['password'], $user->password)) {
            // login session
            $_SESSION['logged_user'] = $user;
            $user->is_online = 1;
            R::store($user);

            // login cookie
//            if ($data['remember']) {
//                if (isset($_COOKIE['user_token']))
//                    setcookie('user_token', '', 0, "/");
//
//                $user_token = generate_random_string(80);
//                $time = 31536000;
//                setcookie('user_token', $user_token, time() + $time, "/");
//
//                $login = $data['login'];
//
//                R::exec("UPDATE `users` SET token = '$user_token' WHERE login = '$login'");
//            }

            echo '<script type="text/javascript">location.reload(true);</script>';
        } else {
            $errors[] = "Не правильний пароль.";
        }
    } else {
        $errors[] = "Не правильний логін.";
    }
}
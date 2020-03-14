<?php
// Show errors
ini_set("display_errors", 1);
error_reporting(-1);

function console_log($data)
{
	echo '<script>';
	echo 'console.log(' . json_encode($data) . ')';
	echo '</script>';
}

function show_array($a)
{
	echo "<pre>";
	print_r($a);
	echo "</pre>";
}

function show_date($numberofsecs)
{
    return date('Y/m/d H:i:s', $numberofsecs);
}

function generate_random_string($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function get_announcements_without_filter()
{
    return R::getAll("SELECT * FROM announcements ORDER BY date DESC LIMIT 10");
}

function get_announcements_with_filter($sort_by, $qty)
{
    return R::getAll("SELECT * FROM announcements ORDER BY ".$sort_by." DESC LIMIT ".$qty);
}

function get_user_by_login($login)
{
    return R::findOne('users', 'login = ?', array($login));
}



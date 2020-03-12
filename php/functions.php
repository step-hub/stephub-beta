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

function get_announcements()
{
    return R::getAll("SELECT * FROM announcements");
}

function get_user_by_login($login)
{
    return R::findOne('users', 'login = ?', array($login));
}



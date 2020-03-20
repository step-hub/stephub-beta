<?php
date_default_timezone_set('Europe/Kiev');

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
    return date('d.m.Y', $numberofsecs);
}

function show_detailed_date($numberofsecs)
{
    return date('d.m.Y H:i:s', $numberofsecs);
}

function show_time($numberofsecs)
{
    return date('H:i', $numberofsecs);
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

function get_announcement_by_id($id)
{
    return R::findOne('announcements', 'id = ?', array($id));
}

function get_announcements_without_filter()
{
    return R::getAll("SELECT * FROM announcements ORDER BY date DESC LIMIT 10");
}

function get_announcements_with_filter($sort_by, $sort_asc, $start, $qty)
{
    return R::getAll("SELECT * FROM announcements ORDER BY " . $sort_by . " " . $sort_asc . " LIMIT " . $start . ", " . $qty);
}

function get_announcements_with_limit($start, $num)
{
    return R::getAll("SELECT * FROM announcements ORDER BY date DESC LIMIT ". $start .", ". $num);
}

function get_comments_by_announcement_id($id)
{
    return [R::findAll('comments', "announcement_id = ? AND parent_comment_id IS NULL ORDER BY date DESC", array($id)),
        R::findAll('comments', "announcement_id = ? AND parent_comment_id IS NOT NULL ORDER BY date ASC", array($id))];
}

function get_user_by_login($login)
{
    return R::findOne('users', 'login = ?', array($login));
}

function count_comments_by_announcement_id($id)
{
    return R::count('comments', 'announcement_id = ?', array($id));
}

function count_announcements()
{
    return R::count('announcements');
}






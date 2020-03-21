<?php
date_default_timezone_set('Europe/Kiev');

// Show errors
ini_set("display_errors", 1);
error_reporting(-1);

function show_apache_owner()
{
    echo exec('whoami');
}

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

function get_upload_path()
{
    return "uploads/";
}


// ==============================================================
//
// SQL QUERIES TO DB
//
// ==============================================================

//------------------------------------------
// SELECT
//------------------------------------------

// SELECT announcements
function get_announcement_by_id($id)
{
    return R::findOne('announcements', 'id = ?', array($id));
}
function get_actual_announcements_with_filter($sort_by, $sort_asc, $start, $qty)
{
    return R::getAll("SELECT * FROM announcements WHERE announcement_status_id = 1 ORDER BY " . $sort_by . " " . $sort_asc . " LIMIT " . $start . ", " . $qty);
}
function get_announcements_with_filter($sort_by, $sort_asc, $start, $qty)
{
    return R::getAll("SELECT * FROM announcements ORDER BY " . $sort_by . " " . $sort_asc . " LIMIT " . $start . ", " . $qty);
}
function get_announcements_with_limit($start, $num)
{
    return R::getAll("SELECT * FROM announcements ORDER BY date DESC LIMIT ". $start .", ". $num);
}

// SELECT comments
function get_comments_by_announcement_id($id)
{
    return [R::findAll('comments', "announcement_id = ? AND parent_comment_id IS NULL ORDER BY date DESC", array($id)),
        R::findAll('comments', "announcement_id = ? AND parent_comment_id IS NOT NULL ORDER BY date ASC", array($id))];
}

// SELECT users
function get_user_by_login($login)
{
    return R::findOne('users', 'login = ?', array($login));
}
function get_users_with_filter($sort_by, $sort_order, $qty)
{
    return R::findAll('users', 'ORDER BY ' . $sort_by . ' ' . $sort_order . ' LIMIT ' . $qty);
}

// SELECT userstatuses
function get_user_statuses()
{
    return R::getAll("SELECT * FROM userstatuses ORDER BY id ASC");
}
function get_user_status_by_id($id)
{
    return R::findOne('userstatuses', 'id LIKE ?', array($id));
}

// SELECT announcement statuses
function get_announcement_statuses()
{
    return R::getAll("SELECT * FROM announcementstatuses");
}

// SELECT studentids
function find_studentid_by_num($student_number)
{
    return R::findOne('studentids', 'student_id_num LIKE ?', array($student_number));
}
function get_studentid_by_id($id)
{
    return R::findOne('studentids', 'id LIKE ?', array($id));
}



//------------------------------------------
// COUNT
//------------------------------------------

// COUNT comments
function count_comments_by_announcement_id($id)
{
    return R::count('comments', 'announcement_id = ?', array($id));
}

// COUNT announcements
function count_actual_announcements()
{
    return R::count('announcements', 'announcement_status_id = 1');
}
function count_announcements()
{
    return R::count('announcements');
}

// COUNT users
function count_users_by_login($login)
{
    return R::count("users", "login = ?", array($login));
}
function count_users_by_email($email)
{
    return R::count("users", "email = ?", array($email));
}
function count_users_by_telegram($telegram_username)
{
    return R::count("users", "telegram_username = ?", array($telegram_username));
}
function count_users_by_student_id($student_number_id)
{
    return R::count("users", "studentid_id = ?", array($student_number_id));
}

// COUNT studentid
function count_studentid_by_num($student_number)
{
    return R::count("studentids", "student_id_num = ?", array($student_number));
}

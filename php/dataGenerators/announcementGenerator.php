<?php
date_default_timezone_set('Europe/Kiev');

for ($i = 1; $i < 100; $i++){
    $announcement = R::dispense('announcements');
    $announcement->user_id = 25;
    $announcement->title = $i." title";
    $announcement->details = $i." announcement details";
    $announcement->date = time();
    $announcement->deadline = time();
    $announcement->announcement_status_id = 1;

    R::store($announcement);
}
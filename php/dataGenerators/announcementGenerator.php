<?php

for ($i = 1; $i < 11; $i++){
    $announcement = R::dispense('announcements');
    $announcement->user_id = $i;
    $announcement->title = $i." title";
    $announcement->details = $i." announcement details";
    $announcement->date = time();
    $announcement->deadline = time();
    $announcement->announcement_status_id = 1;

    R::store($announcement);
}
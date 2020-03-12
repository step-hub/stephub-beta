<?php

$user_status = R::dispense('user_statuses');

$user_status->status = 'admin';
R::store($user_status);

$user_status->status = 'moderator';
R::store($user_status);

$user_status->status = 'user';
R::store($user_status);

$user_status->status = 'banned';
R::store($user_status);


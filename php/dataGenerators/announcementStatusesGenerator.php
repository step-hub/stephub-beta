<?php

$announcement_status = R::dispense('userstatuses');

$announcement_status->status = 'actual';
R::store($announcement_status);

$announcement_status->status = 'frozen';
R::store($announcement_status);

$announcement_status->status = 'solved';
R::store($announcement_status);

$announcement_status->status = 'banned';
R::store($announcement_status);

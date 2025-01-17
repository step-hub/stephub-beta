<?php
require "php/db.php";
include_once 'php/functions.php';

if (array_key_exists('logged_user', $_SESSION) and $_SESSION['logged_user']->user_status == 1) {
    $data_get = $_GET;
    $data_post = $_POST;

    $tables = array('users', 'announcements', 'com_complaints');
    $order_values = array('ASC', 'DESC');
    $qty_values = array('20', '30', '40');
    $users_sort_by = array('id', 'login', 'user_status', 'banned_to', 'is_online');
    $ann_sort_by = array('id', 'user_id', 'announcement_status_id', 'title', 'date', 'deadline', 'complaint');
    $com_compl_sort_by = array('id', 'user_id', 'complaint', 'date', 'announcement_id');

    if (!isset($data_get['table']) or !in_array($data_get['table'], $tables))
        $data_get['table'] = 'users';
    if (!isset($data_get['users_sort_by']) or !in_array($data_get['users_sort_by'], $users_sort_by))
        $data_get['users_sort_by'] = 'id';
    if (!isset($data_get['users_sort_order']) or !in_array($data_get['users_sort_order'], $order_values))
        $data_get['users_sort_order'] = 'ASC';
    if (!isset($data_get['users_qty']) or !in_array($data_get['users_qty'], $qty_values))
        $data_get['users_qty'] = 20;
    if (!isset($data_get['ann_sort_by']) or !in_array($data_get['ann_sort_by'], $ann_sort_by))
        $data_get['ann_sort_by'] = 'date';
    if (!isset($data_get['ann_sort_order']) or !in_array($data_get['ann_sort_order'], $order_values))
        $data_get['ann_sort_order'] = 'DESC';
    if (!isset($data_get['anns_qty']) or !in_array($data_get['anns_qty'], $qty_values))
        $data_get['anns_qty'] = 20;
    if (!isset($data_get['com_compl_sort_by']) or !in_array($data_get['com_compl_sort_by'], $ann_sort_by))
        $data_get['com_compl_sort_by'] = "date";
    if (!isset($data_get['com_compl_order_by']) or !in_array($data_get['com_compl_order_by'], $order_values))
        $data_get['com_compl_order_by'] = 'DESC';
    if (!isset($data_get['com_compl_qty']) or !in_array($data_get['com_compl_qty'], $qty_values))
        $data_get['com_compl_qty'] = 20;

    $request = '';
    foreach (array_keys($data_get) as $key) {
        if ($key != 'page') {
            $request .= $key . '=' . $data_get[$key];
            if (key(array_slice($data_get, -1, 1, true)) != $key)
                $request .= '&';
        }
    }

    if ($data_get['table'] == 'users') {
        $total = intval((R::count('users') - 1) / $data_get['users_qty']) + 1;

        if (isset($data_get['page']) and $data_get['page'] > 0) {
            if ($data_get['page'] > $total) {
                $page = $total;
            } else {
                $page  = $data_get['page'];
            }
        } else {
            $page = 1;
        }

        $start = ($page - 1) * $data_get['users_qty'];
        $users = R::findAll('users', 'ORDER BY ' . $data_get['users_sort_by'] . ' ' . $data_get['users_sort_order'] . ' LIMIT ' . $start . ', ' . $data_get['users_qty']);
        $user_statuses = get_user_statuses();

        foreach ($users as $u) {
            if (isset($data_post['do_delete_user' . $u['id']])) {
                mail($u['email'], 'Deleted account', 'Your account was deleted', 'From: stephub.com@gmail.com');
                R::trash($u);
                header("location: admin.php?" . $request);
            }
        }

        if (isset($data_post['do_update_users'])) {
            foreach ($users as $u) {
                if (array_key_exists('check_user' . $u['id'], $data_post)) {
                    $id = $u['id'];
                    $sel_status = $data_post['sel_user_status' . $id];
                    $ban_date = strtotime($data_post['ban_date' . $id]);
                    if (($sel_status == '4' and $ban_date > time()) or ($sel_status != '4' and $ban_date == 0)) {
                        $u['user_status'] = $sel_status;
                        if ($ban_date == 0)
                            $u['banned_to'] = null;
                        else
                            $u['banned_to'] = $ban_date;
                        R::store($u);
                    }
                }
            }
            header("location: admin.php?" . $request);
        }
    } elseif ($data_get['table'] == 'announcements') {
        $total = intval((R::count('announcements') - 1) / $data_get['users_qty']) + 1;

        if (isset($data_get['page']) and $data_get['page'] > 0) {
            if ($data_get['page'] > $total) {
                $page = $total;
            } else {
                $page  = $data_get['page'];
            }
        } else {
            $page = 1;
        }

        $start = ($page - 1) * $data_get['anns_qty'];
        $announcements = R::findAll('announcements', 'ORDER BY ' . $data_get['ann_sort_by'] . ' ' . $data_get['ann_sort_order'] . ' LIMIT ' . $start . ', ' . $data_get['anns_qty']);
        $announcement_statuses = get_announcement_statuses();

        foreach ($announcements as $a) {
            if (isset($data_post['do_delete_ann' . $a['id']])) {
                R::trash($a);
                header("location: admin.php?" . $request);
            }

            if (isset($data_post['do_delete_ann_complaint' . $a['id']])) {
                $a['complaint'] = null;
                R::store($a);
                header("location: admin.php?" . $request);
            }
        }

        if (isset($data_post['do_update_ann'])) {
            foreach ($announcements as $a) {
                if (array_key_exists('check_ann' . $a['id'], $data_post)) {
                    $a['announcement_status_id'] = $data_post['sel_ann_status' . $a['id']];
                    R::store($a);
                    header("location: admin.php?" . $request);
                }
            }
        }
    } elseif ($data_get['table'] == 'com_complaints') {
        $total = intval((R::count('comments', 'WHERE complaint IS NOT NULL') - 1) / $data_get['com_compl_qty']) + 1;

        if (isset($data_get['page']) and $data_get['page'] > 0) {
            if ($data_get['page'] > $total) {
                $page = $total;
            } else {
                $page  = $data_get['page'];
            }
        } else {
            $page = 1;
        }

        $start = ($page - 1) * $data_get['com_compl_qty'];
        $complaints = R::findAll('comments', 'WHERE complaint IS NOT NULL ORDER BY ' . $data_get['com_compl_sort_by'] . ' ' . $data_get['com_compl_order_by'] . ' LIMIT ' . $start . ', ' . $data_get['com_compl_qty']);
        foreach ($complaints as $c) {
            if (isset($data_post['do_delete_comment' . $c['id']])) {
                R::hunt('comments', 'parent_comment_id = ?', array($c['id']));
                R::trash($c);
                header("location: admin.php?" . $request);
            }
            if (isset($data_post['do_delete_complaint' . $c['id']])) {
                $c['complaint'] = null;
                R::store($c);
                header("location: admin.php?" . $request);
            }
        }
    }
} else {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Сторінка Адміністратора | StepHub</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">

    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
</head>

<body class="my-bg-light text-center" style="padding-top: 46px">
    <!-- Preloader -->
    <?php include_once 'templates/preloader.html'; ?>

    <!-- Back to top button -->
    <a id="back-to-top-button"></a>

    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Page Content -->
    <div class="container-fluid d-none d-md-block">
        <div class="row mt-1 mb-0 mx-1 ">
            <div class="col-md-4">
                <div class="text-left">
                    <button class="btn btn-sm btn-secondary ml-0" data-toggle="collapse" data-target="#collapse-filter" aria-expanded="true" aria-controls="collapse-filter"><span class="material-icons mr-1">tune</span>Показати налаштування фільтра</button>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Pagination-->
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm justify-content-center mb-0">
                        <?php if ($page == 1) : ?>
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        <?php else : ?>
                            <li class="page-item">
                                <a class="page-link" href="admin.php?page=<?= ($page - 1) . '&' . $request ?>">&laquo;</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="admin.php?page=1&<?= $request ?>">1</a></li>
                            <?php if ($page > 4) : ?>
                                <li class="page-item disabled"><a class="page-link">...</a></li>
                                <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page - 3) . '&' . $request ?>"><?= $page - 3 ?></a></li>
                            <?php endif; ?>
                            <?php if ($page > 3) : ?>
                                <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page - 2) . '&' . $request ?>"><?= $page - 2 ?></a></li>
                            <?php endif; ?>
                            <?php if ($page > 2) : ?>
                                <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page - 1) . '&' . $request ?>"><?= $page - 1 ?></a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <li class="page-item active">
                            <span class="page-link"><?= $page ?><span class="sr-only">(current)</span></span>
                        </li>
                        <?php if ($page != $total) : ?>
                            <?php if ($page + 1 < $total) : ?>
                                <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page + 1) . '&' . $request ?>"><?= $page + 1 ?></a></li>
                            <?php endif; ?>
                            <?php if ($page + 2 < $total) : ?>
                                <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page + 2) . '&' . $request ?>"><?= $page + 2 ?></a></li>
                            <?php endif; ?>
                            <?php if ($page + 3 < $total) : ?>
                                <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page + 3) . '&' . $request ?>"><?= $page + 3 ?></a></li>
                                <?php if ($page + 3 != $total - 1) : ?>
                                    <li class="page-item disabled"><a class="page-link">...</a></li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <li class="page-item"><a class="page-link" href="admin.php?page=<?= $total . '&' . $request ?>"><?= $total ?></a></li>

                            <li class="page-item">
                                <a class="page-link" href="admin.php?page=<?= ($page + 1) . '&' . $request ?>">&raquo;</a>
                            </li>
                        <?php else : ?>
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

            <div class="col-md-4">
                <div class="text-right">
                    <?php if ($data_get['table'] == 'users') : ?>
                        <button class="btn btn-sm my-btn-outline-blue" type="submit" form="update" name="do_update_users"><span class="material-icons mr-1">refresh</span>Оновити</button>
                    <?php elseif ($data_get['table'] == 'announcements') : ?>
                        <button class="btn btn-sm my-btn-outline-blue" type="submit" form="update_ann" name="do_update_ann"><span class="material-icons mr-1">refresh</span>Оновити</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row mt-0 mb-1 mx-1">
            <div class="accordion" id="idFilter">
                <div class="" id="heading-filter"></div>
                <div id="collapse-filter" class="collapse" aria-labelledby="heading-filter" data-parent="#idFilter">
                    <!-- Filter -->
                    <form name="filter" action="admin.php" method="GET" class="form-inline">
                        <label for="select_table" class="small ml-3">Таблиця</label>
                        <select name="table" id="select_table" onchange="this.form.submit()" class="form-control form-control-sm m-1">
                            <option value="users" <?php if ($data_get['table'] == 'users') echo 'selected' ?>>користувачі</option>
                            <option value="announcements" <?php if ($data_get['table'] == 'announcements') echo 'selected' ?>>оголошення</option>
                            <option value="com_complaints" <?php if ($data_get['table'] == 'com_complaints') echo 'selected' ?>>бани коментів</option>
                        </select>
                        <label for="select_users_sort_by" class="small ml-3" <?php if ($data_get['table'] != 'users') echo 'hidden' ?>>Сортувати за</label>
                        <select name="users_sort_by" id="select_users_sort_by" <?php if ($data_get['table'] != 'users') echo 'hidden' ?> class="form-control form-control-sm m-1">
                            <option value="id" <?php if ($data_get['users_sort_by'] == 'id') echo 'selected' ?>>ID</option>
                            <option value="login" <?php if ($data_get['users_sort_by'] == 'login') echo 'selected' ?>>логін</option>
                            <option value="user_status" <?php if ($data_get['users_sort_by'] == 'user_status') echo 'selected' ?>>права</option>
                            <option value="banned_to" <?php if ($data_get['users_sort_by'] == 'banned_to') echo 'selected' ?>>забанений до</option>
                            <option value="is_online" <?php if ($data_get['users_sort_by'] == 'is_online') echo 'selected' ?>>статус</option>
                        </select>
                        <label for="select_users_sort_order" class="small ml-3" <?php if ($data_get['table'] != 'users') echo 'hidden' ?>>Порядок</label>
                        <select name="users_sort_order" id="select_users_sort_order" <?php if ($data_get['table'] != 'users') echo 'hidden' ?> class="form-control form-control-sm m-1">
                            <option value="ASC" <?php if ($data_get['users_sort_order'] == 'ASC') echo 'selected' ?>>зростанням</option>
                            <option value="DESC" <?php if ($data_get['users_sort_order'] == 'DESC') echo 'selected' ?>>спаданням</option>
                        </select>
                        <label for="select_users_qty" class="small ml-3" <?php if ($data_get['table'] != 'users') echo 'hidden' ?>>Кількість</label>
                        <select name="users_qty" id="select_users_qty" <?php if ($data_get['table'] != 'users') echo 'hidden' ?> class="form-control form-control-sm m-1">
                            <option value="20" <?php if ($data_get['users_qty'] == '20') echo 'selected' ?>>20</option>
                            <option value="30" <?php if ($data_get['users_qty'] == '30') echo 'selected' ?>>30</option>
                            <option value="40" <?php if ($data_get['users_qty'] == '40') echo 'selected' ?>>40</option>
                        </select>
                        <label for="select_ann_sort_by" class="small ml-3" <?php if ($data_get['table'] != 'announcements') echo 'hidden' ?>>Сортувати за</label>
                        <select name="ann_sort_by" id="select_ann_sort_by" <?php if ($data_get['table'] != 'announcements') echo 'hidden' ?> class="form-control form-control-sm m-1">
                            <option value="id" <?php if ($data_get['ann_sort_by'] == 'id') echo 'selected' ?>>ID</option>
                            <option value="user_id" <?php if ($data_get['ann_sort_by'] == 'user_id') echo 'selected' ?>>власник</option>
                            <option value="announcement_status_id" <?php if ($data_get['ann_sort_by'] == 'announcement_status_id') echo 'selected' ?>>статус</option>
                            <option value="title" <?php if ($data_get['ann_sort_by'] == 'title') echo 'selected' ?>>заголовок</option>
                            <option value="date" <?php if ($data_get['ann_sort_by'] == 'date') echo 'selected' ?>>дата створення</option>
                            <option value="deadline" <?php if ($data_get['ann_sort_by'] == 'deadline') echo 'selected' ?>>дедлайн</option>
                            <option value="complaint" <?php if ($data_get['ann_sort_by'] == 'complaint') echo 'selected' ?>>скарга від</option>
                        </select>
                        <label for="select_ann_sort_order" class="small ml-3" <?php if ($data_get['table'] != 'announcements') echo 'hidden' ?>>Порядок</label>
                        <select name="ann_sort_order" id="select_ann_sort_order" <?php if ($data_get['table'] != 'announcements') echo 'hidden' ?> class="form-control form-control-sm m-1">
                            <option value="ASC" <?php if ($data_get['ann_sort_order'] == 'ASC') echo 'selected' ?>>зростанням</option>
                            <option value="DESC" <?php if ($data_get['ann_sort_order'] == 'DESC') echo 'selected' ?>>спаданням</option>
                        </select>
                        <label for="select_anns_qty" class="small ml-3" <?php if ($data_get['table'] != 'announcements') echo 'hidden' ?>>Кількість</label>
                        <select name="anns_qty" id="select_anns_qty" <?php if ($data_get['table'] != 'announcements') echo 'hidden' ?> class="form-control form-control-sm m-1">
                            <option value="20" <?php if ($data_get['anns_qty'] == '20') echo 'selected' ?>>20</option>
                            <option value="30" <?php if ($data_get['anns_qty'] == '30') echo 'selected' ?>>30</option>
                            <option value="40" <?php if ($data_get['anns_qty'] == '40') echo 'selected' ?>>40</option>
                        </select>
                        <label for="select_com_compl_sort_by" class="small ml-3" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden' ?>>Сортувати за</label>
                        <select name="com_compl_sort_by" id="select_com_compl_sort_by" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden' ?> class="form-control form-control-sm m-1">
                            <option value="id" <?php if ($data_get['com_compl_sort_by'] == 'id') echo 'selected' ?>>ID</option>
                            <option value="announcement_id" <?php if ($data_get['com_compl_sort_by'] == 'announcement_id') echo 'selected' ?>>оголошення</option>
                            <option value="user_id" <?php if ($data_get['com_compl_sort_by'] == 'user_id') echo 'selected' ?>>чий комент</option>
                            <option value="complaint" <?php if ($data_get['com_compl_sort_by'] == 'complaint') echo 'selected' ?>>хто скаржився</option>
                            <option value="date" <?php if ($data_get['com_compl_sort_by'] == 'date') echo 'selected' ?>>дата коменту</option>
                        </select>
                        <label for="select_com_compl_order_by" class="small ml-3" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden' ?>>Порядок</label>
                        <select name="com_compl_order_by" id="select_com_compl_order_by" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden' ?> class="form-control form-control-sm m-1">
                            <option value="ASC" <?php if ($data_get['com_compl_order_by'] == 'ASC') echo 'selected' ?>>зростанням</option>
                            <option value="DESC" <?php if ($data_get['com_compl_order_by'] == 'DESC') echo 'selected' ?>>спаданням</option>
                        </select>
                        <label for="select_com_compl_qty" class="small ml-3" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden' ?>>Кількість</label>
                        <select name="com_compl_qty" id="select_com_compl_qty" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden' ?> class="form-control form-control-sm m-1">
                            <option value="20" <?php if ($data_get['com_compl_qty'] == '20') echo 'selected' ?>>20</option>
                            <option value="30" <?php if ($data_get['com_compl_qty'] == '30') echo 'selected' ?>>30</option>
                            <option value="40" <?php if ($data_get['com_compl_qty'] == '40') echo 'selected' ?>>40</option>
                        </select>
                        <button type="submit" name="do_filter" class="btn btn-sm my-btn-blue ml-3">Фільтрувати</button>
                    </form>
                </div>
            </div>
        </div>

        <?php if ($data_get['table'] == 'users') : ?>
            <table class="table table-sm table-striped table-bordered table-hover table-shadow">
                <thead>
                    <tr class="thead-light">
                        <th class="p-1"></th>
                        <th class="p-1">ID</th>
                        <th class="p-1">Ім'я</th>
                        <th class="p-1">Права</th>
                        <th class="p-1">Забанений до</th>
                        <th class="p-1">Статус</th>
                        <th class="p-1"></th>
                    </tr>
                </thead>
                <form id="update" action="admin.php?<?= $request ?>" method="POST">
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td>
                                    <div class="row justify-content-center"><input type="checkbox" name="check_user<?= $user['id'] ?>"></div>
                                </td>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['login'] ?></td>
                                <td>
                                    <select class="form-control form-control-sm" name="sel_user_status<?= $user['id'] ?>">
                                        <?php foreach ($user_statuses as $user_status) : ?>
                                            <option value="<?= $user_status['id'] ?>" <?php if ($user['user_status'] == $user_status['id']) echo "selected"; ?>><?= $user_status['status'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="date" name="ban_date<?= $user['id'] ?>" class="form-control form-control-sm" <?php if ($user['banned_to']) echo 'value="' . date("Y-m-d", $user['banned_to']) . '"' ?>>
                                </td>
                                <td>
                                    <div class="badge badge-<?= $user['is_online'] ? 'success' : 'danger' ?>">
                                        <?= $user['is_online'] ? 'онлайн' : 'оффлайн' ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="row justify-content-center">
                                        <a class="btn btn-sm my-btn-orange border-radius-right-0 shadow-sm" href="mail.php?id=<?= $user['id'] ?>" target="_blank">
                                            <span class="material-icons md-24">mail</span>
                                        </a>
                                        <button class="btn btn-sm my-btn-red border-radius-left-0 shadow-sm" type="submit" name="do_delete_user<?= $user['id'] ?>">
                                            <span class="material-icons md-24">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </form>
            </table>
        <?php elseif ($data_get['table'] == 'announcements') : ?>
            <div>
                <table class="table table-sm table-striped table-bordered table-hover table-shadow">
                    <thead>
                        <tr class="thead-light">
                            <th class="p-1"></th>
                            <th class="p-1">ID</th>
                            <th class="p-1">Власник</th>
                            <th class="p-1">Статус</th>
                            <th class="p-1">Заголовок</th>
                            <th class="p-1">Дата створення</th>
                            <th class="p-1">Дедлайн</th>
                            <th class="p-1">Скарга від</th>
                            <th class="p-1"></th>
                        </tr>
                    </thead>
                    <form id="update_ann" action="admin.php?<?= $request ?>" method="POST">
                        <tbody>
                            <?php foreach ($announcements as $announcement) : ?>
                                <tr>
                                    <td>
                                        <div class="row justify-content-center"><input type="checkbox" name="check_ann<?= $announcement['id'] ?>"></div>
                                    </td>
                                    <td><?= $announcement['id'] ?></td>
                                    <td><?= $announcement['user_id'] ?></td>
                                    <td>
                                        <select class="form-control form-control-sm" name="sel_ann_status<?= $announcement['id'] ?>">
                                            <?php foreach ($announcement_statuses as $announcement_status) : ?>
                                                <option value="<?= $announcement_status['id'] ?>" <?php if ($announcement['announcement_status_id'] == $announcement_status['id']) echo "selected"; ?>><?= $announcement_status['status'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><?= $announcement['title'] ?></td>
                                    <td><?= show_date($announcement['date']) ?></td>
                                    <td><?= show_date($announcement['deadline']) ?></td>
                                    <td><?= $announcement['complaint'] ?></td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a class="btn btn-sm btn-secondary border-radius-right-0 shadow-sm" target="_blank" rel="noopener noreferrer" href="announcement.php?id=<?= $announcement['id'] ?>">
                                                <span class="material-icons md-24">launch</span>
                                            </a>
                                            <a class="btn btn-sm my-btn-orange border-radius-0 shadow-sm" href="mail.php?id=<?= $announcement['user_id'] ?>" target="_blank">
                                                <span class="material-icons md-24">mail</span>
                                            </a>
                                            <button class="btn btn-sm btn-success border-radius-0 shadow-sm" <?php if (!$announcement['complaint']) echo 'disabled' ?> type="submit" name="do_delete_ann_complaint<?= $announcement['id'] ?>">
                                                <span class="material-icons md-24">verified_user</span>
                                            </button>
                                            <button class="btn btn-sm my-btn-red border-radius-left-0 shadow-sm" type="submit" name="do_delete_ann<?= $announcement['id'] ?>">
                                                <span class="material-icons md-24">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </form>
                </table>
            </div>
        <?php elseif ($data_get['table'] == 'com_complaints') : ?>
            <div>
                <table class="table table-sm table-striped table-bordered table-hover table-shadow">
                    <thead>
                        <tr class="thead-light">
                            <th class="p-1"></th>
                            <th class="p-1">ID</th>
                            <th class="p-1">Оголошення</th>
                            <th class="p-1">Чий комент</th>
                            <th class="p-1">Повідомлення</th>
                            <th class="p-1">Скарга від</th>
                            <th class="p-1">Дата коменту</th>
                            <th class="p-1"></th>
                        </tr>
                    </thead>
                    <form id="update" action="admin.php?<?= $request ?>" method="POST">
                        <tbody>
                            <?php foreach ($complaints as $complaint) : ?>
                                <tr>
                                    <td>
                                        <div class="row justify-content-center"><input type="checkbox" name="check_complaint<?= $complaint['id'] ?>"></div>
                                    </td>
                                    <td><?= $complaint['id'] ?></td>
                                    <td><a href="announcement.php?id=<?= $complaint['announcement_id'] ?>"><?= $complaint['announcement_id'] ?></a></td>
                                    <td><?= $complaint['user_id'] ?></td>
                                    <td><?= substr($complaint['message'], 0, 30) ?></td>
                                    <td><?= $complaint['complaint'] ?></td>
                                    <td><?= show_detailed_date($complaint['date']) ?></td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a class="btn btn-sm btn-secondary border-radius-right-0 shadow-sm" target="_blank" rel="noopener noreferrer" href="announcement.php?id=<?= $complaint['announcement_id'] ?>#comment<?= $complaint['id'] ?>">
                                                <span class="material-icons md-24">launch</span>
                                            </a>
                                            <a class="btn btn-sm my-btn-orange border-radius-0 shadow-sm" href="mail.php?id=<?= $complaint['user_id'] ?>" target="_blank">
                                                <span class="material-icons md-24 light">mail</span>
                                            </a>
                                            <button class="btn btn-sm btn-success border-radius-0 shadow-sm" type="submit" name="do_delete_complaint<?= $complaint['id'] ?>">
                                                <span class="material-icons md-24">verified_user</span>
                                            </button>
                                            <button class="btn btn-sm my-btn-red border-radius-left-0 shadow-sm" type="submit" name="do_delete_comment<?= $complaint['id'] ?>">
                                                <span class="material-icons md-24">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </form>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Mobile Does not Suppported -->
    <div class="container-fluid d-md-none p-3">
        <div class="alert alert-danger shadow-sm" role="alert">
            <p>Сторінка Адміністратора не доступна в мобільній версії сайту.</p>
            <a href="index.php"> Повернутись на головну сторінку</a>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Main sctipt -->
    <script src="js/script.js"></script>
    <!-- Back to top button -->
    <script src="js/top.js"></script>
</body>

</html>
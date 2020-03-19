<?php
require "php/db.php";
include_once 'php/functions.php';

if ($_SESSION and $_SESSION['logged_user']->user_status == 1) {
    $data_post = $_POST;
    $data_get = $_GET;

    if ($_SESSION['logged_user']->user_status == 1) {
        if (!$data_get) {
            $_SESSION['users_qty'] = 20;
            $_SESSION['user_sort_by'] = 'id';
            $_SESSION['user_sort_order'] = 'asc';
            $_SESSION['ann_qty'] = 20;
            $_SESSION['ann_sort_by'] = 'id';
            $_SESSION['ann_sort_order'] = 'asc';
        } else {
            if (array_key_exists('users',$data_get)) {
                $_SESSION['users_qty'] = $data_get['users_qty'];
                if (count($data_get) > 2) {
                    $_SESSION['user_sort_by'] = array_key_last($data_get);
                    $_SESSION['user_sort_order'] = end($data_get);
                }
            } else {
                $_SESSION['ann_qty'] = $data_get['ann_qty'];
                if (count($data_get) > 2) {
                    $_SESSION['ann_sort_by'] = array_key_last($data_get);
                    $_SESSION['ann_sort_order'] = end($data_get);
                }
            }
        }

        $users = R::findAll('users', 'ORDER BY ' . $_SESSION['user_sort_by'] . ' ' . $_SESSION['user_sort_order'] . ' LIMIT ' . $_SESSION['users_qty']);
        $announcements = R::findAll('announcements', 'ORDER BY ' . $_SESSION['ann_sort_by'] . ' ' . $_SESSION['ann_sort_order'] . ' LIMIT ' . $_SESSION['ann_qty']);
        $user_statuses = R::getAll("SELECT * FROM userstatuses ORDER BY id ASC");
        $announcement_statuses = R::getAll("SELECT * FROM announcementstatuses");
    }

    foreach ($users as $u) {
        if (isset($data_post['do_delete_user' . $u->id])) {
            R::trash($u);
            header("location: admin.php");
        }
    }

    foreach ($announcements as $a) {
        if (isset($data_post['do_delete_ann' . $a->id])) {
            R::trash($a);
            header("location: admin.php");
        }
    }

    if (isset($data_post['do_update_users'])) {
        foreach ($users as $u) {
            if (array_key_exists('check_user' . $u['id'], $data_post)) {
                $id = $u['id'];
                $sel_status = $data_post['sel_user_status' . $id];
                $ban_date = strtotime($data_post['ban_date' . $id]);
                if (($sel_status == '4' and $ban_date > time()) or ($sel_status != '4' and $ban_date == null)) {
                    $u['user_status'] = $sel_status;
                    $u['banned_to'] = $ban_date;
                    R::store($u);
                }
            }
        }
    }

    if (isset($data_post['do_update_ann'])) {
        foreach ($announcements as $a) {
            if (array_key_exists('check_ann' . $a['id'], $data_post)) {
                $a['announcement_status_id'] = $data_post['sel_ann_status' . $a['id']];
                R::store($a);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>StepHub | Сторінка Адміністратора</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
</head>

<body class="text-center">
<!-- Navigation -->
<?php include_once 'templates/navbar.php'; ?>

<!-- Page Content -->
<div class="container-fluid">
    <?php if (array_key_exists('logged_user', $_SESSION) and $_SESSION['logged_user']->user_status == 1): ?>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#users_table" role="tab" aria-controls="users"
                   aria-selected="true">Користувачі</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#announcements_table" role="tab"
                   aria-controls="announcements" aria-selected="false">Оголошення</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="users_table" role="tabpanel" aria-labelledby="home-tab">
                <div class="table-responsive-xl">
                    <table class="table table-sm table-striped table-bordered table-hover">
                        <form action="admin.php" method="GET">
                            <thead>
                                <input type="hidden" name="users" value="true">
                                <tr class="thead-light">
                                    <th class="p-1">
                                        <select name="users_qty" class="form-control-sm btn btn-info h-100 w-100" onchange="this.form.submit()">
                                            <option value="20" <?php if ($_SESSION['users_qty'] == 20) echo 'selected'?>>20</option>
                                            <option value="30" <?php if ($_SESSION['users_qty'] == 30) echo 'selected'?>>30</option>
                                            <option value="40" <?php if ($_SESSION['users_qty'] == 40) echo 'selected'?>>40</option>
                                        </select>
                                    </th>
                                    <th class="p-1">
                                        <button name="id" value="<?= $_SESSION['user_sort_by'] != 'id' ? 'asc' : ($_SESSION['user_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" type="submit" class="btn btn-info h-100 w-100">ID
                                            <?= $_SESSION['user_sort_by'] != 'id' ? '<i class="fas fa-sort"></i>' : ($_SESSION['user_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1">
                                        <button name="login" value="<?= $_SESSION['user_sort_by'] != 'login' ? 'asc' : ($_SESSION['user_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" type="submit" class="btn btn-info h-100 w-100">Ім'я
                                            <?= $_SESSION['user_sort_by'] != 'login' ? '<i class="fas fa-sort"></i>' : ($_SESSION['user_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1">
                                        <button name="user_status" value="<?= $_SESSION['user_sort_by'] != 'user_status' ? 'asc' : ($_SESSION['user_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" class="btn btn-info h-100 w-100">Права
                                            <?= $_SESSION['user_sort_by'] != 'user_status' ? '<i class="fas fa-sort"></i>' : ($_SESSION['user_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1">
                                        <button name="banned_to" value="<?= $_SESSION['user_sort_by'] != 'banned_to' ? 'asc' : ($_SESSION['user_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" class="btn btn-info h-100 w-100">Забанений до
                                            <?= $_SESSION['user_sort_by'] != 'banned_to' ? '<i class="fas fa-sort"></i>' : ($_SESSION['user_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1">
                                        <button name="is_online" value="<?= $_SESSION['user_sort_by'] != 'is_online' ? 'asc' : ($_SESSION['user_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" class="btn btn-info h-100 w-100">Статус
                                            <?= $_SESSION['user_sort_by'] != 'is_online' ? '<i class="fas fa-sort"></i>' : ($_SESSION['user_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1"></th>
                                </tr>
                            </thead>
                        </form>
                        <form id="update" action="admin.php" method="POST">
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><div class="row justify-content-center"><input type="checkbox" name="check_user<?= $user['id'] ?>"></div></td>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= $user['login'] ?></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                    name="sel_user_status<?= $user['id'] ?>">
                                                <?php foreach ($user_statuses as $user_status): ?>
                                                    <option value="<?= $user_status['id'] ?>" <?php if ($user['user_status'] == $user_status['id']) echo "selected"; ?>><?= $user_status['status'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date" name="ban_date<?= $user['id'] ?>"
                                                   class="form-control form-control-sm" <?php if ($user['banned_to']) echo 'value="' . date("Y-m-d", $user['banned_to']) . '"' ?>>
                                        </td>
                                        <td>
                                            <div class="badge badge-<?= $user['is_online'] ? 'success' : 'danger' ?>">
                                                <?= $user['is_online'] ? 'онлайн' : 'оффлайн' ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row justify-content-center">
                                                <button class=" btn btn-sm btn-warning mr-2">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" type="submit" name="do_delete_user<?= $user['id'] ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </form>
                    </table>
                    <div class="container">
                        <button class="btn btn-info mb-4" type="submit" form="update" name="do_update_users"><i
                                class="fas fa-sync mr-2"></i>Оновити
                        </button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="announcements_table" role="tabpanel" aria-labelledby="profile-tab">
                <div class="table-responsive-xl">
                    <table class="table table-sm table-striped table-bordered">
                        <form action="admin.php" method="GET">
                            <thead>
                                <input type="hidden" name="announcements" value="true">
                                <tr class="thead-light">
                                    <th class="p-1">
                                        <select name="ann_qty" class="form-control-sm btn btn-info h-100 w-100" onchange="this.form.submit()">
                                            <option value="20" <?php if ($_SESSION['ann_qty'] == 20) echo 'selected'?>>20</option>
                                            <option value="30" <?php if ($_SESSION['ann_qty'] == 30) echo 'selected'?>>30</option>
                                            <option value="40" <?php if ($_SESSION['ann_qty'] == 40) echo 'selected'?>>40</option>
                                        </select>
                                    </th>
                                    <th class="p-1">
                                        <button name="id" value="<?= $_SESSION['ann_sort_by'] != 'id' ? 'asc' : ($_SESSION['ann_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" type="submit" class="btn btn-info h-100 w-100">ID
                                            <?= $_SESSION['ann_sort_by'] != 'id' ? '<i class="fas fa-sort"></i>' : ($_SESSION['ann_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1">
                                        <button name="user_id" value="<?= $_SESSION['ann_sort_by'] != 'user_id' ? 'asc' : ($_SESSION['ann_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" type="submit" class="btn btn-info h-100 w-100">Власник
                                            <?= $_SESSION['ann_sort_by'] != 'user_id' ? '<i class="fas fa-sort"></i>' : ($_SESSION['ann_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1">
                                        <button name="announcement_status_id" value="<?= $_SESSION['ann_sort_by'] != 'announcement_status_id' ? 'asc' : ($_SESSION['ann_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" type="submit" class="btn btn-info h-100 w-100">Статус
                                            <?= $_SESSION['ann_sort_by'] != 'announcement_status_id' ? '<i class="fas fa-sort"></i>' : ($_SESSION['ann_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1">
                                        <button name="title" value="<?= $_SESSION['ann_sort_by'] != 'title' ? 'asc' : ($_SESSION['ann_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" type="submit" class="btn btn-info h-100 w-100">Заголовок
                                            <?= $_SESSION['ann_sort_by'] != 'title' ? '<i class="fas fa-sort"></i>' : ($_SESSION['ann_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1">
                                        <button name="date" value="<?= $_SESSION['ann_sort_by'] != 'date' ? 'asc' : ($_SESSION['ann_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" type="submit" class="btn btn-info h-100 w-100">Дата створення
                                            <?= $_SESSION['ann_sort_by'] != 'date' ? '<i class="fas fa-sort"></i>' : ($_SESSION['ann_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1">
                                        <button name="deadline" value="<?= $_SESSION['ann_sort_by'] != 'deadline' ? 'asc' : ($_SESSION['ann_sort_order'] == 'asc' ? 'desc' : 'asc') ?>" type="submit" class="btn btn-info h-100 w-100">Дедлайн
                                            <?= $_SESSION['ann_sort_by'] != 'deadline' ? '<i class="fas fa-sort"></i>' : ($_SESSION['ann_sort_order'] == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>')?>
                                        </button>
                                    </th>
                                    <th class="p-1"></th>
                                </tr>
                            </thead>
                        </form>
                        <form id="update_ann" action="admin.php" method="POST">
                            <tbody>
                                <?php foreach ($announcements as $announcement): ?>
                                    <tr>
                                        <td><div class="row justify-content-center"><input type="checkbox" name="check_ann<?= $announcement['id'] ?>"></div></td>
                                        <td><?= $announcement['id'] ?></td>
                                        <td><?= $announcement['user_id'] ?></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                    name="sel_ann_status<?= $announcement['id'] ?>">
                                                <?php foreach ($announcement_statuses as $announcement_status): ?>
                                                    <option value="<?= $announcement_status['id'] ?>" <?php if ($announcement['announcement_status_id'] == $announcement_status['id']) echo "selected"; ?>><?= $announcement_status['status'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td><?= $announcement['title'] ?></td>
                                        <td><?= show_date($announcement['date']) ?></td>
                                        <td><?= show_date($announcement['deadline']) ?></td>
                                        <td>
                                            <div class="row justify-content-center">
                                                <a target="_blank" rel="noopener noreferrer"
                                                   href="announcement.php?id=<?= $announcement['id'] ?>"
                                                   class="btn btn-sm btn-primary mr-2"><i class="fas fa-eye"></i></a>
                                                <button class="btn btn-sm btn-warning mr-2"><i class="fas fa-envelope"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" type="submit" name="do_delete_ann<?= $announcement['id'] ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </form>
                    </table>
                    <div class="container">
                        <button class="btn btn-info mb-4" form="update_ann" name="do_update_ann" type="submit"><i
                                    class="fas fa-sync mr-2"></i>Оновити
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php else:
        header("location: index.php");
    endif; ?>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

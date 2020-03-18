<?php
require "php/db.php";
include_once 'php/functions.php';

if ($_SESSION and $_SESSION['logged_user']->user_status == 1) {
    $data = $_POST;
    if ($_SESSION['logged_user']->user_status == 1) {
        $users = R::findAll('users');
        $announcements = R::findAll('announcements');
        $user_statuses = R::getAll("SELECT * FROM userstatuses ORDER BY id ASC");
        $announcement_statuses = R::getAll("SELECT * FROM announcementstatuses");
    }

    foreach ($users as $u) {
        if (isset($data['do_delete_user' . $u->id])) {
            R::trash($u);
            header("location: admin.php");
        }
    }

    foreach ($announcements as $a) {
        if (isset($data['do_delete_ann' . $a->id])) {
            R::trash($a);
            header("location: admin.php");
        }
    }

    if (isset($data['do_update_users'])) {
        foreach ($users as $u) {
            if (array_key_exists('check_user' . $u['id'], $data)) {
                $id = $u['id'];
                $sel_status = $data['sel_user_status' . $id];
                $ban_date = strtotime($data['ban_date' . $id]);
                if (($sel_status == '4' and $ban_date > time()) or ($sel_status != '4' and $ban_date == null)) {
                    $u['user_status'] = $sel_status;
                    $u['banned_to'] = $ban_date;
                    R::store($u);
                }
            }
        }
    }

    if (isset($data['do_update_ann'])) {
        foreach ($announcements as $a) {
            if (array_key_exists('check_ann' . $a['id'], $data)) {
                $a['announcement_status_id'] = $data['sel_ann_status' . $a['id']];
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
    <?php if ($_SESSION and $_SESSION['logged_user']->user_status == 1): ?>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="users"
                   aria-selected="true">Користувачі</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                   aria-controls="announcements" aria-selected="false">Оголошення</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="table-responsive-xl">
                    <form action="admin.php" method="POST">
                        <table class="table table-sm table-striped table-bordered table-hover">
                            <thead>
                            <tr class="thead-light">
                                <th class="p-1"></th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">ID <i class="fas fa-sort"></i><i
                                                class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">Ім'я <i class="fas fa-sort"></i><i
                                                class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">Права <i class="fas fa-sort"></i><i
                                                class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">Забанений до <i class="fas fa-sort"></i><i
                                                class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">Статус <i class="fas fa-sort"></i><i
                                                class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><input type="checkbox" name="check_user<?= $user['id'] ?>"></td>
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

                                        <button class=" btn btn-sm btn-warning mr-2">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" type="submit"
                                                name="do_delete_user<?= $user['id'] ?>"><i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="container">
                            <button class="btn btn-info mb-4" type="submit" name="do_update_users"><i
                                        class="fas fa-sync mr-2"></i>Оновити
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <form action="admin.php" method="POST">
                    <div class="table-responsive-xl">
                        <table class="table table-sm table-striped table-bordered">
                            <thead>
                            <tr class="thead-light">
                                <th class="p-1"></th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">ID <i class="fas fa-sort"></i><i
                                            class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">Власник <i class="fas fa-sort"></i><i
                                            class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">Статус <i class="fas fa-sort"></i><i
                                            class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">Заголовок <i class="fas fa-sort"></i><i
                                            class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">Дата створення <i class="fas fa-sort"></i><i
                                            class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1">
                                    <button class="btn btn-info h-100 w-100">Дедлайн <i class="fas fa-sort"></i><i
                                            class="fas fa-sort-up"></i><i class="fas fa-sort-down"></i></button>
                                </th>
                                <th class="p-1"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($announcements as $announcement): ?>
                                <tr>
                                    <td><input type="checkbox" name="check_ann<?= $announcement['id'] ?>"></td>
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
                                            <button class="btn btn-sm btn-danger" type="submit"
                                                    name="do_delete_ann<?= $announcement['id'] ?>"><i
                                                        class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="container">
                            <button class="btn btn-info mb-4" name="do_update_ann" type="submit"><i
                                        class="fas fa-sync mr-2"></i>Оновити
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="card border-danger">
            <div class="card-body shadow-sm">
                <h5 class="card-title mb-0 text-center text-danger card-danger"><i
                            class="fas fa-exclamation-circle mr-3"></i>Ви не маєте доступу до цієї сторінки</h5>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
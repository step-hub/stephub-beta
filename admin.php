<?php
require "php/db.php";
include_once 'php/functions.php';

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
        if (array_key_exists('check' . $u['id'], $data)) {
            $id = $u['id'];
            $sel_status = $data['sel_status' . $id];
            $ban_date = strtotime($data['ban_date' . $id]);
            if (($sel_status == '4' and $ban_date > time()) or ($sel_status != '4' and $ban_date == null)) {
                $u['user_status'] = $sel_status;
                $u['banned_to'] = $ban_date;
                R::store($u);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>StepHub | Admin Panel</title>

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
    <?php if ($_SESSION['logged_user']->user_status == 1): ?>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="users"
                   aria-selected="true">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                   aria-controls="announcements" aria-selected="false">Announcements</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="table-responsive-xl">
                    <form action="admin.php" method="POST">
                        <table class="table table-sm table-striped table-bordered">
                            <tr class="thead-light">
                                <th></th>
                                <th>ID</th>
                                <th>login</th>
                                <th>status</th>
                                <th>banned to</th>
                                <th>is online</th>
                                <th></th>
                            </tr>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><input type="checkbox" name="check<?= $user['id'] ?>"></td>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['login'] ?></td>
                                    <td>
                                        <select class="form-control form-control-sm"
                                                name="sel_status<?php echo $user['id'] ?>">
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
                                        <div class="badge badge-<?php if ($user['is_online']) {
                                            echo "success\">online";
                                        } else {
                                            echo "danger\">offline";
                                        } ?></div>
                                    </td>
                                    <td>
                                        <div class=" row
                                        ">
                                        <button class="btn btn-sm btn-warning mr-2"><i class="fas fa-envelope mr-1"></i>message
                                        </button>
                                        <form action="admin.php" method="POST">
                                            <button class="btn btn-sm btn-danger" type="submit"
                                                    name="do_delete_user<?= $user['id'] ?>"><i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <div class="container">
                            <button class="btn btn-info mb-4" type="submit" name="do_update_users"><i
                                        class="fas fa-sync mr-2"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <form action="admin.php" method="POST">
                    <div class="table-responsive-xl">
                        <table class="table table-sm table-striped table-bordered">
                            <tr class="thead-light">
                                <th>ID</th>
                                <th>user id</th>
                                <th>status</th>
                                <th>title</th>
                                <th>date</th>
                                <th>deadline</th>
                                <th>link</th>
                                <th></th>
                            </tr>
                            <?php foreach ($announcements as $announcement):?>
                                <tr>
                                    <td><?= $announcement['id']?></td>
                                    <td><?= $announcement['user_id']?></td>
                                    <td>
                                        <select class="form-control form-control-sm"
                                                name="sel_an_status<?= $announcement['id'] ?>">
                                            <?php foreach ($announcement_statuses as $announcement_status): ?>
                                                <option value="<?= $announcement_status['id'] ?>" <?php if ($announcement['announcement_status_id'] == $announcement_status['id']) echo "selected"; ?>><?= $announcement_status['status'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><?= $announcement['title']?></td>
                                    <td><?= date("Y-m-d", $announcement['date'])?></td>
                                    <td><?= date("Y-m-d", $announcement['deadline'])?></td>
                                    <td><a href="#">link</a></td>
                                    <td>
                                        <div class="row">
                                            <button class="btn btn-sm btn-warning"><i class="fas fa-envelope mr-1"></i></button>
                                            <button class="btn btn-sm btn-danger" type="submit" name="do_delete_ann<?=$announcement['id'] ?>"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </table>
                        <div class="container">
                            <button class="btn btn-info mb-4"><i class="fas fa-sync mr-2"></i>Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="card border-danger">
            <div class="card-body shadow-sm">
                <h5 class="card-title mb-0 text-center text-danger card-danger"><i
                            class="fas fa-exclamation-circle mr-3"></i>You don't have permissions</h5>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
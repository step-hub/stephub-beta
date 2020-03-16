<?php
require "php/db.php";
include_once 'php/functions.php';

$data = $_POST;
if ($_SESSION['logged_user']->user_status == 1) {
    $users = R::getAll("SELECT * FROM users");
    $announcements = R::getAll("SELECT * FROM announcements");
    $user_statuses = R::getAll("SELECT * FROM userstatuses ORDER BY id ASC");
    $announcement_statuses = R::getAll("SELECT * FROM announcementstatuses");
}

foreach ($users as $u){
    if (isset($data['do_delete'.$u['id']])){
        R::trash('studentids', $u['studentid_id']);
        header("location: admin.php");
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
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="users" aria-selected="true">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="announcements" aria-selected="false">Announcements</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="table-responsive-xl">
                        <table class="table table-sm table-striped table-bordered">
                            <tr class="thead-light">
                                <th>ID</th>
                                <th>login</th>
                                <th>status</th>
                                <th>banned to</th>
                                <th>is online</th>
                                <th></th>
                            </tr>
                            <?php foreach ($users as $user):?>
                            <tr>
                                <td><?php echo $user['id']?></td>
                                <td><?php echo $user['login']?></td>
                                <td>
                                        <select class="form-control form-control-sm" id="sel1">
                                            <?php foreach ($user_statuses as $user_status):?>
                                                <option value="<?php echo $user_status['id']?>" <?php if ($user['user_status'] == $user_status['id']) echo "selected";?>><?php echo $user_status['id']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </td>
                                <td>
                                    <input type="date" class="form-control form-control-sm" <?php if ($user['banned_to']) echo 'value="'.date("Y-m-d", $user['banned_to']).'"'?>>
                                </td>
                                <td><?php echo $user['is_online']?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning">send message</button>
                                    <form action="admin.php" method="post">
                                        <button class="btn btn-sm btn-danger" type="submit" name="do_delete<?php echo $user['id']?>">delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                        <div class="container">
                            <button class="btn btn-info">Update</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                            <tr>
                                <td>1</td>
                                <td>10</td>
                                <td>
                                    <select class="form-control form-control-sm" id="sel1">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                </td>
                                <td>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet illum libero possimus voluptatibus! Cupiditate eum fugit minus mo
                                </td>
                                <td>date</td>
                                <td>deadline</td>
                                <td><a href="#">link</a></td>
                                <td>
                                    <button class="btn btn-sm btn-warning">send message</button>
                                    <button class="btn btn-sm btn-danger">delete</button>
                                </td>
                            </tr>
                        </table>
                        <div class="container">
                            <button class="btn btn-info">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card border-danger">
                <div class="card-body shadow-sm">
                    <h5 class="card-title mb-0 text-center text-danger card-danger"><i class="fas fa-exclamation-circle mr-3"></i>You don't have permissions</h5>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
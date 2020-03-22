<?php
require "php/db.php";
include_once 'php/functions.php';

if (array_key_exists('logged_user', $_SESSION) and $_SESSION['logged_user']->user_status == 1) {
    $data_get = $_GET;
    $data_post = $_POST;

    if (!$data_get){
        $data_get['table'] = 'users';
        $data_get['users_sort_by'] = 'id';
        $data_get['users_sort_order'] = 'ASC';
        $data_get['users_qty'] = 20;
        $data_get['ann_sort_by'] = 'id';
        $data_get['ann_sort_order'] = 'ASC';
        $data_get['anns_qty'] = 20;
        $data_get['com_compl_sort_by'] = "id";
        $data_get['com_compl_order_by'] = "ASC";
        $data_get['com_compl_qty'] = 20;
    }

    $request = '';
    foreach (array_keys($data_get) as $key){
        if ($key != 'page') {
            $request .= $key . '=' . $data_get[$key];
            if (array_key_last($data_get) != $key)
                $request .= '&';
        }
    }

    if ($data_get['table'] == 'users') {
        $total = intval((R::count('users') - 1) / $data_get['users_qty']) + 1;

        if (isset($data_get['page']) and $data_get['page'] > 0) {
            if($data_get['page'] > $total) {
                $page = $total;
            } else {
                $page  = $data_get['page'];
            }
        } else {
            $page = 1;
        }

        $start = ($page-1) * $data_get['users_qty'];
        $users = R::findAll('users', 'ORDER BY ' . $data_get['users_sort_by'] . ' ' . $data_get['users_sort_order'] . ' LIMIT ' . $start . ', ' . $data_get['users_qty']);
        $user_statuses = get_user_statuses();

        foreach ($users as $u) {
            if (isset($data_post['do_delete_user' . $u['id']])) {
                R::trash($u);
                header("location: admin.php?".$request);
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
            header("location: admin.php?".$request);
        }
    }
    elseif ($data_get['table'] == 'announcements') {
        $total = intval((R::count('announcements') - 1) / $data_get['users_qty']) + 1;

        if (isset($data_get['page']) and $data_get['page'] > 0) {
            if($data_get['page'] > $total) {
                $page = $total;
            } else {
                $page  = $data_get['page'];
            }
        } else {
            $page = 1;
        }

        $start = ($page-1) * $data_get['anns_qty'];
        $announcements = R::findAll('announcements', 'ORDER BY ' . $data_get['ann_sort_by'] . ' ' . $data_get['ann_sort_order'] . ' LIMIT ' . $start . ', ' . $data_get['anns_qty']);
        $announcement_statuses = get_announcement_statuses();

        foreach ($announcements as $a) {
            if (isset($data_post['do_delete_ann' . $a['id']])) {
                R::trash($a);
                header("location: admin.php?" . $request);
            }

            if (isset($data_post['do_delete_ann_complaint' . $a['id']])){
                $a['complaint'] = null;
                R::store($a);
                header("location: admin.php?".$request);
            }
        }

        if (isset($data_post['do_update_ann'])) {
            foreach ($announcements as $a) {
                if (array_key_exists('check_ann' . $a['id'], $data_post)) {
                    $a['announcement_status_id'] = $data_post['sel_ann_status' . $a['id']];
                    R::store($a);
                    header("location: admin.php?".$request);
                }
            }
        }
    }
    elseif ($data_get['table'] == 'com_complaints'){
        $total = intval((R::count('comments', 'WHERE complaint IS NOT NULL') - 1) / $data_get['com_compl_qty']) + 1;

        if (isset($data_get['page']) and $data_get['page'] > 0) {
            if($data_get['page'] > $total) {
                $page = $total;
            } else {
                $page  = $data_get['page'];
            }
        } else {
            $page = 1;
        }

        $start = ($page-1) * $data_get['com_compl_qty'];
        $complaints = R::findAll('comments', 'WHERE complaint IS NOT NULL ORDER BY ' . $data_get['com_compl_sort_by'] . ' ' . $data_get['com_compl_order_by'] . ' LIMIT ' . $start . ', ' . $data_get['com_compl_qty']);
        foreach ($complaints as $c){
            if (isset($data_post['do_delete_comment'.$c['id']])){
                R::hunt('comments', 'parent_comment_id = ?', array($c['id']));
                R::trash($c);
                header("location: admin.php?".$request);
            }
            if (isset($data_post['do_delete_complaint'.$c['id']])){
                $c['complaint'] = null;
                R::store($c);
                header("location: admin.php?".$request);
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
        <div class="row mt-1 mb-1 justify-content-center">
            <form name="filter" action="admin.php" method="GET" class="form-inline">
                <label for="select_table">таблиця</label>
                <select name="table" id="select_table" onchange="this.form.submit()" class="form-control form-control-sm m-1">
                    <option value="users" <?php if ($data_get['table'] == 'users') echo 'selected'?>>користувачі</option>
                    <option value="announcements" <?php if ($data_get['table'] == 'announcements') echo 'selected'?>>оголошення</option>
                    <option value="com_complaints" <?php if ($data_get['table'] == 'com_complaints') echo 'selected'?>>бани коментів</option>
                </select>
                <label for="select_users_sort_by" <?php if ($data_get['table'] != 'users') echo 'hidden'?>>сортувати за</label>
                <select name="users_sort_by" id="select_users_sort_by" <?php if ($data_get['table'] != 'users') echo 'hidden'?> class="form-control form-control-sm m-1">
                    <option value="id" <?php if ($data_get['users_sort_by'] == 'id') echo 'selected'?>>ID</option>
                    <option value="login" <?php if ($data_get['users_sort_by'] == 'login') echo 'selected'?>>логін</option>
                    <option value="user_status" <?php if ($data_get['users_sort_by'] == 'user_status') echo 'selected'?>>права</option>
                    <option value="banned_to" <?php if ($data_get['users_sort_by'] == 'banned_to') echo 'selected'?>>забанений до</option>
                    <option value="is_online" <?php if ($data_get['users_sort_by'] == 'is_online') echo 'selected'?>>статус</option>
                </select>
                <label for="select_users_sort_order" <?php if ($data_get['table'] != 'users') echo 'hidden'?>>порядок</label>
                <select name="users_sort_order" id="select_users_sort_order" <?php if ($data_get['table'] != 'users') echo 'hidden'?> class="form-control form-control-sm m-1">
                    <option value="ASC" <?php if ($data_get['users_sort_order'] == 'ASC') echo 'selected'?>>зростанням</option>
                    <option value="DESC" <?php if ($data_get['users_sort_order'] == 'DESC') echo 'selected'?>>спаданням</option>
                </select>
                <label for="select_users_qty" <?php if ($data_get['table'] != 'users') echo 'hidden'?>>кількість</label>
                <select name="users_qty" id="select_users_qty" <?php if ($data_get['table'] != 'users') echo 'hidden'?> class="form-control form-control-sm m-1">
                    <option value="20" <?php if ($data_get['users_qty'] == '20') echo 'selected'?>>20</option>
                    <option value="30" <?php if ($data_get['users_qty'] == '30') echo 'selected'?>>30</option>
                    <option value="40" <?php if ($data_get['users_qty'] == '40') echo 'selected'?>>40</option>
                </select>
                <label for="select_ann_sort_by" <?php if ($data_get['table'] != 'announcements') echo 'hidden'?>>сортувати за</label>
                <select name="ann_sort_by" id="select_ann_sort_by" <?php if ($data_get['table'] != 'announcements') echo 'hidden'?> class="form-control form-control-sm m-1">
                    <option value="id" <?php if ($data_get['ann_sort_by'] == 'id') echo 'selected'?>>ID</option>
                    <option value="user_id" <?php if ($data_get['ann_sort_by'] == 'user_id') echo 'selected'?>>власник</option>
                    <option value="announcement_status_id" <?php if ($data_get['ann_sort_by'] == 'announcement_status_id') echo 'selected'?>>статус</option>
                    <option value="title" <?php if ($data_get['ann_sort_by'] == 'title') echo 'selected'?>>заголовок</option>
                    <option value="date" <?php if ($data_get['ann_sort_by'] == 'date') echo 'selected'?>>дата створення</option>
                    <option value="deadline" <?php if ($data_get['ann_sort_by'] == 'deadline') echo 'selected'?>>дедлайн</option>
                    <option value="complaint" <?php if ($data_get['ann_sort_by'] == 'complaint') echo 'selected'?>>скарга від</option>
                </select>
                <label for="select_ann_sort_order" <?php if ($data_get['table'] != 'announcements') echo 'hidden'?>>порядок</label>
                <select name="ann_sort_order" id="select_ann_sort_order" <?php if ($data_get['table'] != 'announcements') echo 'hidden'?> class="form-control form-control-sm m-1">
                    <option value="ASC" <?php if ($data_get['ann_sort_order'] == 'ASC') echo 'selected'?>>зростанням</option>
                    <option value="DESC" <?php if ($data_get['ann_sort_order'] == 'DESC') echo 'selected'?>>спаданням</option>
                </select>
                <label for="select_anns_qty" <?php if ($data_get['table'] != 'announcements') echo 'hidden'?>>кількість</label>
                <select name="anns_qty" id="select_anns_qty" <?php if ($data_get['table'] != 'announcements') echo 'hidden'?> class="form-control form-control-sm m-1">
                    <option value="20" <?php if ($data_get['anns_qty'] == '20') echo 'selected'?>>20</option>
                    <option value="30" <?php if ($data_get['anns_qty'] == '30') echo 'selected'?>>30</option>
                    <option value="40" <?php if ($data_get['anns_qty'] == '40') echo 'selected'?>>40</option>
                </select>
                <label for="select_com_compl_sort_by" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden'?>>сортувати за</label>
                <select name="com_compl_sort_by" id="select_com_compl_sort_by" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden'?> class="form-control form-control-sm m-1">
                    <option value="id" <?php if ($data_get['com_compl_sort_by'] == 'id') echo 'selected'?>>ID</option>
                    <option value="announcement_id" <?php if ($data_get['com_compl_sort_by'] == 'announcement_id') echo 'selected'?>>оголошення</option>
                    <option value="user_id" <?php if ($data_get['com_compl_sort_by'] == 'user_id') echo 'selected'?>>чий комент</option>
                    <option value="complaint" <?php if ($data_get['com_compl_sort_by'] == 'complaint') echo 'selected'?>>хто скаржився</option>
                    <option value="date" <?php if ($data_get['com_compl_sort_by'] == 'date') echo 'selected'?>>дата коменту</option>
                </select>
                <label for="select_com_compl_order_by" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden'?>>порядок</label>
                <select name="com_compl_order_by" id="select_com_compl_order_by" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden'?> class="form-control form-control-sm m-1">
                    <option value="ASC" <?php if ($data_get['com_compl_order_by'] == 'ASC') echo 'selected'?>>зростанням</option>
                    <option value="DESC" <?php if ($data_get['com_compl_order_by'] == 'DESC') echo 'selected'?>>спаданням</option>
                </select>
                <label for="select_com_compl_qty" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden'?>>кількість</label>
                <select name="com_compl_qty" id="select_com_compl_qty" <?php if ($data_get['table'] != 'com_complaints') echo 'hidden'?> class="form-control form-control-sm m-1">
                    <option value="20" <?php if ($data_get['com_compl_qty'] == '20') echo 'selected'?>>20</option>
                    <option value="30" <?php if ($data_get['com_compl_qty'] == '30') echo 'selected'?>>30</option>
                    <option value="40" <?php if ($data_get['com_compl_qty'] == '40') echo 'selected'?>>40</option>
                </select>
                <button type="submit" name="do_filter" class="btn btn-success ml-3">Фільтрувати</button>
            </form>
        </div>
        <?php if ($data_get['table'] == 'users'):?>
            <table class="table table-sm table-striped table-bordered table-hover">
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
                <form id="update" action="admin.php?<?= $request?>" method="POST">
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
        <?php elseif ($data_get['table'] == 'announcements') :?>
            <div>
                <table class="table table-sm table-striped table-bordered">
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
                    <form id="update_ann" action="admin.php?<?= $request?>" method="POST">
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
                                <td><?= $announcement['complaint'] ?></td>
                                <td>
                                    <div class="row justify-content-center">
                                        <a target="_blank" rel="noopener noreferrer"
                                           href="announcement.php?id=<?= $announcement['id'] ?>"
                                           class="btn btn-sm btn-primary mr-2"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn-sm btn-warning mr-2"><i class="fas fa-envelope"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger mr-2" <?php if (!$announcement['complaint']) echo 'disabled'?> type="submit" name="do_delete_ann_complaint<?= $announcement['id'] ?>">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger mr-2" type="submit" name="do_delete_ann<?= $announcement['id'] ?>">
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
        <?php elseif ($data_get['table'] == 'com_complaints'):?>
            <div>
                <table class="table table-sm table-striped table-bordered">
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
                    <form id="update" action="admin.php?<?= $request?>" method="POST">
                        <tbody>
                            <?php foreach ($complaints as $complaint): ?>
                                <tr>
                                    <td><div class="row justify-content-center"><input type="checkbox" name="check_complaint<?= $complaint['id'] ?>"></div></td>
                                    <td><?= $complaint['id'] ?></td>
                                    <td><a href="announcement.php?id=<?= $complaint['announcement_id']?>"><?= $complaint['announcement_id']?></a></td>
                                    <td><?= $complaint['user_id']?></td>
                                    <td><?= substr($complaint['message'], 0, 30)?></td>
                                    <td><?= $complaint['complaint']?></td>
                                    <td><?= show_detailed_date($complaint['date'])?></td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a target="_blank" rel="noopener noreferrer"
                                               href="announcement.php?id=<?= $complaint['announcement_id']?>#comment<?= $complaint['id']?>"
                                               class="btn btn-sm btn-primary mr-2"><i class="fas fa-eye"></i></a>
                                            <button class="btn btn-sm btn-warning mr-2"><i class="fas fa-envelope"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger mr-2" type="submit" name="do_delete_complaint<?= $complaint['id'] ?>">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger mr-2" type="submit" name="do_delete_comment<?= $complaint['id'] ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </form>
                </table>
            </div>
        <?php endif; ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if($page == 1): ?>
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="admin.php?page=<?= ($page-1).'&'.$request ?>">&laquo;</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="admin.php?page=1&<?= $request?>">1</a></li>
                    <?php if($page > 4): ?>
                        <li class="page-item disabled"><a class="page-link">...</a></li>
                        <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page-3).'&'.$request ?>"><?= $page-3 ?></a></li>
                    <?php endif; ?>
                    <?php if($page > 3): ?>
                        <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page-2).'&'.$request ?>"><?= $page-2 ?></a></li>
                    <?php endif; ?>
                    <?php if($page > 2): ?>
                        <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page-1).'&'.$request ?>"><?= $page-1 ?></a></li>
                    <?php endif; ?>
                <?php endif; ?>
                <li class="page-item active">
                    <span class="page-link"><?= $page ?><span class="sr-only">(current)</span></span>
                </li>
                <?php if($page != $total): ?>
                    <?php if($page+1 < $total): ?>
                        <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page+1).'&'.$request ?>"><?= $page+1 ?></a></li>
                    <?php endif; ?>
                    <?php if($page+2 < $total): ?>
                        <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page+2).'&'.$request ?>"><?= $page+2 ?></a></li>
                    <?php endif; ?>
                    <?php if($page+3 < $total): ?>
                        <li class="page-item"><a class="page-link" href="admin.php?page=<?= ($page+3).'&'.$request ?>"><?= $page+3 ?></a></li>
                        <?php if($page+3 != $total-1): ?>
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <li class="page-item"><a class="page-link" href="admin.php?page=<?= $total.'&'.$request ?>"><?= $total ?></a></li>

                    <li class="page-item">
                        <a class="page-link" href="admin.php?page=<?= ($page+1).'&'.$request ?>">&raquo;</a>
                    </li>
                <? else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                <? endif; ?>
            </ul>
        </nav>
    <?php else:
        header("location: index.php");
    endif; ?>
</div>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
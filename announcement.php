<?php
require "php/db.php";
include_once 'php/functions.php';

if (array_key_exists('logged_user', $_SESSION)) {
    $data = $_POST;
    $errors = array();
    $update_ann_errors = array();

    $announcement = get_announcement_by_id($_GET['id']);
    if ($announcement) {
        [$ann_comments, $com_comments] = get_comments_by_announcement_id($_GET['id']);
        $user = $_SESSION['logged_user'];

        if (isset($data['do_comment'])) {
            if (trim($data['comment_to_ann']) == '') {
                $errors[] = 'коментар не може бути пустим';
            }

            if (empty($errors)) {
                $comment = R::dispense('comments');
                $comment->message = nl2br($data['comment_to_ann']);
                $comment->date = time();
                $comment->user_id = $user['id'];
                $comment->announcement_id = $announcement['id'];
                R::store($comment);
                header("location: announcement.php?id=" . $announcement['id']);
            }
        }

        foreach ($ann_comments as $ann_comment) {
            if (isset($data['do_comment_to_comment' . $ann_comment['id']])) {
                if (trim($data['comment_to_com' . $ann_comment['id']]) == '') {
                    $errors[] = 'коментар не може бути пустим';
                }

                if (empty($errors)) {
                    $comment = R::dispense('comments');
                    $comment->parent_comment_id = $ann_comment['id'];
                    $comment->message = nl2br($data['comment_to_com' . $ann_comment['id']]);
                    $comment->date = time();
                    $comment->user_id = $user['id'];
                    $comment->announcement_id = $announcement['id'];
                    R::store($comment);
                    header("location: announcement.php?id=" . $announcement['id']);
                }
            }

            if (isset($data['do_delete_comment' . $ann_comment['id']])) {
                foreach ($com_comments as $com_comment) {
                    if ($com_comment['parent_comment_id'] == $ann_comment['id']) {
                        R::trash($com_comment);
                    }
                }
                R::trash($ann_comment);
                header("location: announcement.php?id=" . $announcement['id']);
            }

            if (isset($data['do_ban_comment' . $ann_comment['id']])) {
                $ann_comment['complaint'] = $user['id'];
                R::store($ann_comment);
                header("location: announcement.php?id=" . $announcement['id']);
            }
        }

        foreach ($com_comments as $com_comment) {
            if (isset($data['do_delete_comment' . $com_comment['id']])) {
                R::trash($com_comment);
                header("location: announcement.php?id=" . $announcement['id']);
            }

            if (isset($data['do_ban_comment' . $com_comment['id']])) {
                $com_comment['complaint'] = $user['id'];
                R::store($com_comment);
                header("location: announcement.php?id=" . $announcement['id']);
            }
        }

        if (isset($data['do_delete_ann'])) {
            R::trash($announcement);
            header("location: index.php");
        }

        if (isset($data['do_ban_ann'])) {
            $announcement['complaint'] = $user['id'];
            R::store($announcement);
            header("location: announcement.php?id=" . $announcement['id']);
        }

        if (isset($data['do_update_ann'])) {
            if (trim($data['title']) == '') {
                $update_ann_errors[] = 'заголовок не може бути порожнім';
            }
            if ($data['deadline'] == '') {
                $update_ann_errors[] = 'повинен бути вказаний дедлайн';
            }
            if (strtotime($data['deadline']) < time()) {
                $update_ann_errors[] = 'дедлайн не може бути попередньою датою';
            }
            if (trim($data['details']) == '') {
                $update_ann_errors[] = 'деталі оголошення не можуть бути порожніми';
            }

            if (empty($update_ann_errors)) {
                $announcement->title = $data['title'];
                $announcement->details = nl2br($data['details']);
                $announcement->deadline = strtotime($data['deadline']);
                $announcement->announcement_status_id = 2;

                // attach file
//            if(isset($_FILES['userfile'])) {
//                $uploadName = basename($_FILES['userfile']['name']);
//                $uploadFile = get_upload_path() . $uploadName;
//                echo "<script> alert(".$uploadName.");</script>";
//                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {
//                    $announcement->file = "".$uploadName;
//                } else {
//                    $errors[] = "file error";
//                }
//            }

                R::store($announcement);

                header('location: announcement.php?id=' . $announcement->id);
            }
        }

        if (isset($data['do_cancel_ann'])) {
            header('location: announcement.php?id=' . $announcement->id);
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

    <title><?= $announcement['title'] ?> | StepHub</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Page Content -->
    <?php if (array_key_exists('logged_user', $_SESSION)): ?>
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-9">
                <?php if (isset($data['do_edit_ann'])): ?>
                    <div class="card shadow-sm">
                        <form id="form_edit_ann" action="announcement.php?id=<?= $announcement['id']?>" method="post" class="form-group">
                            <div class="card-header my-bg-gray my-color-dark border-bottom-0">
                                <div class="row justify-content-center">
                                    <p class="mt-0 mb-0 font-weight-bold text-danger"><?= @$update_ann_errors[0]; ?></>
                                </div>
                                <div class="container">
                                    <div class="row pt-2 pb-2">
                                        <input type="text" name="title" value="<?= $announcement['title']?>" class="form-control form-control-lg my-bg-light my-color-dark" placeholder="Заголовок">
                                    </div>
                                    <div class="row pt-2 px-2">
                                        <p class="card-text text-muted small mr-2"><i class="far fa-calendar mr-2"></i><?= show_date($announcement['date']) ?></p>
                                        <p class="card-text text-muted small ml-2 mr-4"><i class="far fa-clock mr-2"></i><?= show_time($announcement['date']) ?></p>
                                        <p class="card-text text-muted small ml-2"><i class="far fa-calendar-times mr-2"></i></p>
                                        <p class="card-text text-muted small mb-2 mr-0"><input type="date" name="deadline" value="<?= date("Y-m-d", $announcement['deadline'])?>" class="form-control form-control-sm my-bg-light text-muted"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-4 pt-4 pb-2">
                                <textarea name="details" cols="30" rows="10" class="form-control"><?= $announcement['details'] ?></textarea>
                            </div>
                            <?php if (isset($announcement['file'])): ?>
                                <div class="card-footer">
                                    <p><i class="fa fa-paperclip mr-2"></i><?= $announcement['file']?></p>
                                    <button class="btn btn-secondary"><i class="fas fa-file-download mr-2"></i>Завантажити</button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="card shadow-sm">
                        <div class="card-header my-bg-gray my-color-dark border-bottom-0">
                            <div class="container">
                                <div class="row pt-2 pb-2">
                                    <div class="col-md-10">
                                        <h3 class="card-title"><?= $announcement['title'] ?></h3>
                                    </div>
                                    <div class="col-md-2 pr-0">
                                        <?php if($user['id'] != $announcement['user_id']): ?>
                                            <form action="announcement.php?id=<?= $announcement['id']?>" method="post">
                                                <button class="btn float-right my-color-dark" name="do_ban_ann" type="submit"><i class="fas fa-ban"></i></button>
                                            </form>
                                        <? endif; ?>
                                    </div>
                                </div>
                                <div class="row pt-2 px-2">
                                    <p class="card-text text-muted small mx-2"><i class="far fa-calendar mr-2"></i><?= show_date($announcement['date']) ?></p>
                                    <p class="card-text text-muted small mx-2 mr-4"><i class="far fa-clock mr-2"></i><?= show_time($announcement['date']) ?></p>
                                    <p class="card-text text-muted small mx-2"><i class="far fa-calendar-times mr-2"></i><?= show_date($announcement['deadline']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><?= $announcement['details'] ?></p>
                        </div>
                        <?php if (isset($announcement['file'])): ?>
                            <div class="card-footer">
                                <p><i class="fa fa-paperclip mr-2"></i><?= $announcement['file']?></p>
                                <button class="btn btn-secondary"><i class="fas fa-file-download mr-2"></i>Завантажити</button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="card shadow-sm mt-5">
                    <div class="card-header">
                        <form class="form" action="announcement.php?id=<?= $_GET['id'] ?>" method="POST">
                            <?php if ($errors): ?>
                                <div class="row justify-content-center">
                                    <p class="mt-0 mb-0 font-weight-bold text-danger"><?= @$errors[0]; ?></>
                                </div>
                            <?php endif; ?>
                            <label class="sr-only" for="comment_field">Написати коментар</label>
                            <textarea type="text" name="comment_to_ann" rows="3" class="form-control mt-2 mb-2 mr-sm-2"
                                      id="comment_field"
                                      placeholder="Написати коментар"></textarea>
                            <button type="submit" name="do_comment" class="btn my-btn-blue mt-1 mb-2"><i class="fas fa-comment mr-2"></i>Коментувати</button>
                        </form>
                    </div>
                    <div class="card-body bg-light">
                        <?php if (count($ann_comments) > 0): ?>
                            <?php foreach ($ann_comments as $a): ?>

                                <div class="anchor" id="comment<?= $a['id']?>">
                                    <div class="card mt-3 announcement-card" >
                                        <div class="card-header my-bg-gray pb-0 pt-1">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <p class="card-text text-muted small mx-2 mb-0"><i class="far fa-calendar mr-2"></i><?= show_date($a['date']) ?></p>
                                                        <p class="card-text text-muted small mx-2 mb-0"><i class="far fa-clock mr-2"></i><?= show_time($a['date']) ?></p>
                                                        <?php if ($announcement['user_id'] == $a['user_id']): ?>
                                                            <span class="badge badge-success mx-2 mb-0"><i class="fas fa-user mr-2"></i>Автор оголошення</span>
                                                        <?php elseif ($user['id'] == $a['user_id']): ?>
                                                            <span class="badge badge-secondary mx-2 mb-0"><i class="fas fa-user mr-2"></i>Ваш коментар</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 pr-1">
                                                    <form action="announcement.php?id=<?= $announcement['id']?>" method="POST">
                                                        <?php if ($user['id'] == $a['user_id']): ?>
                                                            <button name="do_delete_comment<?= $a['id']?>" type="submit" class="btn btn-sm float-right text-muted p-0"><i class="fas fa-trash"></i></button>
                                                        <?php elseif(!$a['complaint']): ?>
                                                            <button name="do_ban_comment<?= $a['id']?>" type="submit" class="btn btn-sm float-right text-muted p-0"><i class="fas fa-ban"></i></button>
                                                        <?php endif; ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body pb-1 px-1 pt-2">
                                            <p class="card-text mb-2 mx-2"> <?= $a['message'] ?></p>
                                            <span class="badge btn mb-0" type="button" data-toggle="collapse" data-target="#collapse<?= $a['id'] ?>" aria-expanded="true" aria-controls="collapse<?= $a['id'] ?>"><i class="fas fa-reply mr-2"></i>Відповісти</span>
                                        </div>
                                        <div class="accordion" id="idReply<?= $a['id'] ?>">
                                            <div class="" id="heading<?= $a['id'] ?>"></div>
                                            <div id="collapse<?= $a['id'] ?>" class="collapse" aria-labelledby="heading<?= $a['id'] ?>" data-parent="#idReply<?= $a['id'] ?>">
                                                <div class="card-footer px-2 pb-1">
                                                    <form class="form-inline" action="announcement.php?id=<?= $_GET['id'] ?>"
                                                          method="POST">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-9 pl-0">
                                                                    <label class="sr-only" for="comment_field">Написати коментар</label>
                                                                    <textarea class="form-control-sm  mr-sm-2"
                                                                              style="min-width: 100%"
                                                                              type="text"
                                                                              name="comment_to_com<?= $a['id'] ?>"
                                                                              rows="1"
                                                                              id="comment_field"
                                                                              placeholder="Написати коментар"></textarea>
                                                                </div>
                                                                <div class="col-md-auto pl-0">
                                                                    <button type="submit"
                                                                            name="do_comment_to_comment<?= $a['id'] ?>"
                                                                            class="btn btn-sm my-btn-blue">
                                                                        <i class="fa fa-paper-plane mr-2"></i>Відправити
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php foreach ($com_comments as $c): ?>
                                    <?php if ($c['parent_comment_id'] == $a['id']): ?>
                                        <div class="row justify-content-end anchor" id="comment<?= $c['id']?>">
                                            <div class="col-md-10">
                                                <div class="card mt-2 announcement-card">
                                                    <div class="card-header my-bg-gray pb-0 pt-1">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <p class="card-text text-muted small mx-2 mb-0">
                                                                        <i class="far fa-calendar mr-2"></i><?= show_date($c['date']) ?>
                                                                    </p>
                                                                    <p class="card-text text-muted small mx-2 mb-0">
                                                                        <i class="far fa-clock mr-2"></i><?= show_time($c['date']) ?>
                                                                    </p>
                                                                    <?php if ($announcement['user_id'] == $c['user_id']): ?>
                                                                        <span class="badge badge-success mx-2 mb-0"><i class="fas fa-user mr-2"></i>Автор оголошення</span>
                                                                    <?php elseif ($user['id'] == $c['user_id']): ?>
                                                                        <span class="badge badge-secondary mx-2 mb-0"><i class="fas fa-user mr-2"></i>Ваш коментар</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 pr-1">
                                                                <form action="announcement.php?id=<?= $announcement['id']?>" method="POST">
                                                                    <?php if ($user['id'] == $c['user_id']): ?>
                                                                        <button name="do_delete_comment<?= $c['id']?>" type="submit" class="btn btn-sm float-right text-muted p-0"><i class="fas fa-trash"></i></button>
                                                                    <?php elseif(!$c['complaint']): ?>
                                                                        <button name="do_ban_comment<?= $c['id']?>" type="submit" class="btn btn-sm float-right text-muted p-0"><i class="fas fa-ban"></i></button>
                                                                    <?php endif; ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body p-2 shadow-sm">
                                                        <p class="card-text"><?= $c['message'] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="card mt-3 announcement-card" id="commentsNotFound">
                                <div class="card-body">
                                    <p class="card-text text-center text-muted mb-2 mx-2"><i class="fas fa-exclamation-circle mr-3"></i>Коментарів цього оголошення не знайдено</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if($user['id'] == $announcement['user_id']): ?>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body shadow-sm">
                            <form action="announcement.php?id=<?= $announcement['id']?>" method="post" class="form-group">
                                <?php if (isset($data['do_edit_ann'])): ?>
                                    <h5 class="card-title">Редагувати</h5>

                                    <button class="btn btn-secondary btn-block mt-3" form="form_edit_ann" name="do_cancel_ann" type="submit"><i class="fas fa-redo mr-2"></i>Відмінити</button>
                                    <button class="btn btn-success btn-block mt-3" form="form_edit_ann" name="do_update_ann" type="submit"><i class="fas fa-save mr-2"></i>Зберегти</button>
                                <?php else: ?>
                                    <h5 class="card-title">Ваше оголошення</h5>

                                    <button class="btn btn-secondary btn-block mt-3" name="do_edit_ann" type="submit"><i class="fas fa-edit mr-2"></i>Редагувати</button>
                                    <button class="btn btn-danger btn-block mt-3" name="do_delete_ann" type="submit"><i class="fas fa-trash mr-2"></i>Видалити</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body shadow-sm">
                            <h5 class="card-title">Можеш допомогти?</h5>
                            <a href="#" class="btn btn-secondary btn-block"><i class="fas fa-comments mr-2"></i>Написати автору</a>
                            <p class="text-center my-0">або</p>
                            <a href="#" class="btn btn-success btn-block"><i class="fas fa-hands-helping mr-2"></i>Допомогти</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else:
        header("location: index.php");
    endif; ?>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
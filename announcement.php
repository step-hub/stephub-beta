<?php
require "php/db.php";
include_once 'php/functions.php';

if (array_key_exists('logged_user', $_SESSION)) {
    $data = $_POST;
    $errors = array();
    $update_ann_errors = array();

    $user_status = $_SESSION['logged_user']->user_status;
    $user_id = $_SESSION['logged_user']->id;

    $announcement = get_announcement_by_id($_GET['id']);
    if ($announcement) {
        $visible = true;
        if ($announcement['announcement_status_id'] == 3) {
            if (!($user_status <= 2 or $announcement['user_id'] == $user_id or $announcement['help_user_id'] == $user_id))
                $visible = false;
        }
        if ($announcement['announcement_status_id'] == 2) {
            if (!($user_status <= 2 or $announcement['user_id'] == $user_id))
                $visible = false;
        }
        [$ann_comments, $com_comments] = get_comments_by_announcement_id($_GET['id']);
        $user = $_SESSION['logged_user'];

        if (isset($data['do_comment'])) {
            if (trim($data['comment_to_ann']) == '') {
                $errors[] = 'Ваш коментар не може бути порожнім';
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
                    $errors[] = 'Ваш коментар не може бути порожнім';
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
                $update_ann_errors[] = 'Вкажіть загловок оголошення';
            }
            if ($data['deadline'] == '') {
                $update_ann_errors[] = 'Встановіть дедлайн оголошення';
            }
            if (strtotime($data['deadline']) < time()) {
                $update_ann_errors[] = 'Дедлайн не може бути попередньою датою';
            }
            if (trim($data['details']) == '') {
                $update_ann_errors[] = 'Вкажіть деталі оголошення';
            }

            if (empty($update_ann_errors)) {
                $announcement['title'] = $data['title'];
                $announcement['details'] = nl2br($data['details']);
                $announcement['deadline'] = strtotime($data['deadline']);
                $announcement['announcement_status_id'] = 2;

                R::store($announcement);

                header('location: announcement.php?id=' . $announcement['id']);
            }
        }

        if (isset($data['do_cancel_ann'])) {
            header('location: announcement.php?id=' . $announcement['id']);
        }

        if (isset($data['do_help'])) {
            $announcement['help_user_id'] = $_SESSION['logged_user']->id;
            R::store($announcement);
            header('location: announcement.php?id=' . $announcement['id']);
        }

        if (isset($data['do_apply_help'])) {
            $announcement['announcement_status_id'] = 3;
            R::store($announcement);
            header('location: announcement.php?id=' . $announcement['id']);
        }

        if (isset($data['do_cancel_help'])) {
            $announcement['announcement_status_id'] = 1;
            $announcement['help_user_id'] = null;
            $announcement['date'] = time();
            R::store($announcement);
            header('location: announcement.php?id=' . $announcement['id']);
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

    <title>
        <?php if ($announcement) {
            echo $announcement['title'];
        } else {
            echo "Не знайдено оголошення";
        } ?> | StepHub</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">

    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="css/announcement.css" rel="stylesheet">

</head>

<body>
    <!-- Preloader -->
    <?php include_once 'templates/preloader.html'; ?>

    <!-- Back to top button -->
    <a id="back-to-top-button"></a>

    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Page Content -->
    <div class="container pt-5">
        <?php if ($announcement) : ?>
            <?php if ($visible) : ?>
                <div class="row">
                    <div class="col-md-9">
                        <!-- Announcement -->
                        <?php if (isset($data['do_edit_ann'])) : ?>
                            <!-- Edit Announcement -->
                            <div class="card announcement shadow">
                                <form id="form_edit_ann" action="announcement.php?id=<?= $announcement['id'] ?>" method="post" class="form-group">
                                    <div class="card-header diagonal-gradient-gray-light my-color-dark border-bottom-0">
                                        <?php if (@$update_ann_errors) : ?>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-danger alert-dismissible shadow-sm" role="alert">
                                                        <?= @$update_ann_errors[0]; ?>
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="container">
                                            <div class="row pt-2 pb-2">
                                                <input type="text" name="title" value="<?= $announcement['title'] ?>" class="form-control form-control-lg my-bg-light my-color-dark" placeholder="Заголовок">
                                            </div>
                                            <div class="row pt-2 px-2">
                                                <p class="card-text text-muted small mr-2"><i class="far fa-calendar mr-2"></i><?= show_date($announcement['date']) ?></p>
                                                <p class="card-text text-muted small ml-2 mr-4"><i class="far fa-clock mr-2"></i><?= show_time($announcement['date']) ?></p>
                                                <p class="card-text text-muted small ml-2"><i class="far fa-calendar-times mr-2"></i></p>
                                                <p class="card-text text-muted small mb-2 mr-0"><input type="date" name="deadline" value="<?= date("Y-m-d", $announcement['deadline']) ?>" class="form-control form-control-sm my-bg-light text-muted"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="details" cols="30" rows="10" class="form-control"><?= $announcement['details'] ?></textarea>
                                    </div>
                                    <?php if (isset($announcement['file'])) : ?>
                                        <div class="card-footer">
                                            <div class="row pt-2">
                                                <button class="btn my-btn-red shadow-sm ml-3"><i class="material-icons mr-2">cancel</i>Відкріпити файл</button>
                                                <p class="ml-2 my-1"><i class="material-icons mr-2">insert_drive_file</i><?= $announcement['file'] ?></p>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="card-footer">
                                            <!-- Upload file -->
                                            <label for="fileUpload" class="file-upload btn my-btn-blue btn-block w-auto clickable shadow-sm">
                                                <i class="material-icons mr-2">attach_file</i>Прикріпити файл
                                                <input id="fileUpload" type="file" name="userfile">
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                </form>
                            </div><!-- /Edit Announcement -->
                        <?php else : ?>
                            <!-- Show Announcement -->
                            <div class="card announcement shadow <?php if ($announcement['complaint'] and ($user['user_status'] == 1 or $user['user_status'] == 2)) {
                                                                        echo 'border-danger';
                                                                    } ?>">
                                <div class="card-header announcement-block-header my-color-dark diagonal-gradient-gray-light <?php if ($announcement['complaint'] and ($user['user_status'] == 1 or $user['user_status'] == 2)) {
                                                                                                                                    echo 'diagonal-gradient-red-light';
                                                                                                                                } ?>">
                                    <div class="container">
                                        <div class="row pt-2 pb-2">
                                            <div class="col-md-10">
                                                <h3 class="card-title"><?= $announcement['title'] ?></h3>
                                            </div>
                                            <div class="col-md-2 pr-0">
                                                <?php if ($user['id'] != $announcement['user_id']) : ?>
                                                    <?php if ($announcement['complaint'] and ($user['user_status'] == 1 or $user['user_status'] == 2)) : ?>
                                                        <button class="btn float-right comment-option-admin" data-toggle="modal" data-target="#removeAnnModal"><i class="fas fa-trash"></i></button>
                                                    <?php else : ?>
                                                        <button class="btn float-right announcement-option" data-toggle="modal" data-target="#banAnnModal"><i class="fas fa-ban"></i></button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="row pt-2 px-2">
                                            <p class="card-text text-muted small mx-2"><i class="far fa-calendar mr-2"></i><?= show_date($announcement['date']) ?></p>
                                            <p class="card-text text-muted small mx-2 mr-4"><i class="far fa-clock mr-2"></i><?= show_time($announcement['date']) ?></p>
                                            <p class="card-text text-muted small mx-2"><i class="far fa-calendar-times mr-2"></i><?= show_date($announcement['deadline']) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body px-4 pt-4 pb-2 announcement-block-body">
                                    <p class="lead"><?= $announcement['details'] ?></p>
                                </div>
                                <?php if (isset($announcement['file'])) : ?>
                                    <div class="card-footer">
                                        <div class="row pt-2">
                                            <a href="uploads/<?= $announcement['id'] ?>/<?= $announcement['file'] ?>" class="btn btn-secondary shadow-sm ml-3" download><i class="material-icons mr-2">get_app</i>Завантажити</a>
                                            <p class="ml-2 my-1"><i class="material-icons mr-2">insert_drive_file</i><?= $announcement['file'] ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div><!-- /Show Announcement -->

                            <!-- Comments -->
                            <div class="card shadow mt-5">
                                <div class="card-header">
                                    <!-- Leave New Comment -->
                                    <form class="form" action="announcement.php?id=<?= $_GET['id'] ?>" method="POST">
                                        <?php if ($errors) : ?>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-danger alert-dismissible shadow-sm" role="alert">
                                                        <?= @$errors[0]; ?>
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <label class="sr-only" for="comment_field">Написати коментар</label>
                                        <textarea type="text" name="comment_to_ann" rows="3" class="form-control mt-2 mb-2 mr-sm-2" id="comment_field" placeholder="Написати коментар"></textarea>
                                        <button type="submit" name="do_comment" class="btn my-btn-blue mt-1 mb-2"><i class="fas fa-comment mr-2"></i>Коментувати</button>
                                    </form><!-- /Leave New Comment -->
                                </div>
                                <div class="card-body bg-light">
                                    <?php if (count($ann_comments) > 0) : ?>
                                        <?php foreach ($ann_comments as $a) : ?>
                                            <!-- Comment 1st lvl -->
                                            <div class="anchor" id="comment<?= $a['id'] ?>">
                                                <div class="card mt-3 bg-white shadow <?php if ($a['complaint'] and ($user['user_status'] == 1 or $user['user_status'] == 2)) {
                                                                                            echo 'border-danger';
                                                                                        } ?>">
                                                    <div class="card-header pb-0 pt-1 border-bottom-0 diagonal-gradient-gray <?php if ($a['complaint'] and ($user['user_status'] == 1 or $user['user_status'] == 2)) {
                                                                                                                                    echo 'diagonal-gradient-red-light';
                                                                                                                                } ?>">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <p class="card-text text-muted small mx-2 mb-0"><i class="far fa-calendar mr-2"></i><?= show_date($a['date']) ?></p>
                                                                    <p class="card-text text-muted small mx-2 mb-0"><i class="far fa-clock mr-2"></i><?= show_time($a['date']) ?></p>
                                                                    <?php if ($user['id'] == $a['user_id']) : ?>
                                                                        <span class="badge badge-primary my-bg-blue ml-2 mb-0"><i class="fas fa-user mr-2"></i>Ваш коментар</span>
                                                                    <?php elseif ($announcement['user_id'] == $a['user_id']) : ?>
                                                                        <span class="badge badge-success ml-2 mb-0"><i class="far fa-star mr-2"></i>Автор оголошення</span>
                                                                    <?php endif; ?>

                                                                    <?php if (get_user_by_id($a['user_id'])['user_status'] == 1) : ?>
                                                                        <span class="badge badge-secondary ml-2 mb-0"><i class="fas fa-shield-alt mr-2"></i>Адміністратор</span>
                                                                    <?php elseif (get_user_by_id($a['user_id'])['user_status'] == 2) : ?>
                                                                        <span class="badge badge-secondary ml-2 mb-0"><i class="far fa-shield-al mr-2"></i>Модератор</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 pr-1">
                                                                <form action="announcement.php?id=<?= $announcement['id'] ?>" method="POST">
                                                                    <?php if ($user['id'] == $a['user_id']) : ?>
                                                                        <button name="do_delete_comment<?= $a['id'] ?>" type="submit" class="btn btn-sm float-right comment-option p-0"><i class="fas fa-trash"></i></button>
                                                                    <?php elseif (!$a['complaint']) : ?>
                                                                        <button name="do_ban_comment<?= $a['id'] ?>" type="submit" class="btn btn-sm float-right comment-option p-0"><i class="fas fa-ban"></i></button>
                                                                    <?php elseif ($a['complaint']) : ?>
                                                                        <?php if ($user['user_status'] == 1 or $user['user_status'] == 2) : ?>
                                                                            <button name="do_delete_comment<?= $a['id'] ?>" type="submit" class="btn btn-sm float-right comment-option-admin p-0"><i class="fas fa-trash"></i></button>
                                                                        <?php else : ?>
                                                                            <button class="btn btn-sm float-right text-muted p-0" disabled><i class="fas fa-ban"></i></button>
                                                                        <?php endif; ?>
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
                                                                <form class="form-inline" action="announcement.php?id=<?= $_GET['id'] ?>" method="POST">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <div class="col-md-9 pl-0">
                                                                                <label class="sr-only" for="comment_field">Написати коментар</label>
                                                                                <textarea class="form-control-sm  mr-sm-2" style="min-width: 100%" type="text" name="comment_to_com<?= $a['id'] ?>" rows="1" id="comment_field" placeholder="Написати коментар"></textarea>
                                                                            </div>
                                                                            <div class="col-md-auto ml-auto pl-0 pr-1">
                                                                                <button type="submit" name="do_comment_to_comment<?= $a['id'] ?>" class="btn btn-sm my-btn-blue">
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
                                            </div><!-- /Comment 1st lvl -->
                                            <?php foreach ($com_comments as $c) : ?>
                                                <?php if ($c['parent_comment_id'] == $a['id']) : ?>
                                                    <!-- Comment 2nd lvl -->
                                                    <div class="row justify-content-end anchor" id="comment<?= $c['id'] ?>">
                                                        <div class="col-md-10">
                                                            <div class="card mt-2 bg-white shadow <?php if ($c['complaint'] and ($user['user_status'] == 1 or $user['user_status'] == 2)) {
                                                                                                        echo 'border-danger';
                                                                                                    } ?>">
                                                                <div class="card-header pb-0 pt-1 border-bottom-0 diagonal-gradient-gray <?php if ($c['complaint'] and ($user['user_status'] == 1 or $user['user_status'] == 2)) {
                                                                                                                                                echo 'diagonal-gradient-red-light';
                                                                                                                                            } ?>">
                                                                    <div class="row">
                                                                        <div class="col-md-10">
                                                                            <div class="row">
                                                                                <p class="card-text text-muted small mx-2 mb-0"><i class="far fa-calendar mr-2"></i><?= show_date($c['date']) ?></p>
                                                                                <p class="card-text text-muted small mx-2 mb-0"><i class="far fa-clock mr-2"></i><?= show_time($c['date']) ?></p>
                                                                                <?php if ($user['id'] == $c['user_id']) : ?>
                                                                                    <span class="badge badge-primary my-bg-blue ml-2 mb-0"><i class="fas fa-user mr-2"></i>Ваш коментар</span>
                                                                                <?php elseif ($announcement['user_id'] == $c['user_id']) : ?>
                                                                                    <span class="badge badge-success ml-2 mb-0"><i class="far fa-star mr-2"></i>Автор оголошення</span>
                                                                                <?php endif; ?>

                                                                                <?php if (get_user_by_id($c['user_id'])['user_status'] == 1) : ?>
                                                                                    <span class="badge badge-secondary ml-2 mb-0"><i class="fas fa-shield-alt mr-2"></i>Адміністратор</span>
                                                                                <?php elseif (get_user_by_id($c['user_id'])['user_status'] == 2) : ?>
                                                                                    <span class="badge badge-secondary ml-2 mb-0"><i class="far fa-shield-al mr-2"></i>Модератор</span>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 pr-1">
                                                                            <form action="announcement.php?id=<?= $announcement['id'] ?>" method="POST">
                                                                                <?php if ($user['id'] == $c['user_id']) : ?>
                                                                                    <button name="do_delete_comment<?= $c['id'] ?>" type="submit" class="btn btn-sm float-right comment-option p-0"><i class="fas fa-trash"></i></button>
                                                                                <?php elseif (!$c['complaint']) : ?>
                                                                                    <button name="do_ban_comment<?= $c['id'] ?>" type="submit" class="btn btn-sm float-right comment-option p-0"><i class="fas fa-ban"></i></button>
                                                                                <?php elseif ($c['complaint']) : ?>
                                                                                    <?php if ($user['user_status'] == 1 or $user['user_status'] == 2) : ?>
                                                                                        <button name="do_delete_comment<?= $c['id'] ?>" type="submit" class="btn btn-sm float-right comment-option-admin p-0"><i class="fas fa-trash"></i></button>
                                                                                    <?php else : ?>
                                                                                        <button class="btn btn-sm float-right text-muted p-0" disabled><i class="fas fa-ban"></i></button>
                                                                                    <?php endif; ?>
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
                                                    </div><!-- /Comment 2nd lvl -->
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <!-- Comments Not Found -->
                                        <div class="card mt-3 bg-white" id="commentsNotFound">
                                            <div class="card-body">
                                                <p class="card-text text-center text-muted mb-2 mx-2"><i class="fas fa-exclamation-circle mr-3"></i>Коментарів цього оголошення не знайдено</p>
                                            </div>
                                        </div><!-- /Comments Not Found -->
                                    <?php endif; ?>
                                </div>
                            </div><!-- /Comments -->

                        <?php endif; ?>
                        <!-- /Announcement -->
                    </div>

                    <?php if ($user['id'] == $announcement['user_id']) : ?>
                        <!-- Owner Menu -->
                        <div class="col-md-3">
                            <div class="card shadow">
                                <div class="card-body">
                                    <?php if (isset($data['do_edit_ann'])) : ?>
                                        <h5 class="card-title">Редагувати</h5>
                                        <button class="btn btn-secondary btn-block mt-3" form="form_edit_ann" name="do_cancel_ann" type="submit"><i class="fas fa-redo mr-2"></i>Відмінити</button>
                                        <button class="btn btn-success btn-block mt-3" form="form_edit_ann" name="do_update_ann" type="submit"><i class="fas fa-save mr-2"></i>Зберегти</button>
                                    <?php else : ?>
                                        <h5 class="card-title">Ваше оголошення</h5>
                                        <form action="announcement.php?id=<?= $announcement['id'] ?>" method="post" class="form-group">
                                            <?php if ($announcement['help_user_id']) : ?>
                                                <?php if ($announcement['announcement_status_id'] == 1) : ?>
                                                    <button class="btn btn-success btn-block mt-3" name="do_apply_help" type="submit"><i class="fas fa-hands-helping mr-2"></i>Прийняти допомогу</button>
                                                <?php elseif ($announcement['announcement_status_id'] == 3) : ?>
                                                    <button class="btn btn-warning btn-block mt-3" name="do_cancel_help" type="submit"><i class="fas fa-hands-helping mr-2"></i>Відмовити допомогу</button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <button class="btn btn-secondary btn-block mt-3" name="do_edit_ann" type="submit"><i class="fas fa-edit mr-2"></i>Редагувати</button>
                                        </form>
                                        <button class="btn my-btn-red btn-block mt-3" data-toggle="modal" data-target="#removeAnnModal"><i class="fas fa-trash mr-2"></i>Видалити</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- /Owner Menu -->
                    <?php elseif (!$announcement['help_user_id']) : ?>
                        <!-- Others Menu -->
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body shadow">
                                    <h5 class="card-title">Можеш допомогти?</h5>
                                    <form id="help" action="announcement.php?id=<?= $announcement['id'] ?>" method="post">
                                        <button type="submit" form="help" name="do_help" class="btn btn-success btn-block"><i class="fas fa-hands-helping mr-2"></i>Допомогти</button>
                                    </form>
                                </div>
                            </div>
                        </div><!-- Others Menu -->
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <!-- Frozen Announcement -->
                <div class="card not-found-parent diagonal-gradient-gray-light shadow">
                    <div class="card-body text-center">
                        <div class="card not-found-child diagonal-gradient-gray-light">
                            <div class="card-body text-center my-color-dark py-5">
                                <h3 class="mb-5"><i class="fas fa-exclamation-circle mr-3"></i>У вас нема можливості переглядати це оголошення</h3>
                                <a href="index.php">Повернутись на головну</a>
                            </div>
                        </div>
                    </div>
                </div><!-- /Frozen Announcement -->
            <?php endif; ?>
        <?php else : ?>
            <!-- Not Found Announcement -->
            <div class="card not-found-parent diagonal-gradient-gray-light shadow">
                <div class="card-body text-center">
                    <div class="card not-found-child diagonal-gradient-gray-light">
                        <div class="card-body text-center my-color-dark py-5">
                            <h3 class="mb-5"><i class="fas fa-exclamation-circle mr-3"></i>Вибачте, сторінку оголошення не знайдено</h3>
                            <a href="index.php">Повернутись на головну</a>
                        </div>
                    </div>
                </div>
            </div><!-- /Not Found Announcement -->
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Modal Remove Announcement -->
    <div class="modal fade" id="removeAnnModal" tabindex="-1" role="dialog" aria-labelledby="removeAnnModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeAnnModalLabel">Видалити оголошення</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Після видалення оголошення його буде неможливо переглянути та повернути. Ви дійсно хочете видалити оголошення?
                </div>
                <div class="modal-footer">
                    <form action="announcement.php?id=<?= $announcement['id'] ?>" method="post" class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Скасувати</button>
                        <button class="btn my-btn-red" name="do_remove_ann" type="submit">Видалити</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ban Announcement -->
    <div class="modal fade" id="banAnnModal" tabindex="-1" role="dialog" aria-labelledby="banAnnModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="banAnnModalLabel">Поскаржитись на оголошення</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Якщо оголошення порушує правила користування сервісом, то його буде видалено назавжди. Відправити запит на розглядання цього оголошення модераторами?
                </div>
                <div class="modal-footer">
                    <form action="announcement.php?id=<?= $announcement['id'] ?>" method="post" class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Скасувати</button>
                        <button class="btn my-btn-red" name="do_ban_ann" type="submit">Поскаржитись</button>
                    </form>
                </div>
            </div>
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
<?php
require "php/db.php";
include_once 'php/functions.php';

if ($_SESSION) {
    $data = $_POST;

    $announcement = get_announcement_by_id($_GET['id']);
    [$ann_comments, $com_comments] = get_comments_by_announcement_id($_GET['id']);
    $user = $_SESSION['logged_user'];

    if (isset($data['do_comment'])) {
        $comment = R::dispense('comments');
        $comment->message = $data['comment_to_ann'];
        $comment->date = time();
        $comment->user_id = $user['id'];
        $comment->announcement_id = $announcement['id'];
        R::store($comment);
        header("location: announcement.php?id=" . $_GET['id']);
    }

    foreach ($ann_comments as $ann_comment) {
        if (isset($data['do_comment_to_comment' . $ann_comment['id']])) {
            $comment = R::dispense('comments');
            $comment->parent_comment_id = $ann_comment['id'];
            $comment->message = $data['comment_to_com' . $ann_comment['id']];
            $comment->date = time();
            $comment->user_id = $user['id'];
            $comment->announcement_id = $announcement['id'];
            R::store($comment);
            header("location: announcement.php?id=" . $_GET['id']);
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

    <title>StepHub | Announcement Title</title>

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
<?php if (!$_SESSION):
    include_once 'templates/intro.php'; ?>
<?php else: ?>
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header my-bg-gray my-color-dark">
                        <div class="container">
                            <div class="row pt-2 pb-2">
                                <div class="col-md-10">
                                    <h3 class="card-title"><?= $announcement['title'] ?></h3>
                                </div>
                                <div class="col-md-2 pr-0">
                                    <button class="btn float-right my-color-dark"><i class="fas fa-ban"></i></button>
                                </div>
                            </div>
                            <div class="row pt-2 px-2">
                                <p class="card-text text-muted small mx-2"><i
                                            class="far fa-calendar mr-2"></i><?= show_date($announcement['date']) ?></p>
                                <p class="card-text text-muted small mx-2"><i
                                            class="far fa-calendar-times mr-2"></i><?= show_date($announcement['deadline']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <p><?= $announcement['details'] ?></p>
                    </div>
                    <?php if (isset($announcement['file'])): ?>
                        <div class="card-footer">
                            <button class="btn btn-secondary"><i class="fas fa-download mr-2"></i>Download attachment
                            </button>
                            <div class="card-text text-muted small mx-2"><i class="fas fa-file mr-2"></i>file.zip</div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card shadow-sm mt-5">
                    <div class="card-header">
                        <form class="form" action="announcement.php?id=<?= $_GET['id'] ?>" method="POST">
                            <label class="sr-only" for="comment_field">Leave Comment</label>
                            <textarea type="text" name="comment_to_ann" rows="3" class="form-control mb-2 mr-sm-2"
                                      id="comment_field"
                                      placeholder="Leave Comment"></textarea>
                            <button type="submit" name="do_comment" class="btn my-btn-blue mt-1 mb-2"><i
                                        class="fas fa-comment mr-2"></i>Comment
                            </button>
                        </form>
                    </div>
                    <div class="card-body bg-light">
                        <?php if (count($ann_comments) > 0): ?>
                            <?php foreach ($ann_comments as $a): ?>
                                <div class="card mb-3 announcement-card">
                                    <div class="card-header my-bg-gray pb-0">
                                        <div class="row pl-1">
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <p class="card-text text-muted small mx-2"><i
                                                                class="far fa-calendar mr-2"></i><?= show_date($a['date']) ?>
                                                    </p>
                                                    <p class="card-text text-muted small mx-2"><i
                                                                class="far fa-clock mr-2"></i><?= show_time($a['date']) ?>
                                                    </p>
                                                    <?php if ($announcement['user_id'] == $a['user_id']) : ?>
                                                        <span class="badge badge-secondary mx-2 mb-3"><i
                                                                    class="fas fa-user mr-2"></i>owner</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn float-right text-muted pt-0 pr-0"><i
                                                            class="fas fa-ban"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"> <?= $a['message'] ?></p>
                                    </div>
                                    <div class="card-footer shadow-sm">
                                        <form class="form" action="announcement.php?id=<?= $_GET['id'] ?>"
                                              method="POST">
                                            <label class="sr-only" for="comment_field">Leave Comment</label>
                                            <textarea type="text" name="comment_to_com<?= $a['id'] ?>" rows="3"
                                                      class="form-control mb-2 mr-sm-2"
                                                      id="comment_field"
                                                      placeholder="Leave Comment"></textarea>
                                            <button type="submit" name="do_comment_to_comment<?= $a['id'] ?>"
                                                    class="btn my-btn-blue mt-1 mb-2"><i
                                                        class="fas fa-comment mr-2"></i>Comment
                                            </button>
                                        </form>
                                        <?php foreach ($com_comments as $c) : ?>
                                            <?php if ($c['parent_comment_id'] == $a['id']): ?>
                                                <div class="row justify-content-end">
                                                    <div class="col-md-8 ">
                                                        <div class="card mb-3 announcement-card">
                                                            <div class="card-header my-bg-gray pb-0">
                                                                <div class="row pl-1">
                                                                    <div class="col-md-10">
                                                                        <div class="row">
                                                                            <p class="card-text text-muted small mx-2">
                                                                                <i
                                                                                        class="far fa-calendar mr-2"></i><?= show_date($c['date']) ?>
                                                                            </p>
                                                                            <p class="card-text text-muted small mx-2">
                                                                                <i
                                                                                        class="far fa-clock mr-2"></i><?= show_time($c['date']) ?>
                                                                            </p>
                                                                            <?php if ($announcement['user_id'] == $c['user_id']) : ?>
                                                                                <span class="badge badge-secondary mx-2 mb-3"><i
                                                                                            class="fas fa-user mr-2"></i>owner</span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button class="btn float-right text-muted pt-0 pr-0">
                                                                            <i
                                                                                    class="fas fa-ban"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-body shadow-sm">
                                                                <p class="card-text"><?= $c['message'] ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body shadow-sm">
                        <h5 class="card-title">Do you want to help?</h5>
                        <a href="#" class="btn btn-secondary btn-block"><i class="fas fa-comments mr-2"></i>Go to
                            private
                            chat</a>
                        <p class="text-center my-0">or</p>
                        <a href="#" class="btn btn-success btn-block"><i class="fas fa-hands-helping mr-2"></i>Help to
                            solve</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Footer -->
<?php include_once 'templates/footer.php'; ?>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
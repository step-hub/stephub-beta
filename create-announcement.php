<?php
require "php/db.php";
include_once 'php/functions.php';

if (array_key_exists('logged_user', $_SESSION) and $_SESSION['logged_user']['user_status'] != 4) {
    $data = $_POST;
    $errors = array();

    if (isset($data['do_post'])) {
        if (trim($data['title']) == '') {
            $errors[] = 'заголовок не може бути порожнім';
        }
        if ($data['deadline'] == '') {
            $errors[] = 'повинен бути вказаний дедлайн';
        }
        if (strtotime($data['deadline']) < time()) {
            $errors[] = 'дедлайн не може бути попередньою датою';
        }
        if (trim($data['details']) == '') {
            $errors[] = 'деталі оголошення не можуть бути порожніми';
        }

        if (empty($errors)) {
            $announcement = R::dispense('announcements');
            $announcement->user_id = $_SESSION['logged_user']['id'];
            $announcement->title = $data['title'];
            $announcement->details = nl2br($data['details']);
            $announcement->deadline = strtotime($data['deadline']);
            $announcement->announcement_status_id = 2;
            $announcement->date = time();

            //attach file
            if (isset($_FILES['userfile'])) {
                $uploadName = basename($_FILES['userfile']['name']);
                $uploadFile = get_upload_path() . $uploadName;
                echo "<script> alert(" . $uploadName . ");</script>";
                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {
                    $announcement->file = "" . $uploadName;
                } else {
                    $errors[] = "file error";
                }
            }

            R::store($announcement);

            header('location: announcement.php?id=' . $announcement->id);
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

    <title>Розмістити Оголошення | StepHub</title>

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

<body class="text-center">
    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Page Content -->
    <div class="container pt-5">
        <?php if ($errors) : ?>
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <?= @$errors[0]; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="card mt-0">
            <form enctype="multipart/form-data" class="form-group mb-0" action="create-announcement.php" method="POST">
                <div class="card-header diagonal-gradient-gray my-color-dark border-bottom-0">
                    <div class="container">
                        <div class="row pt-2 pb-2">
                            <input type="text" name="title" value="<?= @$data['title'] ?>" class="form-control form-control-lg my-bg-light my-color-dark" placeholder="Заголовок">
                        </div>
                        <div class="row pt-2 px-2">
                            <p class="card-text text-muted ml-2 mt-1"><i class="far fa-calendar-times mr-2"></i></p>
                            <label class="card-text text-muted mr-2 mt-1" for="deadline_time">Потрібно до: </label>
                            <p class="card-text text-muted small mb-2 mr-0"><input class="form-control form-control-sm my-bg-light text-muted" type="date" id="deadline_time" name="deadline" value="<?= @$data['deadline'] ?>"></p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <textarea name="details" cols="30" rows="10" class="form-control" value="<?= @$data['details'] ?>" placeholder="Деталі оголошення"></textarea>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Upload file -->
                            <div class="input-group mt-2">
                                <div class="custom-file">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
                                    <input type="file" name="userfile" class="custom-file-input" id="fileGroup" aria-describedby="fileAddon">
                                    <label class="custom-file-label" for="fileGroup">Оберіть файл</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <button type="submit" name="do_post" class="btn my-btn-dark mt-1 mb-2 ml-auto mr-3">Сворити оголошення</button>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
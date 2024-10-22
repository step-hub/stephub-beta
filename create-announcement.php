<?php
require "php/db.php";
include_once 'php/functions.php';

if (array_key_exists('logged_user', $_SESSION) and $_SESSION['logged_user']['user_status'] != 4) {
    $data = $_POST;
    $errors = array();

    if (isset($data['do_post'])) {
        if (trim($data['title']) == '') {
            $errors[] = 'Вкажіть загловок оголошення';
        }
        if ($data['deadline'] == '') {
            $errors[] = 'Встановіть дедлайн оголошення';
        }
        if (strtotime($data['deadline']) < time()) {
            $errors[] = 'Дедлайн не може бути попередньою датою';
        }
        if (trim($data['details']) == '') {
            $errors[] = 'Вкажіть деталі оголошення';
        }

        if (empty($errors)) {
            $announcement = R::dispense('announcements');
            $announcement->user_id = $_SESSION['logged_user']['id'];
            $announcement->title = $data['title'];
            $announcement->details = nl2br($data['details']);
            $announcement->deadline = strtotime($data['deadline']);
            $announcement->announcement_status_id = 2;
            $announcement->date = time();
            R::store($announcement);

            // Attach file
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $location = get_upload_path($announcement->id);
                console_log($location);

                // Create directory if it does not exist
                if (!is_dir($location)) {
                    mkdir($location,  0755);
                }

                $uploadName = basename($_FILES['userfile']['name']);
                $uploadFile = $location . $uploadName;
                console_log($uploadName);
                console_log($uploadFile);
                console_log($_FILES['userfile']['tmp_name']);

                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {
                    update_file($announcement->id, $uploadName);
                    header('location: announcement.php?id=' . $announcement->id);
                } else {
                    $errors[] = "Не вдалось завантажити файл";
                }
            } else {
                header('location: announcement.php?id=' . $announcement->id);
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
    <!-- Preloader -->
    <?php include_once 'templates/preloader.html'; ?>

    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Errors -->
    <?php include_once "templates/errors.php"; ?>

    <!-- Page Content -->
    <div class="container pt-0 pt-md-5 px-0 px-md-3">
        <div class="card mt-0 shadow-sm border-xs-0">
            <form enctype="multipart/form-data" class="form-group mb-0" action="create-announcement.php" method="POST">
                <div class="card-header diagonal-gradient-gray my-color-dark border-bottom-0 border-xs-0 px-2 px-md-3">
                    <div class="container">
                        <div class="row pb-2 pt-sm-2">
                            <input type="text" name="title" value="<?= @$data['title'] ?>" class="form-control form-control-lg my-bg-light my-color-dark" placeholder="Заголовок">
                        </div>
                        <div class="row pt-2 px-2">
                            <p class="card-text text-muted ml-2 mt-1"><i class="far fa-calendar-times mr-2"></i></p>
                            <label class="card-text text-muted mr-2 mt-1" for="deadline_time">Потрібно до: </label>
                            <p class="card-text text-muted small mb-2 mr-0"><input class="form-control form-control-sm my-bg-light text-muted" type="date" id="deadline_time" name="deadline" value="<?= @$data['deadline'] ?>"></p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2 p-md-3">
                    <textarea name="details" cols="30" rows="10" class="form-control" value="<?= @$data['details'] ?>" placeholder="Деталі оголошення"></textarea>
                </div>
                <div class="card-footer p-2 p-md-3">
                    <div class="container">
                        <div class="row">
                            <!-- Upload file -->
                            <label for="fileUpload" class="file-upload btn btn-xs-block my-btn-blue mb-3 mb-sm-0 clickable">
                                <i class="material-icons mr-2">attach_file</i>Прикріпити файл
                                <input id="fileUpload" type="file" name="userfile">
                            </label>
                            <label for="fileUpload" class="fileUploadName small my-auto ml-0 ml-md-3 mx-auto">Файл не вибрано</label>
                            <button type="submit" name="do_post" class="btn btn-xs-block my-3 my-sm-0 my-btn-dark ml-sm-auto">Сворити оголошення</button>
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

    <!-- Main sctipt -->
    <script src="js/script.js"></script>
    <!-- Upload file sctipt -->
    <script src="js/file.js"></script>

</body>

</html>
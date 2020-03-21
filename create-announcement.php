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

            // attach file
            if(isset($_FILES['userfile'])) {
                $uploadName = basename($_FILES['userfile']['name']);
                $uploadFile = get_upload_path() . $uploadName;
                echo "<script> alert(".$uploadName.");</script>";
                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {
                    $announcement->file = "".$uploadName;
                } else {
                    $errors[] = "file error";
                }
            }

            R::store($announcement);

            //header('location: announcement.php?id='.$announcement->id);
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

    <title>StepHub | Створити оголошення</title>

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
<?php if (array_key_exists('logged_user', $_SESSION) and $_SESSION['logged_user']['user_status'] != 4): ?>
    <div class="container pt-5">
        <h2>Створити нове оголошення</h2>
        <div class="card mt-0">
            <?php show_apache_owner(); if ($errors): ?>
                <p class="mt-0 mb-0 font-weight-bold text-danger"><?= @$errors[0]; ?></>
            <?php endif; ?>
            <div class="card-body shadow-sm">
                <form enctype="multipart/form-data" class="form-group" action="create-announcement.php" method="POST" >
                    <input type="text" name="title" value="<?= @$data['title']?>" class="form-control mb-2 mr-sm-2" placeholder="Заголовок">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="deadline_time">Потрібно до</label>
                            <input class="form-control" type="date" id="deadline_time" name="deadline" value="<?= @$data['deadline']?>">
                        </div>
                        <div class="col-md-8">
                            <textarea name="details" value="<?= @$data['details']?>" rows="10" class="form-control mb-2 mr-sm-2" placeholder="Деталі оголошення"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Upload file -->
                        <div class="input-group mt-2">
                            <div class="custom-file">
                                <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
                                <input type="file" name="userfile" class="custom-file-input" id="fileGroup" aria-describedby="fileAddon">
                                <label class="custom-file-label" for="fileGroup">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit" name="do_post" id="fileAddon">Upload<i class="ml-2 fas fa-upload"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <button type="submit" name="do_post" class="btn btn-success mt-1 mb-2">Сворити оголошення
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php else:
        header("location: index.php");
    endif;?>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
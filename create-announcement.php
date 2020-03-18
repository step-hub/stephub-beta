<?php
require "php/db.php";
include_once 'php/functions.php';
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
<div class="container pt-5">
    <h2>Створити нове оголошення</h2>
    <div class="card mt-0">
        <div class="card-body shadow-sm">
            <form class="form-group" action="create-announcement.php" method="POST">
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Заголовок">
                <div class="row">
                    <div class="col-md-4">
                        <label for="qw">Потрібно до</label>
                        <input class="form-control" type="date" id="qw">
                    </div>
                    <div class="col-md-8">
                        <textarea rows="10" class="form-control mb-2 mr-sm-2"
                                  placeholder="Деталі оголошення"></textarea>
                    </div>
                </div>
                <div class="row">
                    <input type="file">
                </div>
                <div class="row justify-content-center">
                    <button type="submit" name=""
                            class="btn btn-success mt-1 mb-2">Сворити оголошення
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include_once 'templates/footer.php'; ?>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
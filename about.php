<?php
require "php/db.php";
include_once 'php/functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>StepHub | About</title>

    <link rel="shortcut icon" href="favicon.png">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC&display=swap" rel="stylesheet">
</head>

<body class="text-center">
    <!-- Navigation -->
    <?php include_once 'templates/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container text-center">
        <div class="card mt-5">
            <div class="card-body shadow-sm">
                This is some text within a card body.
                <div class="card mt-5">
                    <div class="card-header">
                        Filter
                    </div>
                    <div class="card-body shadow-sm">
                        This is some text within a card body.
                    </div>
                </div>
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
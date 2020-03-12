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

    <title>StepHub</title>

    <link rel="shortcut icon" href="favicon.png">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC&display=swap" rel="stylesheet">
</head>

<body class="text-center bg-light">
    <!-- Navigation -->
    <?php include_once 'templates/navigation.php'; ?>

    <!-- Page Content -->


    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">.
                <div class="card">
                    <div class="card-header">
                        Filter
                    </div>
                    <div class="card-body shadow-sm">
                        This is some text within a card body.
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body shadow-sm">

                        <div class="card text-left mb-3">
                            <div class="card-body shadow-sm">
                                <h5 class="card-title">ASddfghd</h5>
                                <div class="row">
                                    <div class="col">
                                        <p class="card-text mb-4">text khgjfdsasduiopoiuytfdfhjklkjh</p>
                                        <p class="card-text text-muted small"><span class="my_label mr-3"></span><i class="far fa-calendar mr-2"></i>nbvcx</p>
                                    </div>
                                    <div class="col align-self-end">
                                        <a href="#" class="btn btn-primary float-right">asfghvc</a>
                                    </div>
                                </div>
                            </div>
                        </div>

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
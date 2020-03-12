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

<body class="text-center bg-light">
    <!-- Navigation -->
    <?php include_once 'templates/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">
        <div class="card mt-5">
            <div class="card-body shadow-sm">
                <h5 class="card-title ">About StepHub</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab accusantium aspernatur atque aut autem consectetur culpa dolores ea eligendi fugit illo laborum nostrum omnis optio perferendis quod reiciendis sequi soluta, tempore. Ab ad culpa, excepturi exercitationem iste nisi quaerat quam quibusdam voluptate. Deserunt ipsa, iusto molestiae praesentium quia voluptatibus.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto commodi earum laboriosam natus neque quo repellat saepe similique voluptate!</p>

                <div class="mt-5">
                    <!--Email-->
                    <a class="btn-floating btn-lg btn-email" type="button" role="button"><i class="fas fa-envelope"></i></a>
                    <!--Github-->
                    <a class="btn-floating btn-lg btn-git" type="button" role="button"><i class="fab fa-github"></i></a>
                    <!--Facebook-->
                    <a class="btn-floating btn-lg btn-fb" type="button" role="button"><i class="fab fa-facebook-f"></i></a>
                    <!--Linkedin-->
                    <a class="btn-floating btn-lg btn-li" type="button" role="button"><i class="fab fa-linkedin-in"></i></a>
                    <!--Instagram-->
                    <a class="btn-floating btn-lg btn-ins" type="button" role="button"><i class="fab fa-instagram"></i></a>
                </div>
                <p class="small text-muted mb-3">Copyright © 2020 StepHub</p>
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
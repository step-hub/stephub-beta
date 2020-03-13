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

    <title>StepHub | Admin Panel</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
</head>

<body class="text-center bg-light">
    <!-- Navigation -->
    <?php include_once 'templates/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">
        <div class="card mt-5">
            <div class="card-body shadow-sm">
                <h5 class="card-title ">Admin Panel</h5>
                <?php if ( $_SESSION['logged_user']->user_status == 1): ?>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto dolores ea et ex explicabo, fugiat in, ipsam iure magnam natus nihil quibusdam ratione? Asperiores iusto nihil non reiciendis sequi. Animi asperiores atque autem consectetur cumque dignissimos dolor, dolorem eum explicabo, harum impedit incidunt iste laborum non numquam officia perspiciatis praesentium quis saepe voluptatibus! Accusamus dolor excepturi exercitationem hic, laudantium magnam maxime pariatur repellendus totam voluptates. A ab accusantium consequuntur culpa dolor dolore doloremque eaque earum, esse est facere fuga fugiat fugit id, illum ipsam iste itaque numquam quas quo repellat temporibus voluptatibus. Beatae commodi debitis dolores harum obcaecati reprehenderit voluptate?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A amet at dolore eos facilis molestias nesciunt non numquam voluptate voluptatem.</p>
                <?php else: ?>
                    <div class="card border-danger">
                        <div class="card-body shadow-sm">
                            <h5 class="card-title mb-0 text-center text-danger card-danger"><i class="fas fa-exclamation-circle mr-3"></i>You don't have permissions</h5>
                        </div>
                    </div>
                <?php endif; ?>
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
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

<body class="text-center">
    <!-- Navigation -->
    <?php include_once 'templates/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">
        <h1>Home page</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab, ad alias aliquam architecto assumenda consectetur delectus dolorem dolores eos facilis fuga, fugiat harum hic impedit in inventore ipsa ipsum itaque labore libero minima minus molestiae neque pariatur quaerat quibusdam quisquam ratione recusandae, rem sapiente soluta ullam unde velit voluptates voluptatibus voluptatum? Deleniti doloribus hic nihil perspiciatis. A amet aspernatur cumque dicta, distinctio fugiat inventore molestiae nam, nihil numquam odio omnis ut veniam? A, animi consequatur dignissimos dolorem eum id ipsum magni perferendis sed voluptatum. Accusantium assumenda eaque earum molestiae molestias, nam, nemo nostrum obcaecati omnis, quam sunt voluptatem voluptatibus!</p>
    </div>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
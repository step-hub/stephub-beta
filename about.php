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

    <title>StepHub | Про StepHub</title>

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
    <div class="container">
        <div class="card mt-5">
            <div class="card-body shadow-sm">
                <h5 class="card-title text-center">Про StepHub</h5>

                <h5>Що ми робимо</h5>
                <p><strong>StepHub</strong> - онлайн сервіс анонімного пошуку допомоги для вирішення різноманітних задач. Майданчик об'єднує замовників послуг, яким необхідно допомогти з вирішенням завдання, і людей готових допомогти.</p>
                <h5>Наша Команда</h5>
                <p>Над проектом <strong>StepHub</strong> працює молода та амбіційна команда. Всі ми - різні. Кожен з нас займається своєю роботою. Ми любимо різну піцу і дивимося різні фільми. Ми виросли в різних містах і в різний час, але все стикалися з однією і тією ж проблемою - де анонімно знайти допомогу. Нас всіх об'єднує бажання виправити цю ситуацію. Щоб ніхто не засуджував людей за те, що вони чогось не знають.</p>
                <h5>Наша Місія</h5>
                <p>Ми хочемо допомогти вирішити будь-яке завдання і зробити це анонімно. Ми хочемо навчити людей допомагати і просити допомоги. Це наша головна місія і думка, з якою ми прокидаємося щоранку.</p>
                <p>Якщо ви також поділяєте ці цінності і підтримуєте наше прагнення зробити наш університет кращим - приєднуйтесь до нашої дружної сім'ї однодумців.</p>

                <div class="mt-5 text-center">
                    <!--Email-->
                    <a class="btn-floating btn-lg btn-email" type="button" role="button"><i class="fas fa-envelope"></i></a>
                    <!--Github-->
                    <a class="btn-floating btn-lg btn-git" type="button" role="button"><i class="fab fa-github"></i></a>
                </div>
                <p class="small text-muted text-center mb-3">Copyright © 2020 StepHub</p>
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
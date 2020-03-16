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

<body class="text-center">
    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Page Content -->
    <div class="container">
        <div class="card mt-5">
            <h3 class="card-body shadow-sm"> <!--About StepHub-->
                <div class="card-title">Про StepHub</div>

                <h5>Що ми робимо</h5>
                <p>StepHub - онлайн сервіс пошуку фахівців для вирішення побутових і професійних задач. Майданчик об'єднує замовників послуг, яким необхідно виконати будь-яку роботу, і компетентних фахівців, які шукають підробіток або додатковий заробіток.</p>

                <h5>Наша Команда</h5>
                <p>Над проектом StepHub працює молода та амбіційна команда. Всі ми - різні. Кожен з нас займається своєю роботою. Ми любимо різну піцу і дивимося різні фільми. Ми виросли в різних містах і в різний час, але все стикалися з однією і тією ж проблемою - жахливим сервісом в сфері послуг. Нас всіх об'єднує бажання виправити цю ситуацію. Щоб пошук потрібного фахівця займав всього кілька хвилин. Щоб недобросовісні фахівці не залишалися безкарними. Щоб замовники ніколи "не забували" заплатити за якісно виконану роботу.</p>

                <h5>Наша Місія</h5>
                <p>Ми хочемо допомогти вирішити будь-яке завдання і звільнити вам час для сім'ї або друзів. Ми хочемо дати роботу компетентним і відповідальним фахівцям і розвивати підприємництво в головах студентів. Це наша головна місія і думка, з якою ми прокидаємося щоранку.</p>
                <p>Якщо ви також поділяєте ці цінності і підтримуєте наше прагнення зробити наш університет кращим - приєднуйтесь до нашої дружної сім'ї однодумців.</p>

                <div class="mt-5">
                    <!--Email-->
                    <a class="btn-floating btn-lg btn-email" type="button" role="button"><i class="fas fa-envelope"></i></a>
                    <!--Github-->
                    <a class="btn-floating btn-lg btn-git" type="button" role="button"><i class="fab fa-github"></i></a>
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
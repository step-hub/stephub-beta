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

    <title>Про Нас | StepHub</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">

    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="css/about.css" rel="stylesheet">
</head>

<body data-spy="scroll" data-target="#navbar_about" data-offset="0" style="background-color: white">
    <!-- Preloader -->
    <?php include_once 'templates/preloader.html'; ?>

    <!-- Back to top button -->
    <a id="back-to-top-button"></a>

    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Page Content -->
    <div class="container-fluid p-3">
        <div class="row">
            <div class="col-lg-2 mb-3">
                <div class="sticky-top anchor">
                    <nav id="navbar_about" class="navbar bg-light shadow-sm border small px-1">
                        <nav class="nav nav-pills flex-column">
                            <a class="nav-link my-color-blue" href="#about"><span class="material-icons mr-2">group</span>Про Нас</a>
                            <nav class="nav nav-pills flex-column">
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-1-1">Проблема</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-1-2">Ідея</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-1-3">Реалізація</a>
                            </nav>
                            <a class="nav-link my-color-blue" href="#terms"><span class="material-icons mr-2">gavel</span>Правила користування</a>
                            <nav class="nav nav-pills flex-column">
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-1">Терміни та визначення</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-2">Основні положення</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-3">Права та обов'язки сторін</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-4">Порядок розгляду спорів та відповідальність сторін</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-5">Персональні дані</a>
                            </nav>
                            <a class="nav-link my-color-blue" href="#privacy"><span class="material-icons mr-2">security</span>Політика конфіденційності</a>
                            <nav class="nav nav-pills flex-column">
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-1">Визначення понять</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-2">Загальні положення</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-3">Повідомлення</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-4">Зобов'язання</a>
                                <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-5">Прикінцеві положення</a>
                            </nav>
                        </nav>
                    </nav>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="card mb-5">
                    <div class="card-header text-center">
                        <h3 id="about" class="anchor">Про Нас</h3>
                    </div>
                    <div class="card-body">
                        <h4 id="item-1-1" class="anchor">Проблема</h4>
                        <p>Проблемою, яку наша команда поставила перед собою для вирішення, є зрозуміти рівень довіри студентів один до одного.</p>
                        <p>Для знаходження рішення цієї проблеми можна виділити два найбільш вагомі питання на які варто було шукати відповідь: як саме можна визначити рівень довіри; чим має бути проєкт, щоб був цікавим і водночас по можливості приносив користь його користувачам.</p>
                        
                        <h4 id="item-1-2" class="anchor">Ідея</h4>
                        <p>З тих ідей, що придумала наша команда, було вибрано сервіс, котрий дає можливість студенту анонімно розмістити оголошення про свої певні необхідності, які наразі не можуть бути вирішені ним самим. Це допоможе у пошуку іншого студента всередині університету, який би зміг допомогти з цим питанням. Перевагою користуванням даного сервісу є комфортність у психологічному плані. Це означає, що автор оголошення може уникнути дискомфорту під час публікації оголошення за рахунок того, що ніхто не знає, хто саме є автором. Таким чином, це дає можливість мінімізувати кількість студентів, котрі безпосередньо будуть знати про описану в оголошенні проблему. В додаток до цього, під час реєстрації на сайті повинен бути вказаний номер студентського квитка. Це дає гарантію того, що викладачі не будуть мати змоги користуватися сервісом, що створює також свій певний комфорт для студентів.</p>
                        <p>Як побічний ефект можна очікувати покращення рівню “дружності” між студентами всередині університету. Це може бути спричинено такими факторами як, наприклад, відчуття обов’язку перед тим, хто допоміг вирішити питання, або усвідомлення того, що можливо у майбутньому користувач буде у тій самій ситуації, що і автор оголошення.</p>
                        
                        <h4 id="item-1-3" class="anchor">Реалізація</h4>
                        <p>Алгоритм, за яким реалізовано дану ідею наступний:</p>
                        <ul>
                            <li>Автор розміщує оголошення</li>
                            <li>Всі крім автора можуть погодитися на допомогу у вирішенні порушеної в оголошенні проблеми</li>
                            <li>Автор оголошення повинен погодитися на надання допомоги, або відхилити її</li>
                            <li>Якщо автор погодився, то система за допомогою електронної пошти надсилає йому контакти того, хто погодився допомогти</li>
                            <li>Автор оголошення вже має можливість зв’язатися з тим, хто вирішив допомогти, тому оголошення переводиться у інший стан, щоб було невидимим для користувачів, які не беруть участь у вирішенні проблеми</li>
                            <li>У разі успішного вирішення проблеми автор видаляє оголошення; якщо проблема все ще актуальна, оголошення можна знову перевести у активний стан, при цьому система автоматично видаляє інформацію про того, хто вже намагався допомогти (тобто, відкривається можливість для інших)</li>
                        </ul>
                        
                    </div>
                </div>

                <div class="card mb-5">
                    <div class="card-header text-center">
                        <h3 id="terms" class="anchor">Правила користування сервісом StepHub</h3>
                    </div>
                    <div class="card-body">
                        <p>Сторінка знаходиться на стадії розробки.</p>
                       
                        <h4 id="item-2-1" class="anchor">Терміни та визначення</h4>
                        <p>...</p>
                        
                        <h4 id="item-2-2" class="anchor">Основні положення</h4>
                        <p>...</p>

                        <h4 id="item-2-3" class="anchor">Права та обов'язки сторін</h4>
                        <p>...</p>

                        <h4 id="item-2-4" class="anchor">Порядок розгляду спорів та відповідальність сторін</h4>
                        <p>...</p>

                        <h4 id="item-2-5" class="anchor">Персональні дані</h4>
                        <p>...</p>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header text-center">
                        <h3 id="privacy" class="anchor">Політика конфіденційності</h3>
                    </div>
                    <div class="card-body">
                        <p>Сторінка знаходиться на стадії розробки.</p>

                        <h4 id="item-3-1" class="anchor">Визначення понять</h4>
                        <p>...</p>

                        <h4 id="item-3-2" class="anchor">Загальні положення</h4>
                        <p>...</p>

                        <h4 id="item-3-3" class="anchor">Повідомлення</h4>
                        <p>...</p>

                        <h4 id="item-3-4" class="anchor">Зобов'язання</h4>
                        <p>...</p>

                        <h4 id="item-3-5" class="anchor">Прикінцеві положення</h4>
                        <p>...</p>

                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 text-center">
            <!--Email-->
            <a class="btn-floating btn-lg" type="button" role="button" href="mailto:stephub.com@gmail.com" style="color: black;"><i class="fas fa-envelope"></i></a>
            <!--Github-->
            <a class="btn-floating btn-lg" type="button" role="button" href="https://github.com/step-hub/stephub" style="color: black;"><i class="fab fa-github"></i></a>
        </div>
        <p class="small text-muted text-center mb-3">Copyright © 2020 StepHub</p>
    </div>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Main sctipt -->
    <script src="js/script.js"></script>
    <!-- Back to top button -->
    <script src="js/top.js"></script>
</body>

</html>
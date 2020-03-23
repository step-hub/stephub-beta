<?php
require "php/db.php";
include_once "php/functions.php";

if (!array_key_exists('logged_user',$_SESSION)) {
    $data = $_POST;
    $errors = array();

    if (isset($data['do_signup'])) {
        if (trim($data['login']) == '') {
            $errors[] = 'login field is empty!!!';
        }
        if (trim($data['email']) == '') {
            $errors[] = 'email field is empty!!!';
        }
        if (trim($data['stud_num_series']) == '') {
            $errors[] = 'stud_num_ser field is empty!!!';
        }
        if (trim($data['stud_num_number']) == '') {
            $errors[] = 'stud_num_num field is empty!!!';
        }
        if (trim($data['telegram']) == '') {
            $errors[] = 'telegram field is empty!!!';
        }
        if ($data['password'] == '') {
            $errors[] = 'password field is empty!!!';
        }

        if ($data['password_confirmation'] != $data['password']) {
            $errors[] = "password does doesn't confirm!!!";
        }

        if (count_users_by_login($data['login']) > 0) {
            $errors[] = "user with such login already exist!!!";
        }
        if (count_users_by_email($data['email']) > 0) {
            $errors[] = "user with such email already exist!!!";
        }
        if (count_users_by_telegram($data['telegram']) > 0) {
            $errors[] = "user with such telegram already exist!!!";
        }

        if (count_studentid_by_num($data['stud_num_series'].$data['stud_num_number']) == 0) {
            $errors[] = "user with such student num can't register!!!";
        } else {
            $studentid = find_studentid_by_num($data['stud_num_series'].$data['stud_num_number']);
            if (count_users_by_student_id($studentid->id) > 0) {
                $errors[] = "user with such student num has already registered!!!";
            }
        }

        if (empty($errors)) {
            $user = R::dispense('users');
            $user->login = $data['login'];
            $user->email = $data['email'];
            $user->studentid_id = $studentid->id;
            $user->telegram_username = $data['telegram'];
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $user->is_online = 1;
            $user->user_status = 3;
            $user->reg_date = time();

            R::store($user);

            header('location: index.php');
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

    <title>Реєстрація | StepHub</title>

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

    <?php if (array_key_exists('logged_user', $_SESSION)):
        header("location: index.php"); ?>
    <?php else: ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row pt-3">
            <div class="col-md-7">
                <h1 class="h3 mb-3 font-weight-normal">Створити новий акаунт</h1>

                <?php if ($errors): ?>
                    <p class="mt-0 mb-0 font-weight-bold text-danger"><?= @$errors[0]; ?></>
                <?php endif; ?>

                <form class="form" action="registration.php" method="POST">
                    <div class="form-group row px-3">
                        <label class="col-sm-3 col-form-label" for="inputLogin">Ім'я користувача</label>
                        <div class="col-sm-9">
                            <input name="login" class="form-control" type="text" id="inputLogin" value="<?= @$data['login']; ?>" placeholder="Ім'я користувача" required autofocus aria-describedby="loginHelp">
                            <small id="loginHelp" class="form-text text-muted">
                                Ваш логін може складитись із латинських літер та цифр.
                            </small>
                        </div>
                    </div>
                    <div class="form-group row px-3">
                        <label class="col-sm-3 col-form-label" for="inputEmail">Ел. пошта</label>
                        <div class="col-sm-9">
                            <input name="email" class="form-control" type="email" id="inputEmail" value="<?= @$data['email']; ?>" placeholder="example@gmail.com" required>
                        </div>
                    </div>
                    <div class="form-group row px-3">
                        <label class="col-sm-3 col-form-label" for="inputStudNum">Студентський</label>
                        <div class="input-group col-sm-5" id="inputStudNum">
                            <input name="stud_num_series" class="form-control col-3 mx-0" type="text" value="<?= @$data['stud_num_ser']; ?>" placeholder="АБ" required>
                            <div class="input-group-text" style="border-top-left-radius: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; border-bottom-left-radius: 0;">№</div>
                            <input name="stud_num_number" class="form-control col-5 mx-0" type="text" value="<?= @$data['stud_num_num']; ?>" placeholder="12345678" required>
                        </div>
                        <div class="col-sm-4 pl-0">
                            <button type="button" class="btn float-left myPopover" data-toggle="popover" data-placement="right" title="Де взяти номер студентського квитка?" data-trigger="hower" data-content="Серію і номер студентського квитка можна дізнатися на лицевій стороні вашого студентського квитка">
                                <i class="fa fa-info-circle text-muted"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row px-3">
                        <label class="col-sm-3 col-form-label" for="inputTelegram">Телеграм</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                </div>
                                <input name="telegram" class="form-control" type="text" id="inputTelegram" value="<?= @$data['telegram']; ?>" placeholder="example" required>
                            </div>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>

                    <div class="card">
                        <div class="card-body my-bg-light px-0">
                            <div class="form-group row px-3">
                                <label class="col-sm-3 col-form-label" for="inputPassword">Пароль</label>
                                <div class="col-sm-9">
                                    <input name="password" class="form-control" type="password" id="inputPassword" placeholder="Пароль" required aria-describedby="passHelp">
                                    <small id="passHelp" class="form-text text-muted">
                                        Ваш пароль має бути довжиною 8-20 символів, може містити літери та цифри, і не може містити пробіли, спеціальні символи, або емоджі.
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row px-3">
                                <label class="col-sm-3 col-form-label" for="inputPasswordConfirm">Підтвердження</label>
                                <div class="col-sm-9">
                                    <input name="password_confirmation" class="form-control" type="password" id="inputPasswordConfirm" placeholder="Повторіть пароль" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkbox mt-3 mb-0">
                        <label>
                            <input type="checkbox" value="remember-me" name="remember">
                            <small>Я підтверджую, що ознайомився(лась) із <a href="#" data-toggle="collapse" data-target="#collapseTwo">правилами користування</a> сайтом і <a href="#" data-toggle="collapse" data-target="#collapseThree">політикою конфіденційності</a></small>
                        </label>
                    </div>

                    <small class="mt-2 mx-3 float-left">Вже маєте зареєстрований акаунт? <a href="index.php">Ввійти</a></small>
                    <button class="btn my-btn-blue float-right" type="submit" name="do_signup">Зареєструвати</button>
                </form>
            </div>
            <div class="col-md-5">

                <div class="accordion" id="idAccordion">
                    <div class="card ">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Для чого нам ці дані?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#idAccordion">
                            <div class="card-body text-left small">
                                <p><strong>Ім'я користувача (логін)</strong> - використовується тільки для зручності авторизації, ми не поширюємо його для забезпечення повної анонімності.</p>
                                <p><strong>Адреса ел. пошти</strong> - використовуємо, щоб повідомляти вас про важливі оновленняі та сповіщенняі. Поширюємо лише при згоді обох користувачів для подальшого вирішення проблеми.</p>
                                <p><strong>Номер студентського квитка</strong> - для ідентифікації, чи є ви студентом вищого навчального закладу "ІТ СТЕП Університет". Не поширюється.</p>
                                <p><strong>Логін телеграму</strong> - використовуємо лише для зручнішого зв'язку з вами іншим користувачам, і лише за згоди обох учасників.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Правила користування сервісом
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#idAccordion">
                            <div class="card-body text-left small">
                                <ol class="pl-2">
                                    <li><h6>Загальні положення</h6>
                                        <ol class="pl-4">
                                            <li>Метою отримання і обробки Отримуючою стороною конфіденційної інформації і персональних даних є:
                                                <ul class="pl-4">
                                                    <li>надання Передавальній стороні доступу до можливостей Сервісу, інформації і матеріалів, розміщених на Сайті;</li>
                                                    <li>організація комунікації між Сторонами</li>
                                                    <li>забезпечення успішної реалізації предмета Договору на виконання робіт/надання послуг, що укладається Замовниками та Виконавцями з використанням Сервісу</li>
                                                </ul>
                                            </li>
                                        </ol>
                                    </li>
                                    <li><h6>Повідомлення</h6>
                                        <ol class="pl-4">
                                            <li>
                                                Відвідувачі Сайту, що не реєструють обліковий запис, ознайомлені й згодні з тим, що
                                                сторона має право збирати про таких відвідувачів певну інформацію, в т. ч. URL і IP
                                                –адреси і т. д., які були переглянуті під час відвідування. Ця інформація
                                                використовується виключно для внутрішніх цілей і служить для поліпшення роботи
                                                Сервісу.
                                            </li>
                                            <li>
                                                Одержуюча сторона обробляє тільки ту конфіденційну інформацію та персональні
                                                дані, які необхідні для забезпечення якості надаваємих послуг і не використовує таку
                                                інформацію для інших цілей без згоди Передавальної сторони.
                                            </li>
                                            <li>
                                                Одержуюча Сторона зберігає конфіденційну інформацію та персональні дані до тих
                                                пір, поки це необхідно для обумовлених цілей у відповідності з чинним законодавством.
                                            </li>
                                            <li>
                                                Передавальній стороні надається безперешкодний доступ до належної їй
                                                конфіденційної інформації та персональних даних.
                                            </li>
                                            <li>
                                                Сторона не передає конфіденційну інформацію та персональні дані Передавальної
                                                сторони третім особам без згоди власників такої
                                                інформації, за винятком випадків, прямо передбачених законом.
                                            </li>
                                        </ol>
                                    </li>
                                </ol>
                                3. ЗОБОВ&#39;ЯЗАННЯ
                                3.1 Передавальна сторона зобов&#39;язується надати достовірну і повну інформацію.
                                3.2 Отримуюча сторона зобов&#39;язується:
                                 використовувати конфіденційну інформацію та персональні дані виключно в цілях
                                забезпечення працездатності Сервісу та реалізації предмета Договору на виконання
                                робіт/надання послуг;
                                 не розголошувати конфіденційну інформацію третім особам за винятком передбачених
                                законом випадків;
                                 не використовувати конфіденційну інформацію та персональні дані в інтересах, що
                                суперечать цілям, зазначеним у п. 1.1 Політики конфіденційності;
                                 максимально обмежити кількість працівників та інших осіб, які мають доступ до
                                конфіденційної інформації та персональних даних, забезпечивши при цьому отримання
                                від них письмових зобов&#39;язань про нерозголошення та невикористання в своїх або чужих
                                інтересах конфіденційної інформації та персональних даних Передавальної сторони.;
                                 негайно повідомляти Передавальну сторону про виявлені факти несанкціонованого
                                використання чи розголошення конфіденційної інформації та персональних даних,
                                організовуючи всі необхідні заходи для запобігання подальшого несанкціонованого
                                використання або розкриття такої інформації.;
                                 на вимогу сторони, яка Передає знищити отриману конфіденційну інформацію та
                                персональні дані.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Політика кофіденційності
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#idAccordion">
                            <div class="card-body small text-left">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <script src="js/script.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function(){
            $(".myPopover").popover();
        });
    </script>
</body>
</html>
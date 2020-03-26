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
    <link href="vendor/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="css/about.css" rel="stylesheet">
</head>

<body data-spy="scroll" data-target="#navbar_about" data-offset="0">
    <!-- Navigation -->
    <?php include_once 'templates/navbar.php'; ?>

    <!-- Page Content -->
    <div class="container">
        <div class="card mt-5">
            <div class="card-header my-bg-dark p-1"></div>
            <div class="card-body shadow-sm">
                <div class="row">
                    <div class="col-4">
                        <nav id="navbar_about" class="navbar bg-light shadow-sm">
                            <nav class="nav nav-pills flex-column">
                                <a class="nav-link my-color-blue" href="#about">Про Нас</a>
                                <nav class="nav nav-pills flex-column">
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-1-1">Що ми робимо?</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-1-2">Наша команда</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-1-3">Наша місія</a>
                                </nav>
                                <a class="nav-link my-color-blue" href="#terms">Правила користування</a>
                                <nav class="nav nav-pills flex-column">
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-1">Терміни та визначення</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-2">Основні положення</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-3">Права та обов'язки сторін</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-4">Порядок розгляду спорів та відповідальність сорін</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-2-5">Персональні дані</a>
                                </nav>
                                <a class="nav-link my-color-blue" href="#privacy">Політика конфіденційності</a>
                                <nav class="nav nav-pills flex-column">
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-1">Визначення понять</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-2">Загальні положення</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-5">Повідомлення</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-4">Зобов'язання</a>
                                    <a class="nav-link my-color-blue ml-3 my-1" href="#item-3-5">Прикінцеві положення</a>
                                </nav>
                            </nav>
                        </nav>
                    </div>
                    <div class="col-8">
                        <h3 id="about" class="anchor">Про Нас</h3>
                        <h4 id="item-1-1" class="anchor">Що ми робимо?</h4>
                        <p><strong>StepHub</strong> - онлайн сервіс анонімного пошуку допомоги для вирішення різноманітних задач. Майданчик об'єднує замовників послуг, яким необхідно допомогти з вирішенням завдання, і людей готових допомогти.</p>
                        <h4 id="item-1-2" class="anchor">Наша команда</h4>
                        <p>Над проектом <strong>StepHub</strong> працює молода та амбіційна команда. Всі ми - різні. Кожен з нас займається своєю роботою. Ми любимо різну піцу і дивимося різні фільми. Ми виросли в різних містах і в різний час, але все стикалися з однією і тією ж проблемою - де анонімно знайти допомогу. Нас всіх об'єднує бажання виправити цю ситуацію. Щоб ніхто не засуджував людей за те, що вони чогось не знають.</p>
                        <h4 id="item-1-3" class="anchor">Наша місія</h4>
                        <p>Ми хочемо допомогти вирішити будь-яке завдання і зробити це анонімно. Ми хочемо навчити людей допомагати і просити допомоги. Це наша головна місія і думка, з якою ми прокидаємося щоранку.</p>
                        <p>Якщо ви також поділяєте ці цінності і підтримуєте наше прагнення зробити наш університет кращим - приєднуйтесь до нашої дружної сім'ї однодумців.</p>

                        <h3 id="terms" class="anchor pt-5 mt-5">Правила користування сервісом StepHub</h3>
                        <p>Якщо Ви не згодні з даною Угодою або з окремими її пунктами, Ви вправі відмовитися від використання сайту StepHub (далі просто Сервісу).</p>
                        <p>Дана Угода вступає в силу з моменту відсилання Вами заповненої реєстраційної форми.</p>
                        <p>Якщо Ви є користувачем Сервісу, це автоматично означає, що Ви приймаєте всі пункти цієї Угоди.</p>

                        <h4 id="item-2-1" class="anchor">Терміни та визначення</h4>
                        <p>Сервіс — сукупність програмних і апаратних засобів, об'єднаних простором доменного імені stephub.com, забезпечують взаємодію між Користувачами.</p>
                        <p>Користувач — фізична особа, яка здійснила реєстрацію в Сервісі у відповідності з умовами цієї Угоди.</p>
                        <p>Обліковий Запис — унікальне ім'я (логін) і пароль для доступу до персональних сторінок Користувача в рамках Сервісу.</p>
                        <p>Замовник — Користувач, що здійснює пошук Виконавців в рамках Сервісу.</p>
                        <p>Виконавець, Фрілансер — Користувач, який надає послуги виконання різного роду робіт, при цьому не вступаючи в якісь трудові правовідносини з Сервісом, та не є його співробітником.</p>

                        <h4 id="item-2-2" class="anchor">Основні положення</h4>
                        <ol class="anchor pl-0">
                            <li>Приймаючи дану Угоду, Користувач погоджується, приймає і зобов'язується беззаперечно дотримуватися всіх її умов, також, Користувач має право відмовитися від використання сайтуstephub.com (далі - Сервіс).</li>
                            <li>Ця угода та всі зміни до неї набирають чинності з моменту їх опублікування на Сервісі. Зміни в Угоду можуть бути внесені в будь-який час. Користувачі підтверджують, що при кожній повторній авторизації на Сервісі, вони ознайомлені і приймають умови Угоди, які опубліковані за адресою ….</li>
                            <li>Сервіс надає Користувачам послуги по доступу до функціональних можливостей Сервісу, без перерв, за винятком часу, для проведення необхідних ремонтних та регламентних робіт. Всі існуючі на даний момент сервіси, а також будь-який розвиток їх і/або додавання нових є предметом цієї Угоди. Користувачі розуміють і погоджуються з тим, що всі сервіси надаються за принципом "як є" (As is), і що Адміністрація не несе відповідальності за будь-які затримки, збої, невірну або невчасну доставку, видалення або незбереження будь-якої персональної інформації.</li>
                        </ol>

                        <h4 id="item-2-3" class="anchor">Права та обов'язки сторін</h4>
                        <ol class="pl-0">
                            <li>Права та обов'язки Користувача
                                <ol>
                                    <li>Користувач несе відповідальність за достовірність і точність заповнення свого профілю, також всієї інформації, що розміщується ним на Сайті.</li>
                                    <li>На Сервісі заборонені:
                                        <ol>
                                            <li>Заклики до насильницької зміни чи повалення конституційного ладу або до захоплення державної влади; заклики до зміни адміністративних меж або державного кордону України, порушення порядку, встановленого Конституцією України; заклики до погромів, підпалів, знищення майна, захоплення будівель або споруд, насильницького виселення громадян; заклики до агресії або до розв'язування військового конфлікту.</li>
                                            <li>Нецензурні прямі й непрямі образи в чию-небудь сторону, в тому числі, засновані на етнічної, расової чи релігійної приналежності, а також висловлювання, що носять шовіністичний характер.</li>
                                            <li>Образлива поведінка та вирази по відношенню до Адміністрації та іншим користувачам Сервісу.</li>
                                            <li>Розміщення Користувачами замовлень та реклами:
                                                <ul>
                                                    <li>товарів і послуг, які порушують чинне законодавство України, та/або порушують право інтелектуальної власності Третіх осіб.</li>
                                                    <li>товарів і послуг, що не відповідають даній Угоді.</li>
                                                    <li>троянських програм, вірусів, інтернет-хробаків, програм для злому чи несанкціонованого доступу до інформації, а також інших "хакерських" програм, які можуть завдати шкоди програмному забезпеченню, та/або комплектуючим частинам інформаційних систем.</li>
                                                    <li>розсилки спаму, а також розробки програмного забезпечення для здійснення такого роду розсилок.</li>
                                                </ul>
                                            </li>
                                            <li>На Сервісі заборонена публікація наступної інформації:
                                                <ul>
                                                    <li>явної та прихованої реклами сторонніх сайтів, включаючи реферальні посилання та посилання на сайти аналогічної спрямованності.</li>
                                                    <li>реклами швидкого заробітку.</li>
                                                    <li>пов'язаної з шахрайськими схемами.</li>
                                                    <li>що містить нецензурну лексику.</li>
                                                    <li>що провокує конфлікти на політичній, релігійній або національній темі.</li>
                                                    <li>що порушує права законних правовласників.</li>
                                                    <li>нецільової розсилки рекламної інформації в особистих повідомленнях.</li>
                                                    <li>оголошень про продаж будь-яких товарів та послуг.</li>
                                                    <li>проектів або ставок з явно заниженим бюджетом або винагородою за виконання яких є тільки відгук.</li>
                                                    <li>проектів, що не відповідають спеціалізації сервісу.</li>
                                                    <li>проектів, завершених ретроспективно і відкритих з метою збільшення рейтингу.</li>
                                                    <li>проектів, які передбачають виконання неоплачуваних тестових завдань, які відрізняються для різних виконавців.</li>
                                                    <li>проектів, які мають на увазі написання або розміщення відгуків про продукти, послуги або сервіси.</li>
                                                    <li>проектів, які передбачають купівлю лайків або репостів в соціальних мережах.</li>
                                                    <li>проектів, які передбачають пошук спонсорів для проведення акцій, розіграшів або подібних заходів.</li>
                                                    <li>проектів, створених з метою збору контактних даних виконавців.</li>
                                                    <li>проектів, створених з метою залучення в MLM і пірамідні схеми.</li>
                                                    <li>проектів, завдання до яких отримано в іншому проєкті, вже розміщеного на сервісі (посередництво).</li>
                                                    <li>проектів, пов'язаних з купівлею, продажем або орендою облікових записів на сторонніх сервісах.</li>
                                                    <li>проектів, пов'язаних із проходженням тестування за іншого користувача на сторонніх сервісах.</li>
                                                    <li>проектів, пов'язаних з написанням текстів на медичну тематику.</li>
                                                    <li>проектів, пов'язаних з короновірусом (COVID-19) (включаючи, але не обмежуючись, написанням статей про методики захисту і розробкою сайтів з продажу масок).</li>
                                                    <li>проектів, опис яких містить контактну інформацію замовника.</li>
                                                    <li>ставок, текст яких містить суму, відмінну від значення, зазначеного в полі вартості роботи.</li>
                                                    <li>ставок, текст яких містить прямі контактні дані користувача.</li>
                                                    <li>проектів, опис яких містить вимогу (прохання) надати контактні дані.</li>
                                                    <li>контактних даних на публічній сторінці профілю, а також посилань на сторонні сайти, основним вмістом яких є контактна інформація.</li>
                                                </ul>
                                            </li>
                                            <li>Будь-які дії, які прямо заборонені законодавством України.</li>
                                        </ol>
                                    </li>
                                    <li>Користувач має право надати на розгляд Адміністрації свої побажання чи пропозиції щодо покращення роботи Сайту.</li>
                                    <li>Користувачі визнають та погоджуються з тим, що Адміністрація має доступ до всього вмісту Сервісу, включаючи особисті повідомлення на Сервісі.</li>
                                    <li>Користувачі не повинні намагатися отримати несанкціонований доступ до будь-якої частини або функції Сервісу, або будь-яких інших систем або мереж, підключених до Сервісу, або до будь-якого сервера Сервісу, будь-якими незаконними засобами.</li>
                                    <li>Всі користувачі Сервісу можуть реєструвати не більше одного облікового запису Замовника та одного облікового запису Фрілансера. Реєстрація декількох облікових записів одного типу заборонена, так само як і передача параметрів входу на сервіс іншим користувачам.</li>
                                    <li>Заборонено передача облікових записів третім особам. Один обліковий запис належить одній особі.</li>
                                    <li>Заборонені покупка та продаж облікових записів.</li>
                                    <li>Всі користувачі Сервісу зобов'язані сумлінно виконувати взяті ними на себе зобов'язання як перед адміністрацією Сервісу, так і перед своїми контрагентами (в разі укладення з останніми угод).</li>
                                    <li>Заборонена нецільова реклама надаваємих послуг.</li>
                                    <li>Заборонено використання інструментів для масової розсилки особистих повідомлень або автоматичного додавання ставок на проекти.</li>
                                    <li>Заборонені нецільові обговорення в форумах проектів або конкурсів, за винятком уточнення деталей, необхідних для розуміння поставленого завдання.</li>
                                    <li>Заборонено використання інструментів для штучного підвищення унікальності в проектах на написання текстів.</li>
                                </ol>
                            </li>
                            <li>Права та обов'язки Адміністрації:
                                <ol>
                                    <li>Адміністрація визначає правила поведінки на сервісі та залишає за собою право вимагати їх виконання від Користувачів.</li>
                                    <li>Адміністрація залишає за собою право вносити зміни в Угоду та в усі її невід'ємні частини без будь-якого спеціального повідомлення користувачів про такі зміни.</li>
                                    <li>Адміністрація залишає за собою право в будь-який час вносити зміни в інформацію, яка опублікована на Сервісі.</li>
                                    <li>Адміністрація має право направляти Користувачам інформаційні повідомлення виключно в рамках користування Сервісом.</li>
                                    <li>Адміністрація не несе відповідальності за достовірність інформації, опублікованої в межах Сервісу, та/або коректність висловлювань його користувачів.</li>
                                    <li>Якщо Користувач не згоден з рішенням Адміністрації, він має право написати лист з обґрунтуванням своєї незгоди на адресу Адміністрації Сайту.</li>
                                    <li>Адміністрація може позбавити права користування Сервісу Користувача, який порушує умови Угоди.</li>
                                    <li>Адміністрація має право заблокувати або видалити акаунт Користувача, а також заборонити доступ із використанням будь-якої інформації до Сервісу, та видалити будь-який контент Користувача без пояснення причин, в тому числі в будь-якому з наступних випадків:
                                        <ul>
                                            <li>порушення Користувачем умов Угоди або умов інших документів, передбачених Угодою.</li>
                                            <li>вчинення Користувачем дій, що спричинили чи здатні спричинити нанесення шкоди діловій репутації Сервісу.</li>
                                            <li>одержання значної кількості скарг від інших користувачів.</li>
                                            <li>надання неправдивої інформації в публічному профілі.</li>
                                            <li>публікація приватної переписки з іншими користувачами на сервісі на публічно доступних ресурсах.</li>
                                        </ul>
                                    </li>
                                    <li>Адміністрація сайту має право внести будь-які коригування в профіль користувача без попередження користувача, якщо вважає, що користувач порушує правила роботи сайту.</li>
                                    <li>Адміністрація має право контролювати, розміщувати, видаляти, змінювати, зберігати або переглядати повідомлення, відправлені через Сайт, в будь-який час та з будь-якої причини. Адміністрація не несе відповідальності, не схвалює і не гарантує інформації щодо думок, поглядів, порад або рекомендацій, розміщених або відправлених Користувачами.</li>
                                    <li>Адміністрація не несе відповідальності за будь-які помилки, неточності, упущення при реєстрації або завантаження контенту на Сайті та не може бути притягнута до відповідальності за будь-які збитки (включаючи упущену вигоду), що виникають у зв'язку з такими помилками, неточностями або упущеннями.</li>
                                    <li>Надаючи Адміністрації свою адресу електронної пошти, Користувачі дають згоду на використання електронної пошти для відправки Користувачам сервісних, юридичних, інформаційних, промо та рекламних повідомлень.</li>
                                    <li>Адміністрація залишає за собою право рекламувати послуги Сервісу, на свій розсуд, шляхом обробки контенту та відображення його на відповідних сторінках Сервісу і за його межами, з правом його структурування, редагування, інтеграції, поділу, перегрупування, перекладу текстової частини контенту на інші мови та інше. Адміністрація не несе відповідальності за будь-які помилки, спотворення, упущення, неточності, видалення, дефекти контенту в зв'язку з перекладом текстової частини контенту на інші мови.</li>
                                    <li>Замовник і Виконавець надають свою безумовну згоду на обробку Адміністрацією персональних даних з метою здійснення прав і виконання зобов'язань, які випливають з положень цього Договору. Обробка включає, але не обмежується, збиранням, реєстрацією, зберіганням, адаптуванням, поновленням, використанням і знищенням персональних даних. Сторони повідомлені про те, що з моменту укладення даного Договору Адміністрація звільняється від обов'язку отримувати додаткові згоди Замовників і Виконавців на обробку їх персональних даних. Вказана згода також має на увазі можливість передачі даних партнерам Адміністрації, включаючи дані платіжних систем, виключно для проведення рекламних акцій за участю Замовника і Виконавця, проведення взаєморозрахунків та надання послуг сервісу, а також з метою ідентифікації автентичності наданих користувачем документів.</li>
                                    <li>Адміністрація має право заблокувати проєкт у випадку отримання значної кількості скарг від інших користувачів.</li>
                                </ol>
                            </li>
                        </ol>

                        <h4 id="item-2-4" class="anchor">Порядок розгляду спорів та відповідальність сторін</h4>
                        <ol class="pl-0">
                            <li>Адміністрація Сервісу не приймає участі в суперечках (в тому числі судових) між Користувачами Сервісу, а також за участю третіх осіб.</li>
                            <li>Адміністрація Сервісу не несе відповідальності за якість послуг, що надаються Виконавцями.</li>
                            <li>Адміністрація Сервісу не несе відповідальності за будь-які можливі збитки, та/або упущену вигоду користувачів або третіх осіб, заподіяних у результаті використання, або неможливості використання Сервісу.</li>
                            <li>Адміністрація Сервісу не несе відповідальності за дії користувачів або третіх осіб, що порушують чинне законодавство України.</li>
                            <li>Адміністрація Сервісу не несе відповідальності за інформацію і матеріали, що розміщуються Користувачами в рамках Сервісу.</li>
                            <li>Адміністрація Сервісу не гарантує, але зобов'язується докласти всіх зусиль для безпомилкового та безперервного функціонування Сервісу.</li>
                            <li>Користувач несе відповідальність за всі дії, здійснені від імені Користувача в межах Сервісу.</li>
                            <li>Користувач несе відповідальність за якість і своєчасність виконання прийнятих у рамках Сервісу зобов'язань.</li>
                            <li>Користувач несе відповідальність за безпеку конфіденційної інформації, використовуваної для доступу до Сервісу.</li>
                        </ol>

                        <h4 id="item-2-5" class="anchor">Персональні дані</h4>
                        <p>Усі персональні дані на Сервісі публікуються за попередньою згодою суб'єктів персональних даних, отриманої відповідно до чинного законодавства України. Надаючи нам Вашу особисту інформацію, Користувач надає свою беззастережну згоду на обробку Адміністрацією персональних даних з метою здійснення прав і виконання зобов'язань, витікаючих з положень цього Договору.
                            Обробка включає, але не обмежується, збором, реєстрацією, зберіганням, адаптацією, оновленням, використанням та знищенням персональних даних. У зв'язку з чим Адміністрація звільняється від обов'язку отримувати додаткові згоди від користувача на обробку персональних даних, а саме, на її збір, зберігання, адаптацію, оновлення і використання в цілях поширення електронних тематичних розсилок і іншої інформації, пов'язаної з діяльністю Сервісу.
                            Надані Користувачем персональні дані використовуються тільки для внутрішніх цілей і не передаються третім особам. Окрім випадків передачі необхідної інформації партнерам Адміністрації, виключно для проведення рекламних акцій за участю користувача, проведення взаєморозрахунків та надання послуг Сервісу, а також з метою ідентифікації автентичності наданих користувачем документів. Користувач у будь-який момент може запросити або змінити свою персональну інформацію, що міститься у базах Сервісу, зв'язавшись з Адміністрацією.</p>

                        <h3 id="privacy" class="anchor pt-5 mt-5">Політика конфіденційності</h3>
                        <p>Власник Інтернет Сайту stephub.com (далі — Сайту), в особі Адміністрації Сайту (далі – сторона), приймає на себе зобов'язання щодо захисту конфіденційної інформації та персональних даних Замовників і Виконавців (далі – сторони, яка Передає).</p>

                        <h4 id="item-3-1" class="anchor">Визначення понять</h4>
                        <p>Передаюча сторона — Замовники і Виконавці, які володіють конфіденційною інформацією та персональними даними, які передаються ними Адміністраці Сайту при реєстрації та використанні Сервісу.</p>
                        <p>Сторона, що отримує — Адміністрація, що бере конфіденційну інформацію та персональні дані при наданні послуг Замовникам і Виконавцям.</p>
                        <p>Конфіденційна інформація — не є загальнодоступною інформація, яка розголошується Передавальною стороною Отримуючій стороні. Така інформація може позначатися позначкою «конфіденційно», але може такої мітки і не мати, однак за своїм змістом повинна бути сприйнята як конфіденційна.</p>
                        <p>Конфіденційною є в тому числі, але не виключно:</p>
                        <ul>
                            <li>інформація про рівень технічного розвитку Передавальної сторони, а також успішних технічних рішеннях і перспективах вдосконалення в даній області;</li>
                            <li>відомості про маркетингову чи рекламну політику Передавальної сторони по просуванню своїх товарів, робіт і послуг;</li>
                            <li>інформація, що отримана від третіх осіб, відносно яких Передавальна сторона має зобов'язання про нерозголошення конфіденційної інформації.</li>
                        </ul>
                        <p>Не є конфіденційною інформація, не залежно від того, як вона позначена, яка:</p>
                        <ul>
                            <li>є загальнодоступною, володіння і розголошення якої може призвести до порушення прав і законних інтересів Передавальної сторони;</li>
                            <li>стала відома Отримуючій стороні до реєстрації Передавальною стороною облікового запису на Сайті;</li>
                            <li>представлена Передавальною стороною з письмовою вказівкою про те, що вона не є конфіденційною;</li>
                            <li>стосується відомостей про факт використання Сервісу Передавальною стороною.</li>
                        </ul>
                        <p>Персональні дані — відомості чи сукупність відомостей про Передавальну сторону, за допомогою якої така Сторона може бути ідентифікована.</p>
                        <p>Категоріями Персональних даних Сторін в рамках Сервісу є:</p>
                        <ul>
                            <li>адреса електронної пошти;</li>
                            <li>номер студентського квитка;</li>
                            <li>Telegram аккаунт;</li>
                            <li>а також інші дані, за допомогою яких можна ідентифікувати їх власника.</li>
                        </ul>

                        <h4 id="item-3-2" class="anchor">Загальні положення</h4>
                        <p>Метою отримання і обробки Отримуючою стороною конфіденційної інформації і персональних даних є:</p>
                        <ul>
                            <li>надання Передавальній стороні доступу до можливостей Сервісу, інформації і матеріалів, розміщених на Сайті;</li>
                            <li>організація комунікації між Сторонами;</li>
                            <li>забезпечення успішної реалізації предмета Договору на виконання робіт/надання послуг, що укладається Замовниками та Виконавцями з використанням Сервісу.</li>
                        </ul>

                        <h4 id="item-3-3" class="anchor">Повідомлення</h4>
                        <ol class="pl-0">
                            <li>Відвідувачі Сайту, що не реєструють обліковий запис, ознайомлені й згодні з тим, що сторона має право збирати про таких відвідувачів певну інформацію, в т. ч. URL і IP –адреси і т. д., які були переглянуті під час відвідування. Ця інформація використовується виключно для внутрішніх цілей і служить для поліпшення роботи Сервісу.</li>
                            <li>Одержуюча сторона обробляє тільки ту конфіденційну інформацію та персональні дані, які необхідні для забезпечення якості надаваємих послуг і не використовує таку інформацію для інших цілей без згоди Передавальної сторони.</li>
                            <li>Одержуюча Сторона зберігає конфіденційну інформацію та персональні дані до тих пір, поки це необхідно для обумовлених цілей у відповідності з чинним законодавством.</li>
                            <li>Передавальній стороні надається безперешкодний доступ до належної їй конфіденційної інформації та персональних даних.</li>
                            <li>Сторона не передає конфіденційну інформацію та персональні дані Передавальної сторони третім особам без згоди власників такої інформації, за винятком випадків, прямо передбачених законом.</li>
                        </ol>

                        <h4 id="item-3-4" class="anchor">Зобов'язання</h4>
                        <ol class="pl-0">
                            <li>Передавальна сторона зобов'язується надати достовірну і повну інформацію.</li>
                            <li>Отримуюча сторона зобов'язується:
                                <ul>
                                    <li>використовувати конфіденційну інформацію та персональні дані виключно в цілях забезпечення працездатності Сервісу та реалізації предмета Договору на виконання робіт/надання послуг;</li>
                                    <li>не розголошувати конфіденційну інформацію третім особам за винятком передбачених законом випадків;</li>
                                    <li>не використовувати конфіденційну інформацію та персональні дані в інтересах, що суперечать цілям, зазначеним у п. 1.1 Політики конфіденційності;</li>
                                    <li>максимально обмежити кількість працівників та інших осіб, які мають доступ до конфіденційної інформації та персональних даних, забезпечивши при цьому отримання від них письмових зобов'язань про нерозголошення та невикористання в своїх або чужих інтересах конфіденційної інформації та персональних даних Передавальної сторони.;</li>
                                    <li>негайно повідомляти Передавальну сторону про виявлені факти несанкціонованого використання чи розголошення конфіденційної інформації та персональних даних, організовуючи всі необхідні заходи для запобігання подальшого несанкціонованого використання або розкриття такої інформації.;</li>
                                    <li>на вимогу сторони, яка Передає знищити отриману конфіденційну інформацію та персональні дані.</li>
                                </ul>
                            </li>
                        </ol>

                        <h4 id="item-3-5" class="anchor">Прикінцеві положення</h4>
                        <ol class="pl-0">
                            <li>База Користувачів Сайту формується Адміністрацією виключно для внутрішнього використання. Адміністрація вживає необхідних заходів програмного і технічного характеру для її захисту, проте не несе відповідальності у разі, якщо Бази Користувачів стали доступні третім особам внаслідок здійснення протиправних дій.</li>
                            <li>При видаленні облікового запису Передавальної сторони, персональні дані такої сторони негайно видаляються, якщо Передавальна сторона раніше не була викрита в шахрайстві на Сайті та звернулася з відповідним проханням до Одержуючої сторони по електронній пошті.: <strong>stephub.com@gmail.com</strong></li>
                            <li>Щоб отримати доступ до інформації, задати питання з приводу нашої політики конфіденційності або подати скаргу, надішліть листа електронною поштою: <strong>stephub.com@gmail.com</strong></li>
                        </ol>
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
        </div>
    </div>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
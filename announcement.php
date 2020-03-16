<?php
require "php/db.php";
include_once 'php/functions.php';

if (isset($_GET['id'])) {
    $announcement = get_announcement_by_id($_GET['id']);
    $comments = get_comments_by_announcement_id($_GET['id']);//TODO
}

//rename function
//comments -- comments' array
//i -- index of array
//n -- hierarchy
function echo_comment($comments, $i, $n){
//    TODO
//    display comment

//    запамятовуємо ід комента
    $j = $comments[$i]['id'];
//    якщо рекурсія буде норм працювати, то кожного разу цей цикл буде проходити на 1 ел менше
//    якщо рекурсія не буде працювати, тоді не можна видаляти

//    видаляємо комент
    unset($comments[$i]);

//    запускаємо цикл для того щоб перевірити чи є якісь коменти до цього комента
    foreach ($comments as $a){
//        якщо ід комента співпадає з parent_id якогось іншого
        if ($a['parent_id'] == $j){
//            збільшуємо ієрархію
            ++$n;
//            викликаємо функцію, в якій вже нема теперішнього комента, шукаємо індекс того комента, в якого parent_id =
            echo_comment($comments, array_search($a, $comments), $n);
        }
    }

//    після того як видалилися всі коменти повязані з теперішнім, залишаються інші по тій самій ієрархії
//    а так як масив відсортований по часу, то зрозуміло, що 0 елемент буде підходити
//    if (count($comments) > 0 and $n == 1){
//        echo_comment($comments, 0, $n);
//    }
//    якщо ні -> не придумав))
//    TODO
}

echo_comment($comments, 0, 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>StepHub | Announcement Title</title>

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
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header my-bg-gray my-color-dark">
                        <div class="container">
                            <div class="row pt-2 pb-2">
                                <div class="col-md-10">
                                    <h3 class="card-title"><?= $announcement['title']?></h3>
                                </div>
                                <div class="col-md-2 pr-0">
                                    <button class="btn float-right my-color-dark"><i class="fas fa-ban"></i></button>
                                </div>
                            </div>
                            <div class="row pt-2 px-2">
                                <p class="card-text text-muted small mx-2"><i class="far fa-calendar mr-2"></i><?= show_date($announcement['date'])?></p>
                                <p class="card-text text-muted small mx-2"><i class="far fa-calendar-times mr-2"></i><?= show_date($announcement['deadline'])?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <p><?= $announcement['details']?></p>
                    </div>
                    <?php if(isset($announcement['file'])): ?>
                    <div class="card-footer">
                        <button class="btn btn-secondary"><i class="fas fa-download mr-2"></i>Download attachment</button>
                        <div class="card-text text-muted small mx-2"><i class="fas fa-file mr-2"></i>file.zip</div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="card shadow-sm mt-5">
                    <div class="card-header">
                        <form class="form">
                            <label class="sr-only" for="comment_field">Leave Comment</label>
                            <textarea type="text" rows="3" class="form-control mb-2 mr-sm-2" id="comment_field" placeholder="Leave Comment"></textarea>
                            <button type="submit" class="btn my-btn-blue mt-1 mb-2"><i class="fas fa-comment mr-2"></i>Comment</button>
                        </form>
                    </div>
                    <div class="card-body bg-light">

                        <div class="card mb-3 announcement-card">
                            <div class="card-header my-bg-gray pb-0">
                                <div class="row pl-1">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <p class="card-text text-muted small mx-2"><i class="far fa-calendar mr-2"></i><?= show_date(5132643)?></p>
                                            <p class="card-text text-muted small mx-2"><i class="far fa-clock mr-2"></i><?= show_time(5132643)?></p>
                                            <span class="badge badge-secondary mx-2 mb-3"><i class="fas fa-user mr-2"></i>owner</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn float-right text-muted pt-0 pr-0"><i class="fas fa-ban"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body shadow-sm">
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, quod?</p>
                            </div>
                        </div>

                        <div class="card mb-3 announcement-card">
                            <div class="card-header my-bg-gray pb-0">
                                <div class="row pl-1">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <p class="card-text text-muted small mx-2"><i class="far fa-calendar mr-2"></i><?= show_date(5132643)?></p>
                                            <p class="card-text text-muted small mx-2"><i class="far fa-clock mr-2"></i><?= show_time(5132643)?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn float-right text-muted pt-0 pr-0"><i class="fas fa-ban"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body shadow-sm">
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, quod?</p>
                            </div>
                        </div>

                        <div class="card mb-3 announcement-card">
                            <div class="card-header my-bg-gray pb-0">
                                <div class="row pl-1">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <p class="card-text text-muted small mx-2"><i class="far fa-calendar mr-2"></i><?= show_date(5132643)?></p>
                                            <p class="card-text text-muted small mx-2"><i class="far fa-clock mr-2"></i><?= show_time(5132643)?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn float-right text-muted pt-0 pr-0"><i class="fas fa-ban"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body shadow-sm">
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, quod?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body shadow-sm">
                        <h5 class="card-title">Do you want to help?</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A amet at dolore eos facilis molestias nesciunt non numquam voluptate voluptatem.</p>
                        <a href="#" class="btn btn-secondary btn-block"><i class="fas fa-comments mr-2"></i>Go to private chat</a>
                        <p class="text-center my-0">or</p>
                        <a href="#" class="btn btn-success btn-block"><i class="fas fa-hands-helping mr-2"></i>Help to solve</a>
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
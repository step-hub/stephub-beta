<?php
require "php/db.php";
include_once 'php/functions.php';

$data = $_GET;
if (isset($data['s']) and isset($data['o']) and isset($data['q'])){
    $announcements = get_announcements_with_filter($data['s'], $data['o'], $data['q']);
} else {
    $announcements = get_announcements_without_filter();    
}

?>

<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>StepHub</title>

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

    <!-- Header-->
    <?php if (!$_SESSION):
        include_once 'templates/intro.php'; ?>
    <?php else:
        include_once 'templates/header.php'; ?>

        <!-- Page Content -->
    <div class="container">
        <div class="row mx-5">
            <div class="col">
                <div class="row my-2 mx-0">
                    <form class="form-inline small float-right ml-auto" action="index.php" method="GET">
                        <div class="form-group mr-2">
                            <label for="sort_by">Сортування</label>
                            <select class="form-control-sm ml-2" name="s" id="sort_by">
                                <option value="date" <?php if (!$data or ($data and $data['s'] == 'date')) echo "selected"?>>Дата створення</option>
                                <option value="deadline" <?php if ($data and $data['s'] == 'deadline') echo "selected"?>>Дедлайн</option>
                            </select>
                            <select class="form-control-sm ml-2" name="o" id="order" style="font-family: 'FontAwesome', serif !important;">
                                <option value="asc" <?php if ($data and $data['o'] == 'asc') echo "selected"?>>&#xf161;</option>
                                <option value="desc" <?php if (!$data or ($data and $data['o'] == 'desc')) echo "selected"?>>&#xf160;</i></option>
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <label for="qty">Оголошень на сторінці</label>
                            <select class="form-control-sm ml-2 " name="q" id="announcement_qty">
                                <option value="10" <?php if (!$data or ($data and $data['q'] == '10')) echo "selected"?>>10</option>
                                <option value="20" <?php if ($data and ($data and $data['q'] == '20')) echo "selected"?>>20</option>
                                <option value="30" <?php if ($data and ($data and $data['q'] == '30')) echo "selected"?>>30</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-secondary"><i class="fas fa-filter mr-2"></i>Фільтрувати</button>
                    </form>
                </div>
                <div class="card">
                    <div class="card-body shadow-sm bg-light pb-0">
                        <?php if($announcements):
                            foreach($announcements as $announcement): ?>
                                <div class="card text-left mb-3 announcement-card">
                                    <div class="card-body shadow-sm">
                                        <h5 class="card-title"><?= $announcement['title']?></h5>
                                        <p class="card-text mb-4"><?= $announcement['details']?></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row pt-2 px-2">
                                                    <p class="card-text text-muted small mx-2"><i class="far fa-calendar mr-2"></i><?= show_date($announcement['date']) ?></p>
                                                    <?php if($announcement['deadline']): ?>
                                                        <p class="card-text text-muted small mx-2"><i class="far fa-calendar-times mr-2"></i><?= show_date($announcement['deadline']) ?></p>
                                                    <?php endif;
                                                    if(count_comments_by_announcement_id($announcement['id']) > 0): ?>
                                                        <p class="card-text text-muted small mx-2"><i class="far fa-comments mr-2"></i><?= count_comments_by_announcement_id($announcement['id'])?></p>
                                                    <?php endif;
                                                    if($announcement['file']): ?>
                                                        <p class="card-text text-muted small mx-2"><i class="fa fa-paperclip mr-2"></i><?= $announcement['file'] ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col align-self-end">
                                                <a href="announcement.php?id=<?= $announcement['id']?>" class="btn my-btn-blue float-right">Детальніше</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Pagination-->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <span class="page-link">Назад</span>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active">
                                        <span class="page-link">2<span class="sr-only">(current)</span></span>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Вперед</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php else: ?>
                            <div class="card border-danger">
                                <div class="card-body shadow-sm">
                                    <h5 class="card-title mb-0 text-center text-danger"><i class="fas fa-exclamation-circle mr-3"></i>Не знайдено оголошень</h5>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
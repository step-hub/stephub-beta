<?php
require "php/db.php";
include_once 'php/functions.php';

$data = $_GET;
if (isset($data['do_filter'])){
    $announcements = get_announcements_with_filter($data['sort_by'], $data['sort_asc'], $data['announcement_qty']);
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
                            <label for="date_filter">Сортування</label>
                            <select class="form-control-sm ml-2" name="sort_by" id="sort_by">
                                <option value="date" <?php if (!$data or ($data and $data['sort_by'] == 'date')) echo "selected"?>>Дата створення</option>
                                <option value="deadline" <?php if ($data and $data['sort_by'] == 'deadline') echo "selected"?>>Дедлайн</option>
                            </select>
                            <select class="form-control-sm ml-2" name="sort_asc" id="sort_asc">
                                <option value="asc" <?php if ($data and $data['sort_by'] == 'asc') echo "selected"?>>За зростанням</option>
                                <option value="desc" <?php if (!$data or ($data and $data['sort_asc'] == 'desc')) echo "selected"?>>За спаданням</option>
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <label for="announcement_qty">Оголошень на сторінці</label>
                            <select class="form-control-sm ml-2 " name="announcement_qty" id="announcement_qty">
                                <option value="10" <?php if (!$data or ($data and $data['announcement_qty'] == '10')) echo "selected"?>>10</option>
                                <option value="20" <?php if ($data and $data['announcement_qty'] == '20') echo "selected"?>>20</option>
                                <option value="30" <?php if ($data and $data['announcement_qty'] == '30') echo "selected"?>>30</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-secondary" name="do_filter"><i class="fas fa-filter mr-2"></i>Фільтрувати</button>
                    </form>
                </div>
                <div class="card">
                    <div class="card-body shadow-sm bg-light">
                        <?php if($announcements):
                            foreach($announcements as $announcement): ?>
                                <div class="card text-left mb-3 announcement-card">
                                    <div class="card-body shadow-sm">
                                        <h5 class="card-title"><?= $announcement['title']?></h5>
                                        <div class="row">
                                            <div class="col">
                                                <p class="card-text mb-4"><?= $announcement['details']?></p>

                                                <p class="card-text text-muted small"><i class="far fa-calendar mr-2"></i><?= show_date($announcement['date'])?></p>
                                                <?php if($announcement['deadline']): ?>
                                                    <p class="card-text text-muted small"><i class="far fa-calendar-times mr-2"></i><?= show_date($announcement['deadline'])?></p>
                                                <?php endif;
                                                if($announcement['file']): ?>
                                                    <p class="card-text text-muted small"><i class="far fa-file mr-2"></i></p>
                                                <?php endif; ?>

                                            </div>
                                            <div class="col align-self-end">
                                                <a href="announcement.php?id=<?= $announcement['id']?>" class="btn btn-primary float-right">Дізнатись більше</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <div class="card border-danger">
                                <div class="card-body shadow-sm">
                                    <h5 class="card-title mb-0 text-center text-danger"><i class="fas fa-exclamation-circle mr-3"></i>Не знайдено оголошень</h5>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Pagination-->
                        <nav aria-label="">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <span class="page-link">Попередня</span>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active">
                                    <span class="page-link">2<span class="sr-only">(current)</span></span>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Наступна</a>
                                </li>
                            </ul>
                        </nav>

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
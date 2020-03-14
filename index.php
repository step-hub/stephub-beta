<?php
require "php/db.php";
include_once 'php/functions.php';

$announcements = get_announcements();
?>

<!DOCTYPE html>
<html lang="en">

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

<body class="text-center bg-light">
    <!-- Navigation -->
    <?php include_once 'templates/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-left">
                    <form action="index.php" method="GET">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="form-group">
                                    <label for="date_filter">Sort by</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="date_filter" value="create" checked>create date
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="date_filter" value="deadline">deadline date
                                        </label>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group">
                                    <label for="announcement_qty">Announcements on page</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="announcement_qty" value="10" checked>10
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="announcement_qty" value="20">20
                                        </label>
                                    </div>
                                    <div class="form-check disabled">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="announcement_qty" value="30">30
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-block" name="do_filter">Apply</button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body shadow-sm">
                        <?php if($announcements):
                            foreach($announcements as $announcement): ?>
                                <div class="card text-left mb-3">
                                    <div class="card-body shadow-sm">
                                        <h5 class="card-title"><?= $announcement['title']?></h5>
                                        <div class="row">
                                            <div class="col">
                                                <p class="card-text mb-4"><?= $announcement['details']?></p>

                                                <p class="card-text text-muted small"><i class="far fa-calendar mr-2"></i><?= show_date($announcement['date'])?></p>
                                                <?php if($announcement['deadline']): ?>
                                                    <p class="card-text text-muted small"><i class="far fa-calendar mr-2"></i><?= show_date($announcement['deadline'])?></p>
                                                <?php endif;
                                                if($announcement['file']): ?>
                                                    <p class="card-text text-muted small"><i class="far fa-file mr-2"></i></p>
                                                <?php endif; ?>

                                            </div>
                                            <div class="col align-self-end">
                                                <a href="announcement.php" class="btn btn-primary float-right">Open</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <div class="card border-danger">
                                <div class="card-body shadow-sm">
                                    <h5 class="card-title mb-0 text-center text-danger"><i class="fas fa-exclamation-circle mr-3"></i>No announcements found</h5>
                                </div>
                            </div>
                        <?php endif; ?>
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
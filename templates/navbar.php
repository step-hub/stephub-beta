<nav class="navbar navbar-expand-lg fixed-top <?php if (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") { echo "py-1"; } ?>">
    <div class="container">
        <a class="navbar-brand<?php if (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") { echo "-sm my-color-dark"; } ?>" href="index.php">StepHub</a>
        <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse <?php if (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") { echo "small"; } ?>" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "index.php") { echo "active font-weight-bold"; } ?>">
                    <a class="nav-link" href="index.php">Головна</a>
                </li>
                <?php if (isset($_SESSION['logged_user'])): ?>
                    <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "profile.php") { echo "active font-weight-bold"; } ?>">
                        <a class="nav-link" href="profile.php">Профіль</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "about.php") { echo "active font-weight-bold"; } ?>">
                    <a class="nav-link" href="about.php">Про нас</a>
                </li>
                <?php if (isset($_SESSION['logged_user'])):
                    if ($_SESSION['logged_user']->user_status == 1): ?>
                        <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "admin.php") { echo "active font-weight-bold"; } ?>">
                            <a class="btn my-btn-outline-dark ml-3 <?php if (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") { echo "btn-sm"; } ?>" href="admin.php">Адміністратор</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['logged_user']->user_status <= 2): ?>
                    <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "moderator.php") { echo "active font-weight-bold"; } ?>">
                        <a class="btn my-btn-outline-dark ml-3 <?php if (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") { echo "btn-sm"; } ?>" href="moderator.php">Модератор</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a type="button" data-toggle="modal" data-target="#exitModal" class="btn my-btn-dark ml-3 <?php if (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") { echo "btn-sm"; } ?>">Вихід</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn my-btn-dark ml-3" href="registration.php">Реєстрація</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal Exit -->
<div class="modal fade" id="exitModal" tabindex="-1" role="dialog" aria-labelledby="exitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exitModalLabel">Вихід</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ви дійсно хочете вийти із вашого облікового запису?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Скасувати</button>
                <a type="button" class="btn my-btn-red" href="php/logout.php">Вийти</a>
            </div>
        </div>
    </div>
</div>
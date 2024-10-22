<nav id="navbar" class="navbar navbar-expand-lg fixed-top linear-gradient-gray <?= (basename($_SERVER['PHP_SELF']) != "index.php") ? "navbar-shadow" : "" ?> <?= (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") ? "py-1" : "" ?>">
    <div class="container text-center">
        <a class="navbar-brand<?= (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") ? "-sm my-color-dark" : "" ?>" href="index.php">StepHub</a>
        <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse <?= (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") ? "small" : "" ?>" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item my-2 my-lg-0 <?= (basename($_SERVER['PHP_SELF']) == "index.php") ? "active font-weight-bold" : "" ?>">
                    <a class="nav-link" href="index.php">Головна</a>
                </li>
                <?php if (isset($_SESSION['logged_user'])) : ?>
                    <li class="nav-item my-2 my-lg-0 <?= (basename($_SERVER['PHP_SELF']) == "profile.php") ? "active font-weight-bold" : "" ?>">
                        <a class="nav-link" href="profile.php">Профіль</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item dropdown my-2 my-lg-0 <?= (basename($_SERVER['PHP_SELF']) == "about.php") ? "active font-weight-bold" : "" ?>">
                    <a class="nav-link dropdown-toggle" href="about.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Про нас</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="about.php">Про нас</a>
                        <a class="dropdown-item" href="about.php#terms">Правила користування</a>
                        <a class="dropdown-item" href="about.php#privacy">Політика конфіденційності</a>
                    </div>
                </li>
                <?php if (isset($_SESSION['logged_user'])) :
                    if ($_SESSION['logged_user']->user_status == 1) : ?>
                        <li class="nav-item my-2 my-lg-0 ml-lg-3 <?= (basename($_SERVER['PHP_SELF']) == "admin.php") ? "active font-weight-bold" : "" ?>">
                            <a class="btn my-btn-outline-dark <?= (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") ? "btn-sm" : "" ?>" href="admin.php">Адміністратор</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['logged_user']->user_status <= 2) : ?>
                        <li class="nav-item my-2 my-lg-0 ml-lg-3 <?= (basename($_SERVER['PHP_SELF']) == "moderator.php") ? "active font-weight-bold" : "" ?>">
                            <a class="btn my-btn-outline-dark <?= (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") ? "btn-sm" : "" ?>" href="moderator.php">Модератор</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item my-2 my-lg-0 ml-lg-3">
                        <a type="button" data-toggle="modal" data-target="#exitModal" class="btn my-btn-dark <?= (basename($_SERVER['PHP_SELF']) == "admin.php" or basename($_SERVER['PHP_SELF']) == "moderator.php") ? "btn-sm" : "" ?>">Вихід</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item my-2 my-lg-0 ml-lg-3">
                        <?php if (basename($_SERVER['PHP_SELF']) == 'registration.php') : ?>
                            <a class="btn my-btn-dark" href="index.php">Вхід</a>
                        <?php else : ?>
                            <a class="btn my-btn-dark" href="registration.php">Реєстрація</a>
                        <?php endif; ?>
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
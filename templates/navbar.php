<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">StepHub</a>
        <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
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
                            <a class="btn my-btn-outline-dark ml-3" href="admin.php">Адміністратор</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="btn my-btn-dark ml-3" href="php/logout.php">Вихід</a>
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
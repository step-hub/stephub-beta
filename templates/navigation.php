<nav class="navbar navbar-dark bg-dark shadow-sm navbar-expand-lg fixed-top box-shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="img/logo.jpg" class="mr-2" alt="Logo" width="32" height="32">StepHub</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "index.php") { echo "active"; } ?>">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "profile.php") { echo "active"; } ?>">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "about.php") { echo "active"; } ?>">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <?php if (isset($_SESSION['logged_user'])) : ?>
                    <?php if ($_SESSION['logged_user']->user_status == 1) : ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light mr-2" href="admin.php">Admin page</a>
                        </li>
                    <?php endif;?>
                    <li class="nav-item">
                        <a class="btn btn-light mr-2" href="logout.php">Log out</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="btn btn-light" href="login.php">Log in</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
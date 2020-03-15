<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">StepHub</a>
        <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-ico"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "index.php") { echo "active"; } ?>">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <?php if (isset($_SESSION['logged_user'])): ?>
                    <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "profile.php") { echo "active"; } ?>">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "about.php") { echo "active"; } ?>">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <?php if (isset($_SESSION['logged_user'])):
                    if ($_SESSION['logged_user']->user_status == 1): ?>
                        <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "admin.php") { echo "active"; } ?>">
                            <a class="btn my-btn-outline-dark ml-3" href="admin.php">Admin page</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="btn my-btn-dark shadow-sm ml-3" href="php/logout.php">Log out</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn my-btn-dark shadow-sm ml-3" href="registration.php">Sign up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
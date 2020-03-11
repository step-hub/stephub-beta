<nav class="navbar navbar-light bg-light navbar-expand-lg fixed-top box-shadow">
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
                <li class="nav-item">
                    <a class="nav-link" href="#">item</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="login.php">Log in</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
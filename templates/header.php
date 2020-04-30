<div class="intro intro-shadow linear-gradient-gray">
    <div class="container">
        <div class="row pb-0">
            <div class="col-md-3">
                <img class="mx-auto d-block img-large-logo" src="img/logo.png" alt="big logo">
            </div>
            <div class="col-md-9 text-left">
                <h2 class="d-none d-md-flex">Вітаємо, <?= $_SESSION['logged_user']['login'] ?>!</h2>
                <h3 class="mt-3 d-sm-flex d-md-none">Вітаємо, <?= $_SESSION['logged_user']['login'] ?>!</h3> <!-- SM -->
                <h5 class="d-none d-md-flex">Lorem ipsum dolor sit amet, consectetur</h5>
                <h6 class="d-sm-flex d-md-none">Lorem ipsum dolor sit amet, consectetur</h6> <!-- SM -->
                <br>
                <p class="d-none d-md-flex">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur culpa fugiat laudantium, nihil perferendis recusandae.</p>
            </div>
        </div>
        <?php if ($_SESSION['logged_user']['user_status'] != 4) : ?>
            <div class="row pb-4">
                <div class="col">
                    <a class="btn btn-lg my-btn-dark" href="create-announcement.php"><i class="material-icons mr-2">post_add</i>Розмістити оголошення</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
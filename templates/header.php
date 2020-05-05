<div class="intro intro-shadow linear-gradient-gray">
    <div class="container">
        <div class="row pb-0">
            <div class="col-md-3">
                <img class="mx-auto d-block img-large-logo" src="img/logo.png" alt="big logo">
            </div>
            <div class="col-md-9 text-left">
                <h2 class="d-none d-md-block">Вітаємо, <?= $_SESSION['logged_user']['login'] ?>!</h2>
                <h3 class="mt-3 d-sm-block d-md-none">Вітаємо, <?= $_SESSION['logged_user']['login'] ?>!</h3> <!-- SM -->
                <h5 class="d-none d-md-block">Створіть власне анонімне оголошення</h5>
                <h6 class="d-sm-block d-md-none">Створіть власне анонімне оголошення</h6> <!-- SM -->
                <br>
                <p class="d-none d-md-block">Почувайтесь комфортно та не стримуйте себе, якщо потребуєте допомоги.</p>
                <p class="d-none d-md-block">Пам'ятайте, що ви знаходитесь в дружньому колі студентів університету, та не порушуйте загальні норми етикету та правила користування сервісом.</p>
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
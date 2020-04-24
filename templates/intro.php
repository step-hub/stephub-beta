<div class="intro intro-shadow linear-gradient-gray">
    <div class="container">
        <div class="row pb-0 pb-md-2">
            <div class="col-sm-12 col-md-4 col-lg-3">
                <img class="mx-auto d-block img-large-logo" src="img/logo.png" alt="big logo">
            </div>
            <div class="col-sm-12 col-md-8 col-lg-5 text-left">
                <h2>Ласкаво просимо до StepHub!</h2>
                <h5>Lorem ipsum dolor sit amet, consectetur</h5>
                <br>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur culpa fugiat laudantium, nihil perferendis recusandae. </p>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4 px-sm-5 px-lg-0 px-0 px-lg-4 pt-2 pb-0 pb-md-4">
                <?php include_once "php/login.php"; ?>

                <div class="card mx-xs-0 mx-sm-5 mx-lg-0 border-xs-0">
                    <div class="card-body shadow">
                        <?php if ($errors) : ?>
                            <p class="mt-0 mb-0 font-weight-bold text-danger"><?= @$errors[0]; ?></>
                        <?php endif; ?>

                        <form class="form-login" action="index.php" method="POST">
                            <label for="inputLogin" class="sr-only">Ім'я користувача</label>
                            <input type="text" id="inputLogin" name="login" value="<?= @$data['login']; ?>" class="form-control bg-light mb-2" placeholder="Логін або email" required autofocus>

                            <label for="inputPassword" class="sr-only">Пароль</label>
                            <input type="password" id="inputPassword" name="password" class="form-control bg-light mb-2" placeholder="Пароль" required>

                            <div class="checkbox mb-2">
                                <input type="checkbox" value="remember-me" name="remember" style="color: black;">
                                <label for="remember" style="color: black;">Запам'ятати мене</label>
                            </div>

                            <button class="btn btn-lg my-btn-blue btn-block shadow-sm" type="submit" name="do_login">Вхід</button>
                            <p class="mt-3 mb-0" style="color: black;">Не маєте акаунту? <a href="registration.php">Зареєструвати</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
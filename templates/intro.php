<!-- Login -->
<?php include_once "php/login.php"; ?>

<!-- Errors -->
<?php include_once "templates/errors.php"; ?>

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
                <div class="card mx-xs-0 mx-sm-5 mx-lg-0 border-xs-0">
                    <div class="card-body shadow">
                        <form class="form-login" action="index.php" method="POST">
                            <label for="inputLogin" class="sr-only">Ім'я користувача</label>
                            <input type="text" id="inputLogin" name="login" value="<?= @$data['login']; ?>" class="form-control bg-light mb-2" placeholder="Логін або email" required autofocus>

                            <label for="inputPassword" class="sr-only">Пароль</label>
                            <input type="password" id="inputPassword" name="password" class="form-control bg-light mb-2" placeholder="Пароль" required>
                            
                            <div class="small text-left mb-3">
                                <a href="restore-password.php">Забули пароль?</a>
                            </div>
                            
                            <button class="btn my-btn-blue btn-block shadow-sm" type="submit" name="do_login">Вхід</button>

                            <div class="checkbox text-left mt-2">
                                <input type="checkbox" value="remember-me" name="remember" disabled>
                                <label for="remember" style="color: black;" class="small">Запам'ятати мене</label>
                            </div>

                            <div class="small text-left mt-2 d-block d-md-none">
                                <a href="registration.php">Створити новий акаунт</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
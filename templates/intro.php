<div class="intro">
    <div class="container">
        <div class="row pb-2">
            <div class="col-md-3">
                <img class="mx-auto d-block img-large-logo" src="img/logo.jpg" alt="big logo">
            </div>
            <div class="col-md-5 text-left">
                <h2>Ласкаво просимо до StepHub!</h2>
                <h5>Lorem ipsum dolor sit amet, consectetur</h5>
                <br>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur culpa fugiat laudantium, nihil perferendis recusandae. </p>
            </div>
            <div class="col-md-4 px-4 pt-2 pb-4">
                <?php include_once "php/login.php"; ?>
                <div class="card">
                    <div class="card-body shadow-sm">
                        <?php if($errors): ?>
                            <p class="mt-0 mb-0 font-weight-bold text-danger"><?= @$errors[0]; ?></>
                        <?php endif; ?>

                        <form class="form-login" action="index.php" method="POST">
                            <label for="inputLogin" class="sr-only">Ім'я користувача</label>
                            <input type="text" id="inputLogin" name="login" value="<?= @$data['login']; ?>" class="form-control bg-light mb-2" placeholder="Логін або email" required autofocus>

                            <label for="inputPassword" class="sr-only">Пароль</label>
                            <input type="password" id="inputPassword" name="password" class="form-control bg-light mb-2" placeholder="Пароль" required>

                            <div class="checkbox mb-2">
                                <label>
                                    <input type="checkbox" value="remember-me" name="remember"> Запам'ятати мене
                                </label>
                            </div>

                            <button class="btn btn-lg my-btn-blue btn-block" type="submit" name="do_login">Вхід</button>
                            <p class="mt-3 mb-0">Не маєте акаунту? <a href="registration.php">Зареєструвати</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
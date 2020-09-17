<?php
?>

<div class="nav_panel">
    <div class="col-md-3 col-sm-3 col-xs-6 left_side">
        <a href="/" class="logo_title">
            JOBSCANNER
        </a>
        <div class="nav_img"></div>
    </div>
    <div class="col-md-4 col-sm-4 hidden-xs center_side">
        <span class="page_title"><?= $this->title ?></span>
    </div>
    <div class="col-md-5 col-sm-5 col-xs-6 right_side">
        <a class="log_reg_link" data-toggle="modal" data-target="#myModalLogin">
            <img src="/img/01JS-icon-account.svg" alt="icon">Войти</a>
    </div>
</div>

<div id="myOverlay"></div>

<div class="modal fade" id="myModalLogin" tabindex="-2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="padding: 5% 0px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="loginClose" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <h3>Вход в личный кабинет</h3>
                <form action="/login.html" method="post">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                           value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                    <span>E-mail</span>
                    <input type="email" name="Login[email]" placeholder="name@mail.ru">

                    <span>Пароль</span>
                    <input type="password" name="Login[password]" placeholder="********">

                    <div class="modal-footer">
                        <input class="btn-modal" type="submit" value="Войти"/>
                        <a class="forgot_password" href="/">Забыли пароль?</a>
                        <p>
                            Ещё не с нами? <a style="cursor: pointer" href="javascript:void()" onclick="f()">Зарегистрируйтесь</a>
                            <script>
                                function f() {
                                    $('#myModalLogin').modal('hide');
                                    setTimeout(function () {
                                        $('#myModalRegistration').modal('show');
                                    }, 500);
                                }
                            </script>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalRegistration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="padding: 5% 0px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <h3>Регистрация</h3>
                <form action="/registration.html" method="post">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                           value="<?= Yii::$app->request->getCsrfToken(); ?>"/>

                    <span>E-mail</span>
                        <input type="email" required name="RegForm[email]" placeholder="Ваш E-mail">

                        <span>Пароль</span>
                        <input type="password" required name="RegForm[password]" placeholder="Ваш пароль">

                        <span>Повторить пароль</span>
                        <input type="password" name="RegForm[cpassword]" required
                               placeholder="Подтвердите пароль">

                    <div class="modal-footer">
                        <input class="btn-modal" type="submit" value="Присоединиться"/>
                        <p>
                            Регистрируясь, вы принимаете <a href="/">правила и условия</a>, а также <a href="/">политику конфиденциальности</a> компании ООО "Коэнко"
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalRegistrationFinish" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="padding: 5% 0px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <h3>
                    Спасибо!<br>
                    Вы успешно<br>
                    зарегистрировались.
                </h3>
                <a href="/profile.html">
                    Перейти в личный кабинет
                </a>
            </div>
        </div>
    </div>
</div>





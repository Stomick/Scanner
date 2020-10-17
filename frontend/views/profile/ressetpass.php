<?php
?>
<div class="container profile_page resset_pass">
    <div class="row">
        <div role="tabpanel" class="tab-pane active" id="tab3">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 input_row">
                    <div class="white_bg_block" style="overflow: hidden;">
                        <h2>Сброс пароля</h2>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <form action="/profile/restorepass.html" autocomplete="off" parsley-validate
                                      method="post"
                                      id="profupdate">
                                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                           value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                                    <input type="hidden" name="Restore[auth]" value="<?= $user->verification_token ?>">
                                    <div>
                                        <span class="title">Новый пароль</span>
                                        <input id="password1" name="Restore[password]" type="password" class="password"
                                               parsley-minlength="8"
                                               parsley-errors-container=".errorspannewpassinput"
                                               parsley-required-message="Введите новый пароль."
                                               parsley-uppercase="1"
                                               parsley-lowercase="1"
                                               parsley-number="1"
                                               parsley-special="1"
                                               parsley-required/>
                                        <span class="errorspannewpassinput"></span>
                                    </div>
                                    <div>
                                        <span class="title">Повторите новый пароль</span>
                                        <input name="Restore[confpassword]" id="password2" type="password"
                                               class="password"
                                               parsley-minlength="8"
                                               parsley-errors-container=".errorspanconfirmnewpassinput"
                                               parsley-required-message="Пароли не совпадают"
                                               parsley-equalto="#password1"
                                               parsley-required/>
                                        <span class="errorspanconfirmnewpassinput"></span>
                                    </div>
                                    <input class="save_profile_btn" id="prfupdate" type="button" value="Сохранить"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/plugins/form/form.js"></script>
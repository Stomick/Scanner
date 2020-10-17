<?php
?>
<div role="tabpanel" class="tab-pane fade in active" id="tab1">
    <form action="/profile/update.html" autocomplete="off" parsley-validate method="post" id="profupdate">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
               value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
        <input type="hidden" name="Prof[<?= !$prof->type ? 'logo' : 'comp_logo'?>]"
               value="<?= !$prof->type ? $prof->logo : $prof->comp_logo ?>" id="profAva"/>
        <div class="row">
            <div style="padding-right: 7px;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pad_mobile_none">
                <div class="white_bg_block">
                    <h2>Фото профиля</h2>
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="uploadLogo-wrap">
                                <div id="uploadLogo">
                                </div>
                            </div>
                            <div class="uploadLogo-wrap">
                                <div class="actions">
                                    <a class="btn file-btn">
                                        <span style="cursor: pointer">Загрузить фото</span>
                                        <input style="cursor: pointer" type="file" id="upload"
                                               value="Choose a file" accept="image/*">
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div style="margin-top: 15px;" class="white_bg_block">
                    <h2>Изменить пароль</h2>
                    <div class="row user_info">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 input_row">
                            <span class="title">Безопасность </span>
                            <input type="password"
                                   name="Prof[newPassword]"
                                   id="userpass" placeholder="Укажите старый пароль">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <span class="title">Безопасность </span>
                            <input type="password" parsley-equalto="#userpass"
                                   parsley-error-message="пароли не совпадают" parsley-trigger="keyup"
                                   placeholder="Укажите новый пароль">
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding-left: 7px;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pad_mobile_none">
                <div class="white_bg_block">
                    <h2><?=Yii::$app->user->identity->type ? "Данные Нанимателя" : "Данные Соискателя";?></h2>
                    <div class="row user_info">
                        <?php if(!$prof->type){?>
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <span class="title">Фамилия</span>
                            <input type="text" placeholder="Иванов" value="<?= $prof->lastname ?>"
                                   parsley-required="true"
                                   parsley-error-message="Фамилия не может быть пустой"
                                   name="Prof[lastname]">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <span class="title">Имя</span>
                            <input type="text" placeholder="Иван" value="<?= $prof->firstname ?>"
                                   parsley-required="true"
                                   parsley-error-message="Имя не может быть пустым"
                                   name="Prof[firstname]">
                        </div>
                        <?php }else{?>
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <span class="title">Компания</span>
                            <input type="text" placeholder="" required value='<?= $prof->company ?>'
                                   parsley-error-message="Поле Компания не заполнено. Профиль Нанимателя будет недоступен"
                                   name="Prof[company]"/>
                        </div>
                        <?php }?>
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <span class="title">Старше 18 лет?</span>
                            <input type="date"
                                   value="<?= $prof->birthday ?>" name="Prof[birthday]"
                                   placeholder="MM/DD/YYYY" data-date-format="mm/dd/yyyy"
                                   min="<?php echo date('m/d/Y'); ?>"
                                   parsley-type="dateIso"
                                   parsley-error-message="Не корректная дата рождения"
                                   parsley-trigger="change">

                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <span class="title">Email</span>
                            <input type="text"
                                   value="<?= $prof->email ?>" name="Prof[email]"
                                   class="parsley-validated"
                                   parsley-type="email" parsley-required="true"
                                   parsley-error-message="Введите корректный емаил"
                                   parsley-trigger="change" placeholder="name@mail.com">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <span class="title">Телефон</span>
                            <input type="text"
                                   value="<?= $prof->phone ?>" id="profphone" name="Prof[phone]"
                                   class="parsley-validated" parsley-error-message="Не корректный телефон"/>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <span class="title">Адрес</span>
                            <input type="text"
                                   value="<?= $prof->address ?>" name="Prof[address]"
                                   id="profaddress" placeholder="Ваш адрес"/>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <a class="del_profile" href="/deactivate.html">Отключить публичность</a>
                        </div>
                    </div>
                </div>
                <div class="white_bg_block">
                    <h2>Увидомления на почту</h2>
                    <div class="row user_info">
                        <div class="col-md-12 col-sm-12 col-xs-12 input_row">
                            <?php if($prof->type){?>
                                <input style="float: right" class="check" type="checkbox" name="Prof[noty_spec]" <?= $prof->noty_spec ==1 ? 'checked':''?> id="noty">
                                <label style="width: 100%;" for="noty">Новые специалисты</label>
                            <?php }else{?>
                                <input style="float: right" class="check" type="checkbox" name="Prof[noty_vac]" <?= $prof->noty_vac ==1 ? 'checked':''?> id="noty">
                                <label style="width: 100%;" for="noty">Новые вакансии в вашем городе</label>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button class="save_profile_btn" id="prfupdate" >Сохранить</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        CropperAvatar.init("<?= !$prof->type ? $prof->logo :$prof->comp_logo?>");
        $('.cr-slider').parsley({min: 0, max: 10000});
        var phoneMask = IMask(
            document.getElementById('profphone'), {
                mask: '+{7}(000)000-00-00'
            });
    });
</script>
<script defer async>
    function initAutocomplete() {
        var input = document.getElementById('profaddress');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI56UwMrhNrE4_FDt-Ks1lBhk2wBWxbBg&language=ru&libraries=places&callback=initAutocomplete"></script>
<script src="/plugins/form/form.js"></script>
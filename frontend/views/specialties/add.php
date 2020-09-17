<?php
$this->title = "Новая специальность";
?>

<div class="container profile_page info_profile_page">
    <div class="row">
        <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px 30px;" class="white_bg_block">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Новая специальность</h2>
            </div>
            <form action="/specialties/add.html" parsley-validate method="post" id="addvac">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                       value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="input_form">
                        <span>Название специальности</span>
                        <input class="vacansy_title parsley-validated"
                               type="text" value="" placeholder="Название специальности"
                               name="Spec[title]"
                               parsley-required="true" parsley-error-message="Не забудьте название специальности"
                               parsley-trigger="change">
                    </div>
                    <div class="input_form">
                        <span>Профессиональная область</span>
                        <select class="currency cat_sel" required name="Spec[category_id]">
                            <option value="">Выбрать</option>
                            <?php foreach (\models\Categories::find()->where(['sub_id' => 0])->orderBy('sort')->all() as $k => $item) {
                                if ($sub = \models\Categories::findAll(['sub_id' => $item->category_id])) {
                                    foreach ($sub as $s => $c) { ?>
                                        <option value="<?= $c->category_id ?>">
                                            <?= $item->name . ' / ' . $c->name ?>
                                        </option>
                                    <?php }
                                } else { ?>
                                    <option value="<?= $item->category_id ?>">
                                        <?= $item->name ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="input_form">
                        <span>Опыт работы</span>
                        <input class="experience" type="number" min="0"
                               name="Spec[experience]"
                               value="" placeholder="8 лет">
                    </div>
                    <div class="input_form">
                        <span>Оплата</span>
                        <div class="salary">
                            <input type="number" name="Spec[price]" parsley-required="true" value="" min="0"
                                   placeholder="1000">
                            <select class="payment_type" name="Spec[type]" id="">
                                <option value="hour">В час</option>
                                <option value="day">В день</option>
                                <option value="month">В месяц</option>
                                <option value="piecework">Сдельная</option>
                            </select>

                            <select class="currency" name="Spec[currency]" id="">
                                <option value="RUB">РУБ</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>
                    <div class="input_form">
                        <span>Адрес места работы</span>
                        <input class="address" type="text" name="Spec[address]" id="searchAddress" value=""
                               placeholder="Укажите адрес">
                        <input type="hidden" id="lat" name="Spec[lat]">
                        <input type="hidden" id="lot" name="Spec[lot]">
                    </div>
                    <div style="padding: 20px 0 0;" class="input_form team">
                        <input class="check" type="checkbox" name="Spec[team]" id="team">
                        <label for="team">Бригада</label>
                    </div>
                    <div style="padding: 15px 0;" class="input_form publish">
                    <span class="publish_block">
                        <span>Скрыть</span>
                        <input class="check" type="checkbox" name="Spec[public]" id="publish">
                        <label for="publish">Опубликовать</label>
                    </span>
                    </div>
                    <div class="input_form">
                        <span>Описание</span>
                        <textarea rows="8" name="Spec[description]" placeholder="Описание специальности..."></textarea>
                    </div>
                </div>
                <div class="col-md-6 hidden-sm hidden-xs"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <a class="add_image" href="javascript:void (0)" onclick="$('#to_galery').click()">Добавить изображение</a>
                    <button type="submit" name="Spec[toGalery]" value="on" id="to_galery" style="display: none" class="float_left add_vacansy_btn">Перейти к фото
                    </button>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <a class="cancel" href="/">Отмена</a>
                    <button type="submit" style="float: left;" name="Spec[update]"
                            class="add_vacansy_btn">Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script defer src="/plugins/form/form.js">
    $(document).ready(function () {

        $("#addvac").submit(function (e) {
            e.preventDefault();
            if ($(this).parsley('validate')) {
                this.submit();
            }
        });

        //iCheck[components] validate
        $('input').on('ifChanged', function (event) {
            $(event.target).parsley('validate');
        });

    });
</script>
<script defer async>
    function initAutocomplete() {
        var input = document.getElementById('searchAddress');
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
            $('#lat').val(place.geometry.location.lat());
            $('#lot').val(place.geometry.location.lng());
        });
    };

</script>
<script defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI56UwMrhNrE4_FDt-Ks1lBhk2wBWxbBg&language=ru&libraries=places&callback=initAutocomplete">
</script>
<script>
    var phoneMask = IMask(
        document.getElementById('vacphone'), {
            mask: '+{7}(000)000-00-00'
        });
</script>
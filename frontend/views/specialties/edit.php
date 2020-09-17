<?php
$this->title = "Изменение специальности \"".$vac->title."\"";
?>

<div class="container profile_page info_profile_page">
    <div class="row">
        <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px 30px;" class="white_bg_block">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Специальность "<?=$vac->title?>"</h2>
            </div>
            <form action="/specialties/add.html" parsley-validate method="post" id="addvac">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                       value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                <input type="hidden" name="Spec[id]"
                       value="<?= $vac->id ?>"/>
                <input type="hidden" name="Spec[tmp]"
                       value="0"/>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="input_form">
                        <span>Наименование специальности</span>
                        <input class="vacansy_title parsley-validated"
                               type="text" value="<?= $vac->title ?>" placeholder="Название вакансии"
                               name="Spec[title]"
                               parsley-required="true" parsley-error-message="Не забудьте название ваканси"
                               parsley-trigger="change">
                    </div>
                    <div class="input_form">
                        <span>Профессиональная область</span>
                        <select class="currency cat_sel" required name="Spec[category_id]">
                            <option value="">Выбрать</option>
                            <?php foreach (\models\Categories::find()->where(['sub_id' => 0])->orderBy('sort')->all() as $k => $item) {
                                if ($sub = \models\Categories::findAll(['sub_id' => $item->category_id])) {
                                    foreach ($sub as $s => $c) { ?>
                                        <option  <?= $vac->category_id == $c->category_id ? 'selected' : '' ?> value="<?= $c->category_id ?>">
                                            <?= $item->name . ' / ' . $c->name ?>
                                        </option>
                                    <?php }
                                } else { ?>
                                    <option  <?= $vac->category_id == $item->category_id ? 'selected' : '' ?> value="<?= $item->category_id ?>">
                                        <?= $item->name ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="input_form">
                        <span>Опыт работы</span>
                        <input class="experience" type="number"
                               name="Spec[experience]"
                               value="<?= $vac->experience ?>" placeholder="8 лет">
                    </div>
                    <div class="input_form">
                        <span>Оплата</span>
                        <div class="salary">
                            <input type="number" name="Spec[price]" parsley-required="true" value="<?= $vac->price ?>" min="0"
                                   placeholder="1000">
                            <select class="payment_type" name="Spec[type]"  id="">
                                <option <?= $vac->type =='hour' ? 'selected' : '' ?> value="hour">В час</option>
                                <option <?= $vac->type =='day' ? 'selected' : '' ?> value="day">В день</option>
                                <option <?= $vac->type =='month' ? 'selected' : '' ?> value="month">В месяц</option>
                                <option <?= $vac->type =='piecework' ? 'selected' : '' ?> value="piecework">Сдельная</option>
                            </select>

                            <select class="currency" name="Spec[currency]" id="">
                                <option <?= $vac->currency =='RUB' ? 'selected' : '' ?> value="RUB">РУБ</option>
                                <option <?= $vac->currency =='USD' ? 'selected' : '' ?> value="USD">USD</option>
                                <option <?= $vac->currency =='EUR' ? 'selected' : '' ?> value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>
                    <div class="input_form">
                        <span>Адрес места работы</span>
                        <input class="address" type="text" name="Spec[address]" id="searchAddress" value="<?= $vac->address ?>"
                               placeholder="Укажите адрес">
                        <input type="hidden" id="lat" value="<?= $vac->lat ?>" name="Spec[lat]">
                        <input type="hidden" id="lot" value="<?= $vac->lot ?>" name="Spec[lot]">
                    </div>
                    <div style="padding: 20px 0 0;" class="input_form team">
                        <input class="check" type="checkbox" name="Spec[team]" <?= $vac->team ? 'checked':''?> id="team">
                        <label for="team">Бригада</label>
                    </div>
                    <div style="padding: 15px 0;" class="input_form publish">
                    <span class="publish_block">
                        <span>Скрыть</span>
                        <input class="check" type="checkbox" name="Spec[public]" <?= $vac->public ? 'checked':''?> id="publish">
                        <label for="publish">Опубликовать</label>
                    </span>
                    </div>
                    <div class="input_form">
                        <span>Описание</span>
                        <textarea rows="8" name="Spec[description]" placeholder="Описание вакансии..."><?=$vac->description?></textarea>
                    </div>
                </div>
                <div class="col-md-6 hidden-sm hidden-xs"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <a class="cancel" href="/">Отмена</a>
                    <button type="submit" style="float: left;" name="Spec[update]"
                            class="add_vacansy_btn">Сохранить
                    </button>
                </div>
            </form>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <span class="add_image_descr">Рекомендуется использовать JPG, GIF или PNG</span>
                <div class="dz-clickable">
                    <form action="/specialties/upload/ID<?= $vac->id?>.html" class="dropzone" id="profUpload">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                               value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                    </form>
                </div>
                <hr style="border-top: 3px solid #3D2B3B; margin-top: 50px !important;">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/plugins/dropupload/dropzone.js"></script>
<script>
    Dropzone.autoDiscover = false;
    $(".dropzone").dropzone({

        init: function() {
            myDropzone = this;
            $.ajax({
                url: '/specialties/getupload.html',
                type: 'post',
                data: {<?= Yii::$app->request->csrfParam; ?>:"<?= Yii::$app->request->getCsrfToken(); ?>" , id: <?=$vac->id?>},
            dataType: 'json',
                success: function(response){

                $.each(response, function(key,value) {
                    var mockFile = { name: value.name, size: value.size };

                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile, value.path);
                    myDropzone.emit("complete", mockFile);

                });

            }
        });
        }
    });
</script>

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
        console.log('fghd')
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

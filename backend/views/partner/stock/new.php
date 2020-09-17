<?php
?>

<div id="main">
    <div id="content">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel corner-flip">
                    <header class="panel-heading sm" data-color="theme-inverse">
                        <h2><strong>Акция</strong> создание</h2>
                        <?php if (!$affiliates) { ?> <strong>Отсутствуют филиалы</strong>   <a style="color: red"
                                                                                               href="/company/address">
                            Для начала создайте хотя бы
                            1н филиал компании</a>
                        <?php } ?>
                    </header>
                    <?php if ($affiliates) { ?>
                        <div class="panel-tools color" align="right" data-toolscolor="#4EA582">
                            <ul class="tooltip-area">
                                <li><a href="javascript:void(0)" class="btn btn-collapse" title=""
                                       data-original-title="Collapse"><i class="fa fa-sort-amount-asc"></i></a></li>
                                <li><a href="javascript:void(0)" class="btn btn-reload" title=""
                                       data-original-title="Reload"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="javascript:void(0)" class="btn btn-close" title=""
                                       data-original-title="Close"><i
                                                class="fa fa-times"></i></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="newStock" method="post" action="/stock/add" data-collabel="3" data-alignlabel="left">
                                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                       value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                                <div class="form-group">
                                    <label for="tariff" class="control-label col-md-3" style="text-align: left;">Тариф</label>
                                    <div class="col-md-9">
                                        <select id="tariff" name="StockModel[tarif]" class="form-control"
                                                                            required
                                                                            parsley-trigger="keyup"
                                                                            parsley-required="true">
                                            <option value="">Выбирите тариф</option>
                                            <option value="free">Free</option>
                                            <option value="pro">Pro</option>
                                            <option value="enterprise">Enterprise</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" style="text-align: left;">Категории</label>
                                    <div class="col-sm-9">
                                        <div id="check-error"></div>
                                        <?php foreach (\models\Categories::find()->where(['sub_id' => 0])->orderBy('sort')->all() as $k => $item) {
                                            if ($sub = \models\Categories::findAll(['sub_id' => $item->category_id])) {
                                                foreach ($sub as $s => $c) {
                                                    ?>
                                                    <div class="iCheck col-md-4" data-style="minimal" data-color="aero">
                                                        <label><input name="StockModel[category][]" value="<?= $c->category_id ?>"
                                                               parsley-trigger="keyup"
                                                               parsley-required="true"
                                                                      parsley-error-message="Выберете категорию"
                                                                      parsley-error-container="div#check-error"
                                                               type="checkbox">
                                                        <?= $item->name . ' / ' . $c->name ?></label>
                                                    </div>
                                                <?php }
                                            } else { ?>
                                                <div class="iCheck col-md-4" data-style="minimal" data-color="aero">
                                                    <label><input name="StockModel[category][]" value="<?= $item->category_id ?>"
                                                           parsley-trigger="keyup"
                                                           parsley-required="true"
                                                                  parsley-error-message="Выберете категорию"
                                                                  parsley-error-container="div#check-error"
                                                           type="checkbox">
                                                    <?= $item->name ?></label>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" style="text-align: left;">Краткое
                                        описание</label>
                                    <div class="col-md-9">
                                <textarea name="StockModel[description]" id="smalld" class="form-control"
                                          parsley-trigger="keyup"
                                          parsley-rangelength="[0,130]" parsley-required="true"
                                          rows="3"></textarea>
                                        <span id="smallinf" class="help-block">Осталось <a style="color: red"
                                                                                           href="#">130</a> символов <i
                                                    class="fa fa-info"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" style="text-align: left;">Полное
                                        описание</label>
                                    <div class="col-md-9">
                                        <textarea id="fulld" name="StockModel[full_description]" class="form-control"
                                                  parsley-trigger="keyup"
                                                  parsley-rangelength="[0,2000]" parsley-required="true"
                                                  rows="3"></textarea>
                                        <span id="fullinf" class="help-block">Осталось <a style="color: red"
                                                                                          href="#">2000</a> символов <i
                                                    class="fa fa-info"></i></span>
                                    </div>
                                </div>
                                <script>
                                    $('#smalld').on('input selectionchange propertychange', function (e) {
                                        if (130 - this.value.length >= 0) {
                                            $('#smallinf a')[0].innerText = 130 - this.value.length;
                                        } else {
                                            this.value = this.value.substr(0, 130);
                                        }
                                    })
                                    $('#fulld').on('input selectionchange propertychange', function (e) {
                                        if (2000 - this.value.length >= 0) {
                                            $('#fullinf a')[0].innerText = 2000 - this.value.length;
                                        } else {
                                            this.value = this.value.substr(0, 2000);
                                        }
                                    })
                                </script>
                                <div class="form-group">
                                    <label class="control-label col-md-3" style="text-align: left;">Филиалы </label>
                                    <div class="col-sm-9">
                                        <div id="affl-error"></div>
                                        <?php foreach ($affiliates as $k => $item) { ?>
                                            <div class="iCheck col-md-4" data-style="minimal" data-color="aero">
                                                <input name="StockModel[affiliate][]" value="<?= $item->affiliate_id ?>"
                                                       parsley-trigger="keyup"
                                                       parsley-required="true"
                                                       parsley-error-message="Выберете филиал"
                                                       parsley-error-container="div#affl-error"
                                                       type="checkbox">
                                                <label><?= $item->address . ($item->main ? ' (Основной)' : '') ?></label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> Начало акции </label>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div id="start-error"></div>

                                                <input parsley-trigger="keyup"
                                                       parsley-required="true"
                                                       parsley-error-message="Неверная дата конца акции"
                                                       parsley-error-container="div#start-error"
                                                       type="text" name="StockModel[date]"
                                                       class="form-control" id="daterange" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pro" hidden>
                                    <label class="control-label">Текст промокода</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="StockModel[promo]"
                                               parsley-error-message="Обязательное поле"
                                               parsley-trigger="keyup"
                                               parsley-rangelength="[4,12]"
                                               placeholder="Текст промокода">
                                    </div>
                                </div>
                                <div class="form-group pro" hidden>
                                    <label class="control-label">Ссылка на видео youtube.com</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="youtobe"
                                               oninput="getId()"
                                               parsley-trigger="keyup"
                                               parsley-error-message="Обязательное поле"
                                               parsley-rangelength="[4,255]"
                                               placeholder="Ссылка на видео youtube.com">
                                        <input type="hidden" class="form-control" id="youtobeh" name="StockModel[youtube]"
                                               parsley-trigger="keyup"
                                               parsley-error-message="Обязательное поле"
                                               parsley-rangelength="[4,255]"
                                               placeholder="Ссылка на видео youtube.com">
                                    </div>
                                    <script>
                                        function getId() {
                                            $.get('https://www.googleapis.com/youtube/v3/search/?key=AIzaSyC4C_O-MsiRI0lbaGchVdP6YEvBTmkr7VY&part=snippet&q=' + $('#youtobe').val(), function (data) {
                                                if (data.items.length !== 0)
                                                    $('#youtobeh').val(data.items[0].id.videoId);
                                                else
                                                    $('#youtobe').val()
                                            });
                                        }
                                    </script>
                                </div>
                                <div class="form-group pro" hidden>
                                    <label class="control-label">Фото акции</label>
                                    <div class="col-sm-12">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg1" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg1" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg1" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg2" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg2" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg2" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg3" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg3" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg3" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg4" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg4" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg4" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg5" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg5" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg5" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg6" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg6" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg6" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg7" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg7" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg7" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg8" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg8" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg8" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg9" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg9" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg9" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="simg10"
                                                 data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg10" name="StockModel[photo][]"/>
											<input type="file" class="loads" data-for="simg10" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pro enterprise" hidden>
                                    <label class="control-label">Банер</label>
                                    <div class="col-sm-12">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" id="banner" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="banner" name="StockModel[banner]"/>
											<input type="file" class="loads" data-for="banner" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group offset">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn btn-theme">Добавить</button>
                                        <button type="reset" class="btn">Сбросить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="flip"></div>
                    <?php } ?>
                </section>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function(){

        $("#newStock").submit(function(e){
            setPhoto();
            if(!$(this).parsley( 'validate' )){
                e.preventDefault();
            }
        });

        //iCheck[components] validate
        $('input').on('ifChanged', function(event){
            $(event.target).parsley( 'validate' );
        });

    });
    function setPhoto(){
        for (var i=1; i != 10; i++){
            if($('#simg' + i + ' img').length){
               $('input[for="simg' + i+'"]').val($('#simg' + i + ' img')[0].src)
            }
        }
        if($('#banner img').length){
            $('input[for="banner"]').val($('#banner img')[0].src)
        }
    }
    $('#tariff').on('change', function () {
        if (this.value == 'enterprise') {
            $('.pro , .enterprise').show()
        }
        if (this.value == 'pro') {
            $('.pro').show()
            $('.enterprise').hide()
        }
        if (this.value == 'free') {
            $('.pro , .enterprise').hide()
        }
    })
</script>
<style>
    .daterangepicker {
        top: 25% !important;
        max-width: none;
        z-index: 3000;
        font-family: Arial, sans-serif;
        font-size: 12px;
    }
</style>
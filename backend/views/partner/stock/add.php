<?php
$affiliates = \models\Affiliates::find()->where(['company_id' => Yii::$app->user->identity->company_id])->orderBy('main DESC')->all()
?>

<div id="main">
    <div id="content">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel corner-flip">
                    <header class="panel-heading sm" data-color="theme-inverse">
                        <h2><strong>Акция</strong> создание</h2>
                        <?php if (!$affiliates){ ?> <strong>Отсутствуют филиалы</strong>   <a style="color: red" href="/company/address">   Для начала создайте хотя бы
                            1н филиал компании</a>
                        <?php }?>
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
                            <form class="form-horizontal" data-collabel="3" data-alignlabel="left">
                                <div class="form-group">
                                    <label class="control-label col-md-3" style="text-align: left;">Тариф</label>
                                    <div class="col-md-9">
                                        <select id="tariff" class="form-control">
                                            <option value="free">FREE</option>
                                            <option value="pro">PRO</option>
                                            <option value="enterprise">Enterprise</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" style="text-align: left;">Категории</label>
                                    <div class="col-sm-9">
                                        <?php foreach (\models\Categories::find()->where(['sub_id' => 0])->orderBy('sort')->all() as $k => $item) {
                                            if ($sub = \models\Categories::findAll(['sub_id' => $item->category_id])) {
                                                foreach ($sub as $s => $c) {
                                                    ?>
                                                    <div class="iCheck col-md-4" data-style="minimal" data-color="aero">
                                                        <input name="Category[]" value="<?= $c->category_id ?>"
                                                               type="checkbox">
                                                        <label><?= $item->name . ' / ' . $c->name ?></label>
                                                    </div>
                                                <?php }
                                            } else { ?>
                                                <div class="iCheck col-md-4" data-style="minimal" data-color="aero">
                                                    <input name="Category[]" value="<?= $item->category_id ?>"
                                                           type="checkbox">
                                                    <label><?= $item->name ?></label>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" style="text-align: left;">Краткое
                                        описание</label>
                                    <div class="col-md-9">
                                <textarea id="smalld" class="form-control"
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
                                        <textarea id="fulld" class="form-control" rows="3"></textarea>
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
                                        <?php foreach ($affiliates as $k => $item) { ?>
                                            <div class="iCheck col-md-4" data-style="minimal" data-color="aero">
                                                <input name="Category[]" value="<?= $item->affiliate_id ?>"
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
                                            <div class="input-group date form_datetime col-lg-6"
                                                 data-picker-position="bottom-left"
                                                 data-date-format="dd MM yyyy - HH:ii p">
                                                <input type="text" class="form-control">
                                                <span class="input-group-btn">
																								<button class="btn btn-default"
                                                                                                        type="button"><i
                                                                                                            class="fa fa-times"></i></button>
																								<button class="btn btn-default"
                                                                                                        type="button"><i
                                                                                                            class="fa fa-calendar"></i></button>
																								</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Конец </label>
                                    <div>
                                        <div class="row">
                                            <div class="input-group date form_datetime col-lg-6"
                                                 data-picker-position="bottom-left"
                                                 data-date-format="dd MM yyyy - HH:ii p">
                                                <input type="text" class="form-control">
                                                <span class="input-group-btn">
																								<button class="btn btn-default"
                                                                                                        type="button"><i
                                                                                                            class="fa fa-times"></i></button>
																								<button class="btn btn-default"
                                                                                                        type="button"><i
                                                                                                            class="fa fa-calendar"></i></button>
																								</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pro" hidden>
                                    <label class="control-label">Текст промокода</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="SignUpForm[company]"
                                               parsley-trigger="keyup"
                                               parsley-rangelength="[4,12]" parsley-required="true"
                                               parsley-error-message="Обязательное поле"
                                               placeholder="Текст промокода">
                                    </div>
                                </div>
                                <div class="form-group pro" hidden>
                                    <label class="control-label">Ссылка на видео youtube.com</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="SignUpForm[company]"
                                               parsley-trigger="keyup"
                                               parsley-rangelength="[4,12]" parsley-required="true"
                                               parsley-error-message="Обязательное поле"
                                               placeholder="Ссылка на видео youtube.com">
                                    </div>
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
                                            <input type="hidden" for="simg1" name="logo"/>
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
                                            <input type="hidden" for="simg3" name="logo"/>
											<input type="file" class="loads" data-for="simg1" name="...">
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
                                            <input type="hidden" for="simg3" name="logo"/>
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
                                            <input type="hidden" for="simg4" name="logo"/>
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
                                            <input type="hidden" for="simg5" name="logo"/>
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
                                            <input type="hidden" for="simg6" name="logo"/>
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
                                            <input type="hidden" for="simg7" name="logo"/>
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
                                            <input type="hidden" for="simg8" name="logo"/>
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
                                            <input type="hidden" for="simg9" name="logo"/>
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
                                            <input type="hidden" for="simg10" name="logo"/>
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
                                            <div class="fileinput-preview thumbnail" id="simg1" data-trigger="fileinput"
                                                 style="width: 150px; height: 75px;">

                                            </div>
                                            <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Загрузить</span>
                                            <span class="fileinput-exists">Изменить</span>
                                            <input type="hidden" for="simg1" name="logo"/>
											<input type="file" class="loads" data-for="simg1" name="...">
                                        </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                   data-dismiss="fileinput">X</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group offset">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="button" class="btn btn-theme">Добавить</button>
                                        <button type="reset" class="btn">Сбросить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php }?>
                </section>
            </div>
        </div>

    </div>
</div>
<script>
    function loadimg(img) {
        var image = document.getElementById(img);//.children('img');
        console.log($(image));
        //$('#'+img).val(image[0].src);
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
        top: 50% !important;
        max-width: none;
        z-index: 3000;
        font-family: Arial, sans-serif;
        font-size: 12px;
    }
</style>
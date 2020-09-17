<?php
$affiliates = [];

foreach (\models\StockAffilate::find()->select(['cats.address' , 'main' , 'cats.affiliate_id'])->innerJoin('affiliates as cats' , 'cats.affiliate_id=stock_affiliate.affiliate_id')->where(['stock_id' => $stock->stock_id])->asArray()->all() as $k => $affl){
    $affiliates[$k] = $affl;
}
$category = [];
foreach (\models\StockCatgory::find()->select(['cats.name' , 'cats.category_id'])->innerJoin('categories as cats' , 'cats.category_id=stock_category.category_id')->where(['stock_id' => $stock->stock_id])->asArray()->all() as $k => $cat){
    $category[$k] = $cat;
}
?>

<section class="panel corner-flip">
    <header class="panel-heading sm" data-color="theme-inverse">
        <h2><strong>Акция</strong> создание</h2>

    </header>
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
            <form class="form-horizontal" id="newStock" method="post" action="/stock/update/" data-collabel="3" data-alignlabel="left">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                       value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                <input type="hidden" name="StockModel[stock_id]" value="<?= $stock->stock_id?>">
                <div class="form-group">
                    <label class="control-label">Теги акции </label>
                    <div>
                        <input type="text" class="form-control" id="taginputs"  name="StockModel[tags]" value="<?= $stock->tags?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Оценка администратора</label>
                    <div>
                        <select  class="selectpicker form-control" name="StockModel[moder_rating]">
                           <?php for ($i=1;$i!=8;$i++){?>
                               <option <?= $i == $stock->moder_rating ? ' selected="selected"' : ''?>value="<?= $i?>"><?= $i?></option>
                           <?php }?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tariff" class="control-label col-md-3" style="text-align: left;">Тариф</label>
                    <div class="col-md-9">
                        <input type="text" disabled id="tariff" value="<?=$stock->tarif?>" name="StockModel[tarif]" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3" style="text-align: left;">Категории</label>
                    <div class="col-sm-9">
                        <div id="check-error"></div>
                        <?php foreach ($category as $k => $item) {?>
                                <div class="iCheck col-md-4" data-style="minimal" data-color="aero">
                                    <label><input name="StockModel[category][]" disabled checked value="<?= $item['category_id'] ?>"
                                                  parsley-trigger="keyup"
                                                  parsley-required="true"
                                                  parsley-error-message="Выберете категорию"
                                                  parsley-error-container="div#check-error"
                                                  type="checkbox">
                                        <?= $item['name'] ?></label>
                                </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3" style="text-align: left;">Краткое
                        описание</label>
                    <div class="col-md-9">
                                <textarea disabled name="StockModel[description]" id="smalld" class="form-control"
                                          parsley-trigger="keyup"
                                          parsley-rangelength="[0,130]" parsley-required="true"
                                          rows="3"><?= $stock->description?></textarea>
                        <span id="smallinf" class="help-block">Осталось <a style="color: red"
                                                                           href="#">130</a> символов <i
                                class="fa fa-info"></i></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3" style="text-align: left;">Полное
                        описание</label>
                    <div class="col-md-9">
                                        <textarea disabled id="fulld" name="StockModel[full_description]" class="form-control"
                                                  parsley-trigger="keyup"
                                                  parsley-rangelength="[0,2000]" parsley-required="true"
                                                  rows="3"><?= $stock->full_description?></textarea>
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
                                <input checked disabled name="StockModel[affiliate][]" value="<?= $item['affiliate_id'] ?>"
                                       parsley-trigger="keyup"
                                       parsley-required="true"
                                       parsley-error-message="Выберете филиал"
                                       parsley-error-container="div#affl-error"
                                       type="checkbox">
                                <label><?= $item['address'] . ($item['main'] ? ' (Основной)' : '') ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"> Период акции </label>
                    <div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div id="start-error"></div>

                                <input disabled parsley-trigger="keyup"
                                       parsley-required="true"
                                       parsley-error-message="Неверная дата конца акции"
                                       parsley-error-container="div#start-error"
                                       type="text" name="StockModel[date]"
                                       class="form-control" id="daterange" value="<?= date('d/m/Y',$stock->start_date) . ' - ' . date('d/m/Y',$stock->end_date)?>"/>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="form-group" >
                    <label class="control-label">Текст промокода</label>
                    <div class="col-sm-6">
                        <input type="text" disabled class="form-control" name="StockModel[promo]"
                               parsley-error-message="Обязательное поле"
                               parsley-trigger="keyup"
                               parsley-rangelength="[4,12]"
                               placeholder="Текст промокода" value="<?= $stock->promo?>">
                    </div>
                </div>
                <div class="form-group" >
                    <label class="control-label">Ссылка на видео youtube.com</label>
                    <div class="col-sm-6">
                        <input disabled type="text" class="form-control" name="StockModel[youtube]"
                               parsley-trigger="keyup"
                               parsley-error-message="Обязательное поле"
                               parsley-rangelength="[4,255]"
                               placeholder="Ссылка на видео youtube.com" value="<?=$stock->youtube?>">
                    </div>
                </div>
                <div class="form-group" >
                    <label class="control-label">Фото акции</label>
                    <div class="col-sm-12">
                        <?php if ($stock->photo != '' && is_array(json_decode($stock->photo))){
                            foreach (json_decode($stock->photo) as $k => $ph){
                            ?>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" id="banner" data-trigger="fileinput"
                                     style="width: 150px; height: 75px;">
                                        <img src="<?= $ph?>" />
                                </div>
                            </div>
                        <?php }
                        }?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Банер</label>
                    <div class="col-sm-12">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" id="banner" data-trigger="fileinput"
                                     style="width: 150px; height: 75px;">
                                    <img src="<?= $stock->banner?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group offset">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" name="StockModel[status]" value="inprogress" class="btn btn-theme">Одобрить</button>
                        <button type="submit" name="StockModel[status]" value="arhive" class="btn">Отменить</button>
                    </div>
                </div>
            </form>
        </div>
</section>

<script defer>
    //$(function() {
    //  $("input#taginput").tagsinput();
    $('input#taginputs').tagsinput();
    //});
</script>
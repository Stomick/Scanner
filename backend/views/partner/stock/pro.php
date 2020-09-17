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

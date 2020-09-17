<?php
?>
<div id="main">

    <ol class="breadcrumb">
        <li><a href="#">Главная</a></li>
        <li><a href="/article">Статьи</a></li>
        <li class="active">Создание статьи</li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">

        <div class="row">

            <div class="col-lg-12">
                <section class="panel corner-flip">
                    <div class="panel-tools color" align="right" data-toolscolor="#4EA582">
                        <ul class="tooltip-area">
                            <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i
                                            class="fa fa-sort-amount-asc"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-reload" title="Reload"><i
                                            class="fa fa-retweet"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i
                                            class="fa fa-times"></i></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" id="fcatadd" data-collabel="3" data-alignlabel="left">
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                   value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                            <div class="form-group">
                                <label class="control-label">Колонка</label>
                                <div>
                                    <select class="form-control" name="Article[colum]" required>
                                        <option value="">Выбрать колонку</option>
                                        <option <?= $cat->colum == 1 ? 'selected' : ''?> value="1">1</option>
                                        <option <?= $cat->colum == 2 ? 'selected' : ''?> value="2">2</option>
                                        <option <?= $cat->colum == 3 ? 'selected' : ''?> value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Сортировка</label>
                                <div>
                                    <select class="form-control" name="Article[sort]" required>
                                        <option value="">Выбрать</option>
                                        <?php for ($i = 0; $i<10;$i++){?>
                                            <option <?= $cat->sort == $i ? 'selected' : ''?> value="<?=$i?>"><?=$i?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Название</label>
                                <div>
                                    <input type="text" name="Article[title]" class="form-control rounded" required value="<?=$cat->title?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea cols="80" required id="editorCk" name="Article[text]" rows="10" style="visibility: hidden; display: none;"><?=$cat->text?></textarea>
                            </div>
                            <div class="form-group offset">
                                <div>
                                    <button type="button" id="addcat" class="btn btn-theme">Обновить</button>
                                    <button type="reset" onclick="location.href='/article'" class="btn">Отмена</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    // Call CkEditor
    $('#addcat').click(function () {
        $('#fcatadd').submit();
    });
    CKEDITOR.replace( 'editorCk', {
        startupFocus : false,
        uiColor: '#FFFFFF'
    });

</script>
<?php
?>
<div id="main">

    <ol class="breadcrumb">
        <li><a href="#">Главная</a></li>
        <li><a href="/categories">Категории</a></li>
        <li class="active">Создание категории</li>
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
                        <form class="form-horizontal" method="post" action="/categories/edit/<?= $cat->category_id?>" id="fcatadd" data-collabel="3" data-alignlabel="left">
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                   value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                            <div class="form-group">
                                <label class="control-label">Родительская категория</label>
                                <div>
                                    <select class="form-control" name="Category[sub]">
                                        <option value="">Выбрать категорию</option>
                                        <?php foreach (\models\Categories::findAll(['sub_id' => 0]) as $k => $categories) { ?>
                                            <option <?= $cat->sub_id == $categories->category_id ? 'selected' : ''?> value="<?= $categories->category_id ?>"><?= $categories->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Название</label>
                                <div>
                                    <input type="text" name="Category[name]" class="form-control rounded" value="<?= $cat->name?>" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                             style="width: 200px; height: 150px;">
                                            <img src="<?= $cat->icon ? $cat->icon: ''?>">
                                        </div>
                                        <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Выбпать лого</span>
                                            <span class="fileinput-exists">Сбросить</span>
                                            <input type="hidden" id="log_category" name="Category[icon]"/>
                                            <input type="file" multiple="false"/>
                                        </span>
                                            <a href="#" class="btn btn-default fileinput-exists"
                                               data-dismiss="fileinput">Удалить</a>
                                        </div>
                                    </div><!-- //fileinput-->

                                </div>
                            </div>
                            <div class="form-group offset">
                                <div>
                                    <button type="button" id="addcat" class="btn btn-theme">Сохранить</button>
                                    <button type="reset" class="btn">Отмена</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
    $('#addcat').click(function () {
        var image = $('.fileinput-preview').children('img');
        $('#log_category').val(image[0].src);
        $('#fcatadd').submit();
    })
</script>
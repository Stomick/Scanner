<?php
$this->title = $company->name;
?>

<div id="main">
    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
        <li class="active"><?=$company->name?></li>
    </ol>
    <!-- //breadcrumb-->
    <div id="content">

        <div class="row">
            <div class="col-lg-12" >
                <section class="panel">
                    <div class="panel-body">
                        <form id="formID" method="post" enctype="multipart/form-data" class="form-" data-collabel="3" data-alignlabel="right"  data-parsley-validate>
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                   value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                            <div class="form-group">
                                <div>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                            <img src="<?= $company->url ? $company->url: ''?>">
                                        </div>
                                        <div>
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Выбпать лого</span>
                                            <span class="fileinput-exists">Сбросить</span>
                                            <input type="hidden" id="log_company" name="logo"/>
                                            <input type="file" id="logo_company" multiple=""/>
                                        </span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Удалить</a>
                                        </div>
                                    </div><!-- //fileinput-->

                                </div>
                            </div><!-- //form-group-->

                            <div class="form-group offset">
                                <div>
                                    <button type="button" id="changecomp" class="btn btn-theme">Сохранить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>

            <div class="row">
                <div class="col-lg-12" >
                    <section class="panel">
                        <div class="panel-body">
                            <?php include 'map.php' ?>
                        </div>
                    </section>
                </div>
            </div>
    </div>
</div>
<script>
    $('#changecomp').click(function () {
        var image = $('.fileinput-preview').children('img');
        console.log(image[0].src);
        $('#log_company').val(image[0].src);
        $('#formID').submit();
    })
</script>

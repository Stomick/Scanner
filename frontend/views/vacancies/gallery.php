<?php
$this->title = 'Добавление фото'
?>
<div class="container">
    <div id="portfolio" class="row portfolio">
        <div >
            <a class="save_profile_btn" href="/vacancies/all.html">Сохранить</a>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dz-clickable">
                <form action="/vacancies/upload/ID<?= $vacId?>.html" class="dropzone" id="profUpload">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                           value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                </form>
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
                url: '/vacancies/getupload.html',
                type: 'post',
                data: {<?= Yii::$app->request->csrfParam; ?>:"<?= Yii::$app->request->getCsrfToken(); ?>" , id: <?=$vacId?>},
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


<?php
?>
<div role="tabpanel" class="tab-pane active" id="tab3">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 input_row pad_mobile_none">
            <div class="white_bg_block">
                <h2>О себе</h2>
                <p>Личные качества, любая дополнительная информация.</p>
                <form action="/profile/update.html" autocomplete="off" parsley-validate method="post" id="profupdate">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                           value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                    <textarea name="Prof[description]"
                              rows="10" placeholder="Информация обо мне..."><?= $prof->description ?></textarea>
                    <input class="save_profile_btn" id="prfupdate" type="button" value="Сохранить"/>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/plugins/form/form.js"></script>
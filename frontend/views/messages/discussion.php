<?php
$this->title = "Переписка " . $type . ' "' . $info->title . '"';
$typeWork = [
    'hour' => 'В час',
    'day' => 'В день',
    'month' => 'В месяц',
    'piecework' => 'Договорная'
];
?>

<div class="hidden" id="page_id" data-id="<?= isset($page_id) ? $page_id : 123 ?>"></div>
<div class="hidden" id="user_id" data-id="<?= Yii::$app->user->id ?>"></div>

<div class="container profile_page info_profile_page">
    <div class="row">
        <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px 30px;" class="white_bg_block">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2 style="margin-bottom: 10px">Тема: "<?= $info->title ?>"</h2>
                <a class="to_all_mess title_link" href="/profile/messages.html">К списку сообщений</a>
                <span class="vacansies_number"><?= $type ?> №  <?= $info->id ?></span>
                <div style="margin-bottom: 30px" class="head_block">
                    <div id="head_block_add">
                        <div class="row">
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <span class="salary">
                                    <?= $info->type == 'piecework' ? $typeWork[$info->type] : $info->price . ' ' . $info->currency . ' ' . $typeWork[$info->type] ?>
                                </span>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <?php $user = \models\MUser::findOne($info->muser_id) ?>
                                <span style="color: #816A7E;" class="company_title">
                                    <?= $user->company ?>
                                </span>
                            </div>
                            <div class="col-md-6 hidden-sm hidden-xs"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="vac_descr_block">
                                    <span>Описание вакансии:</span>
                                    <p style="border-bottom: none">
                                        <?= $info['description']?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <p style="font-weight: 500; color: #3D2B3B;">
                                    <?php if ($cat = \models\Categories::findOne($info->category_id)) {
                                        echo $cat->name;
                                    } ?>
                                </p>
                                <p>
                                    <span>
                                        Опыт работы
                                    </span>
                                    <span>
                                        <?= $info->experience ?> лет
                                    </span>
                                </p>
                                <p>
                                    <span>
                                        Оплата
                                    </span>
                                    <span>
                                        <?= $info->type == 'piecework' ? $typeWork[$info->type] : $info->price . ' ' . $info->currency . ' ' . $typeWork[$info->type] ?>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 hidden-sm hidden-xs"></div>
                        </div>
                    </div>
                </div>
                <span id="showhide" class="height_btn">Свернуть описание</span>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="chat_inner_text" class="one_message_block">
                </div>
                <div class="new_message_block">
                    <div id="typinginfo"></div>
                    <div>
                        <div id="mtext" placeholder="Текст сообщения ..." contenteditable="true"
                             class="input_text_block"><?=$message?></div>
                    </div>
                    <div class="img_block">
                        <div id="uploadimg">

                        </div>
                        <div class="add_img_block">
                            <input class="inputfile" onchange="previewFile()" id="loadimg" accept="image/*" multiple
                                   name="file" type="file">
                            <label for="loadimg"><img src="/img/01JS-icon-clip.png" alt="load"> Прикрепить файлы</label>
                        </div>
                    </div>
                    <button style="margin: 30px 0;" class="send_message">Отправить</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/js/chat.js?v=1.2"></script>
<script>

    $(document).ready(function () {
        $('#showhide').click(function (e) {
            $('#head_block_add').slideToggle(300, function () {
                var txt = $('#' + e.target.id).text();
                $('#' + e.target.id).text(txt == 'Свернуть описание вакансии' ? 'Показать описание вакансии' : 'Свернуть описание вакансии');
            });
        });
    });

    function previewFile() {
        var file = document.getElementById('loadimg').files;
        for (var i = 0, f; i < file.length; i++) {
            f = file[i];
            var reader = new FileReader();
            reader.onload = (function (theFile) {
                return function (e) {
                    // Render thumbnail.
                    var span = document.getElementById('uploadimg');
                    var image = document.createElement('img');
                    var block = document.createElement('div');
                    image.src = e.target.result;
                    image.className = 'upphoto';
                    block.className = 'afterImage';
                    block.appendChild(image);
                    span.appendChild(block);
                    block.addEventListener("click", removeImg)
                };
            })();

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }

        /*
                if (file) {
                    //reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                }

         */
    }

    function removeImg() {
        this.remove();
    }

    jQuery(function ($) {
        $(".input_text_block").focusout(function () {
            var element = $(this);
            if (!element.text().replace(" ", "").length) {
                element.empty();
            }
        });
    });

</script>
<script src="/dist/jquery.fancybox.js"></script>




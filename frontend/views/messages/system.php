<?php
$this->title =  $type ;
?>
<div class="hidden" id="token" data-id="<?= Yii::$app->user->identity->getAuthKey()?>"></div>
<div class="hidden" id="page_id" data-id="<?= isset($page_id)?$page_id:123 ?>"></div>
<div class="hidden" id="user_id" data-id="<?=Yii::$app->user->id?>"></div>

<div class="container profile_page info_profile_page">
    <div class="row">
        <div style="margin-bottom: 15px" class="white_bg_block mob_tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation">
                    <a href="/profile/messages.html">Сообщения</a>
                </li>
                <li role="presentation" class="active">
                    <a href="/profile/system.html">Системные уведомления</a>
                </li>
            </ul>
        </div>

        <div style="overflow: hidden; margin: 0 0px ; padding: 0px 0px;" class="white_bg_block">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2 style="margin-bottom: 10px">Переписка с Jobscanner
                    
                </h2>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="chat_inner_text" class="one_message_block">

                    </div>

                    <div class="new_message_block">
                        <div id="typinginfo"></div>
                        <div>
                            <div id="mtext" placeholder="Текст сообщения ..." contenteditable="true"
                                 class="input_text_block"></div>
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
</div>

<script src="/js/chat.js?v=1.2"></script>
<script>

    $(document).ready(function () {
        $('#showhide').click(function (e) {
            $('#head_block_add').slideToggle(300, function () {
                var txt = $('#' + e.target.id).text();
                $('#' + e.target.id).text(txt == 'Показать подробности' ? 'Скрыть подробности' : 'Показать подробности');
            });
        });
    });

    function previewFile() {
        var file    = document.getElementById('loadimg').files;
        for (var i=0 , f;i<file.length;i++){
            f = file[i];
            var reader  = new FileReader();
            reader.onload = (function (theFile) {
                return function (e) {
                    // Render thumbnail.
                    var span = document.getElementById('uploadimg');
                    var image = document.createElement('img');
                    var block = document.createElement('div');
                    image.src = e.target.result;
                    image.className = 'upphoto';
                    block.className='afterImage';
                    block.appendChild(image);
                    span.appendChild(block);
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

    jQuery(function($){
        $(".input_text_block").focusout(function(){
            var element = $(this);
            if (!element.text().replace(" ", "").length) {
                element.empty();
            }
        });
    });

</script>
<script src="/dist/jquery.fancybox.js"></script>




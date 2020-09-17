<?php
$this->title = "Мои сообщения";
?>

<div class="container messages messages_index">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="messages_type_block">
                <span>
                    <input type="radio" checked id="job_mess" name="message_type" value="0">
                    <label class="job_mess" for="job_mess">Вакансии</label>
                </span>
                <span>
                    <input type="radio" id="feedback_mess" name="message_type" value="1">
                    <label class="feedback_mess" for="feedback_mess">Работы</label>
                </span>
                <span>
                    <input type="radio" id="system_mess" name="message_type" value="sytem">
                    <label class="system_mess" for="system_mess">Системные</label>
                </span>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <span class="sorting_by_price">
            <?= $sort->link('type') . " | " . $sort->link('date') . " | " . $sort->link('new'); ?>
            </span>
        </div>
        <hr>
    </div>
    <?php foreach ($messages as $mess){
        //print_r($mess['newmess']);
        ?>
    <div class="messages_block">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <span class="left_text">
                   <?= $mess['type']=='system' ?'Системное сообщение' : ((int)$mess['newmess'] ? 'Новое сообщение <span style="color: red">('.$mess['newmess'].')</span>': 'Последнее сообщение') ?><br>
                   <?=date('m.d.Y' , strtotime($mess['date'])) ?><br>
                   <?=date('H:i' , strtotime($mess['date'])) ?>
                </span>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <img src="<?= $mess['type'] == 'system' ?'/img/jobscanner.jpg': $mess['logo']?>" alt="logo" class="user_logo">
                <span class="name"><?=$mess['type'] == 'system' ? 'Системное сообщение': $mess['name'] ?></span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <a class="del_message" href="#" title="Удалить переписку">
                    <i class="fas fa-times"></i>
                </a>
                <p>
                    <?= $mess['text']?>
                </p>
                <a class="link_mess" href="/<?=$mess['type']?>/chat/ID<?=$mess['type_id']?>.html"><?= $mess['mid'] != Yii::$app->user->id && !$mess['newmess']? 'Ответить':'См. переписку'?></a>
            </div>
        </div>
    </div>
    <?php }?>
    <?php echo \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
    ]);?>
</div>


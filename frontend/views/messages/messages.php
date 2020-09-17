<?php
$this->title = "Мои сообщения";
$type = [
    'hour' => 'В час',
    'day' => 'В день',
    'month' => 'В месяц',
    'piecework' => 'Договорная'
];
$curr = [
    'RUB' => "₽",
    'EUR' => "€",
    'USD' => "$"
];

?>

<div class="container profile_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div style="margin-bottom: 15px" class="white_bg_block mob_tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Сообщения</a>
                    </li>
                    <li role="presentation">
                        <a href="/profile/system.html">Системные уведомления</a>
                    </li>
                </ul>
            </div>


            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="tab1">
                    <div class="row">
                        <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px 30px;"
                             class="white_bg_block">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h2>Сообщения
                                    <?php if (count($messages)) { ?>
                                        <span class="sorting_by_price">
                                                <?= $sort->link('type') . " | " . $sort->link('date') . " | " . $sort->link('new'); ?>
                                            </span>
                                    <?php } else { ?>
                                        <h4 style="margin: auto 0; text-align: center"><?= !Yii::$app->user->identity->type ? 'На Ваши специальноти нет откликов' : 'Вы не оставили ни одного отклика' ?></h4>
                                    <?php } ?>
                                </h2>
                            </div>
                            <?php foreach ($messages as $mess) {
                                $vac= $mess['type'] == 'vacancies' ? \models\Vacancies::findOne($mess['type_id']) : \models\Specialties::findOne($mess['type_id']);
                                ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="messages_block">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-12 col-xs-12">
                                            <span>
                                                <?= $mess['type'] == 'system' ? 'Системное сообщение' : ((int)$mess['newmess'] ? 'Новое сообщение <span style="color: red">(' . $mess['newmess'] . ')</span>' : 'Последнее сообщение') ?><br>
                                               <?= date('m.d.Y', strtotime($mess['date'])) ?>,
                                               <?= date('H:i', strtotime($mess['date'])) ?>
                                            </span>
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                <div class="second_col">
                                                    <span><?= $mess['type'] == 'vacancies' ? 'Вакансия' : 'Специальность'?> : <?= $mess['title']?></span><br>
                                                    <span><?= $mess['type'] != 'vacancies' ? 'Компания : '.  $mess['company'] : 'Пользователь : ' . $mess['name'] ?></span><br>
                                                    <span class="underline cursive red"><?= $vac->type =='piecework' ? $type[$vac->type] : $vac->price . ' ' . $curr[$vac->currency] . ' ' .  $type[$vac->type]?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-sm-12 col-xs-12">
                                                <p>
                                                    <?= $mess['photo'] == '' ? $mess['text'] : '<img style="width: 100px;margin: 0 auto;display: block;" src="' .$mess['photo'].'"/>' ?>
                                                </p>
                                            </div>
                                            <div class="col-md-2 col-sm-12 col-xs-12">
                                                <a class="link_mess"
                                                   href="/<?= $mess['type'] ?>/chat/CHAT<?= $mess['room_id'] ?>.html"><?= $mess['mid'] != Yii::$app->user->id && !$mess['newmess'] ? 'Ответить' : 'Переписка' ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab2">
                    <div class="row">
                        <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px 30px;"
                             class="white_bg_block">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h2>Уведомления
                                    <?php if (count($messages)) { ?>
                                        <span class="sorting_by_price">
                                                <?= $sort->link('type') . " | " . $sort->link('date') . " | " . $sort->link('new'); ?>
                                            </span>
                                    <?php } else { ?>
                                        <h4 style="margin: auto 0; text-align: center"><?= Yii::$app->user->identity->type == 0 ? 'Вы не получили новых откликов' : 'Вы не оставили ни одного отклика' ?></h4>
                                    <?php } ?>
                                </h2>
                            </div>
                            <?php foreach ($messages as $mess) {
                                //print_r($mess['newmess']);
                                ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="messages_block">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-12 col-xs-12">
                                            <span>
                                               <?= date('m.d.Y', strtotime($mess['date'])) ?>,
                                               <?= date('H:i', strtotime($mess['date'])) ?>
                                            </span>
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                <div class="second_col">
                                                    <img src="/img/JS-sighn03.jpg" alt="logo">
                                                    <span>Jobscanner</span>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-sm-12 col-xs-12">
                                                <p>
                                                    <?= $mess['text'] ?>
                                                </p>
                                            </div>
                                            <div class="col-md-2 col-sm-12 col-xs-12">
                                                <a class="link_mess"
                                                   href="/<?= $mess['type'] ?>/chat/ID<?= $mess['type_id'] ?>.html"><?= $mess['mid'] != Yii::$app->user->id && !$mess['newmess'] ? 'Ответить' : 'Переписка' ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
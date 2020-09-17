<?php
$this->title = 'Вакансии (Архив)';
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
        <div role="tabpanel" class="tab-pane active" id="tab2">
            <div class="info_profile_page">
                <div class="row">
                    <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px 30px;" class="white_bg_block">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2>Вакансии
                            </h2>
                        </div>
                        <?php foreach ($vacancies as $k => $vac) { ?>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div style="margin-bottom: 30px;">
                                    <p>
                                        <span>Профессиональная область</span>
                                        <span><?= $vac->title ?></span>
                                    </p>
                                    <p>
                                        <span>Опыт работы</span>
                                        <span><?= $vac->experience ?></span>
                                    </p>
                                    <p>
                                        <span>Занятость</span>
                                        <span>Test</span>
                                    </p>
                                    <p>
                                        <span>Оплата</span>
                                        <span class="underline cursive red"><?= $vac->type =='piecework' ? $type[$vac->type] : $vac->price . ' ' . $curr[$vac->currency] . ' ' .  $type[$vac->type]?></span>
                                    </p>

                                </div>
                            </div>
                            <div class="col-md-6 hidden-sm hidden-xs"></div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="descr">
                                    <p>Описание</p>
                                </div>
                                <p>
                                    <?= $vac->description ?>
                                </p>
                                <div class="link_block">
                                    <a class="del_link" href="/vacancies/info/ID<?= $vac->id ?>.html">Подробнее</a>
                                </div>
                                <hr style="border-top: 3px solid #3D2B3B;">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
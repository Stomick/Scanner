<?php
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
$this->title = "Вакансии ";
?>

<div role="tabpanel" class="tab-pane active" id="tab2">
    <div class="info_profile_page vac_mob">
        <div class="row">
            <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px 30px;" class="white_bg_block">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h2>Вакансии
                    </h2>
                </div>
                <?php foreach ($vacans as $k => $vac){?>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div style="margin-bottom: 30px;">
                        <p>
                            <span>Вакансия</span>
                            <span><?= $vac->title ?></span>
                        </p>
                        <p>
                            <span>Профессиональная область</span>
                            <span><?php if ($cat = \models\Categories::findOne($vac->category_id)) {
                                    echo $cat->name;
                                } ?></span>
                        </p>
                        <p>
                            <span>Опыт работы</span>
                            <span><?= $vac->experience ?></span>
                        </p>
                        <p>
                            <span>Оплата</span>
                            <span><?= $vac->type =='piecework' ? $type[$vac->type] : $vac->price . ' ' . $curr[$vac->currency] . ' ' .  $type[$vac->type]?></span>
                        </p>
                        <p>
                            <span>Описание</span>
                            <span><?= $vac->description?></span>
                        </p>
                    </div>
                </div>
                <div class="col-md-6 hidden-sm hidden-xs"></div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="link_block">
                        <a class="more" href="/vacancies/info/ID<?=$vac->id?>.html">Подробнее</a>
                    </div>
                    <hr style="border-top: 3px solid #3D2B3B;">
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<?php
$this->title = 'Вакансии';
$type = [
    'hour' => 'В час',
    'day' => 'В день',
    'month' => 'В месяц',
    'piecework' => 'Договорная'
];
?>
<div class="container vacansies_page">
    <div class="row">
        <?php foreach ($vacancies as $v => $vac) { ?>
            <div class="vacansy_block">
                <h2>
                    <span class="number"><?= $v + 1 ?>. </span>
                    <?= $vac->title ?>
                </h2>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <span class="experience">
                        <span>Опыт:</span>
                        <span class="underline"><?= $vac->experience ?></span>
                        <span>лет</span>
                    </span>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <span class="salary">
                        <span>Оплата:</span>
                        <span class="underline cursive red"><?= $vac->type == 'piecework' ? $type[$vac->type] : $vac->price . '.руб ' . $type[$vac->type] ?></span>
                    </span>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <span class="salary">
                        <span>Бригада:</span>
                        <span class="underline"><?= $vac->team ? 'Есть' : 'Нет' ?></span>
                    </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <span class="category_group">
                        Категория : <?php if ($cat = \models\Categories::findOne($vac->category_id)) {
                            echo $cat->name;
                        } ?>
                    </span>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <span>
                        Адрес:
                        <span class="">
                            <?= $vac->address ?>
                        </span>
                    </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <span>
                        Описание:
                        <span class="border_bottom cursive">
                            <?= $vac->description ?>
                        </span>
                    </span>
                    </div>
                </div>
                <?php if ($photos = \models\Photos::findAll(['type' => 'vacancies', 'type_id' => $vac->id, 'user_id' => $vac->muser_id])) {
                    ?>
                    <section class="regular_<?= $v ?> slider">
                        <?php foreach ($photos as $k => $photo) { ?>
                            <div class="slide_img_block">
                                <img class="" src="<?= $photo->url ?>"/>
                            </div>
                        <?php } ?>
                    </section>
                <?php } ?>
                <script type="text/javascript">
                    $(document).on('ready', function () {
                        $(".regular_<?=$v?>").slick({
                            dots: true,
                            infinite: true,
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            responsive: [
                                {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 4,
                                        slidesToScroll: 1,
                                    }
                                },
                                {
                                    breakpoint: 780,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1
                                    }
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1
                                    }
                                }]
                        });
                    });
                </script>
                <br>
                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->type) { ?>
                    <a class="edit_vacansy" href="/vacancies/edit/ID<?= $vac->id ?>.html">Редактировать вакансию</a>
                <?php } else { ?>
                    <a class="edit_vacansy" href="/vacancies/info/ID<?= $vac->id ?>.html">Подробнее</a>
                <?php } ?>
            </div>
        <?php } ?>
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    </div>
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->type == 1) { ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <a class="add_vacansy_btn" href="/vacancies/add.html">Добавить вакансию</a>
            </div>
        </div>
    <?php } ?>
</div>


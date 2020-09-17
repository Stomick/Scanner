<?php
$this->title = 'Специальности';
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
<div class="container vacansies_page">
    <div class="row">
        <?php foreach ($specialties as $v => $spec){ ?>
            <div class="vacansy_block">
                <h2>
                    <span class="number"><?= $v + 1?>. </span>
                    <?= $spec->title ?>
                </h2>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <span class="experience">
                        <span>Опыт:</span>
                        <span class="underline"><?= $spec->experience ?></span>
                        <span>лет</span>
                    </span>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <span class="salary">
                        <span>Оплата:</span>
                        <span class="underline cursive red"><?= $spec->type =='piecework' ? $type[$spec->type] : $spec->price . ' ' . $curr[$spec->currency] . ' ' .  $type[$spec->type]?></span>
                    </span>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <span class="salary">
                        <span>Бригада:</span>
                        <span class="underline"><?= $spec->team ? 'Есть' : 'Нет' ?></span>
                    </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <span class="category_group">
                        Категория : <?php if($cat = \models\Categories::findOne($spec->category_id)){ echo $cat->name;} ?>
                    </span>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <span>
                        Адрес:
                        <span class="">
                            <?= $spec->address ?>
                        </span>
                    </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <span>
                        Описание:
                        <span class="border_bottom cursive">
                            <?= $spec->description ?>
                        </span>
                    </span>
                    </div>
                </div>
                <?php if ($photos = \models\Photos::findAll(['type' => 'specialties' , 'type_id' => $spec->id , 'user_id' => $spec->muser_id])){
                    ?>
                    <section class="regular_<?= $v?> slider">
                        <?php foreach ($photos as $k => $photo){?>
                            <div class="slide_img_block">
                                <img class="" src="<?= $photo->url?>"/>
                            </div>
                        <?php } ?>
                    </section>
                <?php }?>
                <script type="text/javascript">
                    $(document).on('ready', function() {
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
                <?php if(!Yii::$app->user->isGuest && $spec->muser_id == Yii::$app->user->id){?>
                    <a class="edit_vacansy" href="/specialties/edit/ID<?= $spec->id?>.html">Редактировать специальность</a>
                <?php }else {?>
                    <a class="edit_vacansy" href="/specialties/info/ID<?= $spec->id?>.html">Подробнее</a>
                <?php } ?>
            </div>
        <?php }?>
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]);?>
    </div>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->type == 0){?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <a class="add_vacansy_btn" href="/specialties/add.html">Добавить специальность</a>
        </div>
    </div>
    <?php }?>
</div>


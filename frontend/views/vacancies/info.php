<?php
$this->title = 'Специальности';
?>
<?php
$type = [
    'hour' => 'В час',
    'day' => 'В день',
    'month' => 'В месяц',
    'piecework' => 'Договорная'
];
?>
<div class="container profile_page info_profile_page">
    <div class="row">
        <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px;" class="white_bg_block">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2><span class="title_vac_spec"><?= $vac->title?></span>
                    <span class="mob_link_block">
                    <?php if ($vac->muser_id == Yii::$app->user->id) { ?>
                        <a href="/vacancies/edit/ID<?= $vac->id ?>.html">Изменить</a>
                    <?php } ?>
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id != $vac->muser_id) { ?>
                            <a href="/vacancies/chat/ID<?= $vac->id ?>.html">Написать сообщение</a>
                        <?php } else { ?>
                        <?php } ?>
                    <a class="link_mob"
                       href="/profile/vacancies/ID<?= $vac->muser_id ?>.html">К списку вакансий</a>
                    </span>
                </h2>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div style="margin-bottom: 30px"><i class="fas fa-eye"></i>  <span style="color: green">
                                <?= \models\ViewsVac::find()->where(['vac_id'=> $vac->id])->asArray()->count()?>
                            </span> | Сегодня <span style="color: red">
                                <?= \models\ViewsVac::find()->where(['vac_id'=>$vac->id])->andWhere(
                                    'created_at > ' . strtotime( date("Y-m-d"))
                                    . " AND created_at < " . strtotime( date("Y-m-d") . 1  ." day" ))->asArray()->count()?>
                            </span>
                </div>
                <div style="margin-bottom: 30px;">
                    <p>
                        <span>Компания</span>
                        <span><?php if($us = \models\MUser::findOne($vac->muser_id)){ echo $us->company? $us->company:$us->name;} ?></span>
                    </p>
                    <p>
                        <span>Профессиональная область</span>
                        <span><?php if($cat = \models\Categories::findOne($vac->category_id)){ echo $cat->name;} ?></span>
                    </p>
                    <p>
                        <span>Опыт работы</span>
                        <span><?= $vac->experience ?> лет</span>
                    </p>
                    <p>
                        <span>Оплата</span>
                        <span><?= $vac->type =='piecework' ? $type[$vac->type] : $vac->price . ' ' .$vac->currency .' ' . $type[$vac->type]?></span>
                    </p>
                    <p>
                        <span>Адрес</span>
                        <span><?= $vac->address?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-6 hidden-sm hidden-xs"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="descr">
                    <p>Описание</p>
                </div>
                <p><?= $vac->description?></p>
                <div style="margin-top: 50px" class="descr">
                    <p>Фото</p>
                </div>
                <section>
                    <?php if ($photos = \models\Photos::findAll(['type' => 'vacancies' , 'type_id' => $vac->id])){
                        ?>
                        <div class="regular slider cf" id="image-gallery">
                            <?php foreach ($photos as $k => $photo){?>
                                <div class="slide_img_block">
                                    <a href="<?= $photo->url?>" data-fancybox="gallery">
                                        <img class="gallery-items" src="<?= $photo->url?>" data-high-res-src="<?= $photo->url?>" alt=""/>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }?>
                    <script type="text/javascript">
                        $(document).on('ready', function() {
                            $(".regular").slick({
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
                                            slidesToShow: 1,
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
                    <script src="/dist/jquery.fancybox.js"></script>
                </section>
            </div>
        </div>
    </div>
</div>
<?php
$this->title = "Профиль";
$type = [
    'hour' => 'В час',
    'day' => 'В день',
    'month' => 'В месяц',
    'piecework' => 'Договорная'
];

?>

<div class="container profile_page info_profile_page">
    <?php include 'profinfo.php'?>

    <div class="row">
        <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px;" class="white_bg_block">
            <h2>Портфолио</h2>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php if ($photos = \models\Photos::findAll(['type' => 'profile', 'type_id' => $prof->id])) {
                    ?>
                    <div class="regular slider cf" id="image-gallery">
                        <?php foreach ($photos as $k => $photo) { ?>
                            <div class="slide_img_block">
                                <a href="<?= $photo->url ?>" data-fancybox="gallery">
                                    <img class="gallery-items" src="<?= $photo->url ?>"
                                         data-high-res-src="<?= $photo->url ?>" alt=""/>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <script type="text/javascript">
                    $(document).on('ready', function () {
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
            </div>
        </div>
    </div>

    <div class="row">
        <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px;" class="white_bg_block">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2><?= !Yii::$app->user->isGuest && Yii::$app->user->identity->type ? "Специальности" : "Вакансии" ?>
                    : <?= $ret->count() ?></h2>
                <?php foreach ($ret->all() as $k => $r) { ?>
                    <div style="margin-bottom: 30px;">
                        <h3>
                            <span class="mob_title_width"><?= $r['title'] ?></span>
                            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->type) { ?>
                                <a href="/specialties/info/ID<?= $r['id'] ?>.html">Подробнее</a>
                            <?php } else { ?>
                                <a href="/vacancies/info/ID<?= $r['id'] ?>.html">Подробнее</a>
                            <?php } ?>
                        </h3>
                        <p>
                            <span>Опыт работы</span>
                            <span><?= $r['experience'] ?></span>
                        </p>
                        <p>
                            <span>Оплата</span>
                            <span><?= $r['type'] == 'piecework' ? $type[$r['type']] : $r['price'] . ' ' . $r['currency'] . ' ' . $type[$r['type']] ?></span>
                        </p>
                        <p>
                            <span>Адрес</span>
                            <span><?= $r['address'] ?></span>
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

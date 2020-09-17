<?php
?>
<?php foreach ($markers as $v => $mark) { ?>
    <div class="row" id="vac<?= $mark->id ?>">
        <div class="vacansy_block">
            <div class="col-md-4 col-xs-6">
                <?php if ($logo = \models\MUser::findOne(['id' => $mark->muser_id])) {
                    ?>
                    <section class="regular_<?= $v ?> slider">
                        <div class="slide_img_block">
                            <img class="" src="<?= $logo->logo ?>"/>
                        </div>
                    </section>
                <?php } ?>
                <script type="text/javascript">
                    $(document).on('ready', function () {
                        $(".regular_<?=$v?>").slick({
                            dots: false,
                            infinite: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        });
                    });
                </script>
            </div>
            <div class="col-md-4 col-xs-6">
                <h3 class="job_status">
                    <?= $mark->title ?>
                </h3>
                <span class="information">
                            <?= substr($mark->description, 0, 60) . '...' ?>
                        </span>
            </div>
            <div class="col-md-4 col-xs-12">
                        <span class="red salary">
                            <?= $mark->type == 'piecework' ? $type[$mark->type] : $mark->price . ' ' . $mark->currency . ' ' . $type[$mark->type] ?>
                        </span>
                <br>
                <a href="tel:<?= $mark->phone ?>"><?= $mark->phone ?></a>
                <br>
                <a href="/specialties/info/ID<?= $mark->id ?>.html">Подробнее</a>
            </div>
        </div>
    </div>
<?php } ?>

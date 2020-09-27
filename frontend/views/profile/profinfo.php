<?php
?>
<div class="row">
    <div style="overflow: hidden; margin: 0 15px 15px; padding: 10px 20px;" class="white_bg_block">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <h2><?= Yii::$app->user->isGuest || Yii::$app->user->identity->type ? $prof->company : $prof->firstname . ' ' . $prof->lastname ?>
                <div class="rating">
                    <div class="stars">
                        <div class="on" style="width: <?= 20 * $prof->myRating() ?>%;"></div>
                        <div class="live">
                            <span data-rate="1"></span>
                            <span data-rate="2"></span>
                            <span data-rate="3"></span>
                            <span data-rate="4"></span>
                            <span data-rate="5"></span>
                        </div>
                    </div>
                </div>
                <!--                    <a class="on_map_link" href="/">На карте</a>-->
            </h2>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <img class="info_logo_user"
                         src="<?= Yii::$app->user->isGuest || !Yii::$app->user->identity->type ? $prof->comp_logo : $prof->logo ?>"
                         alt="logo">
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <span class="user_info_span"><?= $prof->getBirthday() ?></span><br/>
                    <?php } ?>
                    <span class="user_info_span">
                            <span class="glyphicon glyphicon-map-marker"></span>
                             <?= $prof->address ?>
                        </span>
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id == $prof->id) { ?>
                        <div class="type_block">
                            <span style="margin-right: 10px">Бесплатные: 1</span>
                            <span style="margin-right: 10px">Платные: 3</span>
                            <span>В архиве: 0</span>
                        </div>
                    <?php } ?>

                    <div class="links_block">
                        <a href="/profile/reviews/ID<?= $prof->id ?>.html">Отзывы</a>
                        <a href="/profile/info/ID<?= $prof->id ?>.html">Смотреть профиль</a>
                        <?php if(!Yii::$app->user->isGuest && !Yii::$app->user->identity->type){?>
                            <a href="/profile/specialties/ID<?= $prof->id ?>.html">К списку специальностей</a>
                        <?php } else {?>
                            <a href="/profile/vacancies/ID<?= $prof->id ?>.html">К списку вакансий</a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 hidden-xs"></div>
    </div>
</div>

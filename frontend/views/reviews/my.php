<?php

use \models\Reviews;

$this->title = "Рейтинг и отзывы";
$uType= Yii::$app->user->identity->type;
?>

<div class="container profile_page">
    <div class="profile_info reviews_index">
        <div style="overflow: hidden; padding: 10px 20px;" class="row white_bg_block">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h2><?= Yii::$app->user->identity->type ? $user->company : $user->firstname .' '. $user->lastname ?>
                    <div class="rating_reviews_block">
                        <span class="rating_quantity"><?= round(Reviews::getMySumRating($user->id, $uType), 2) ?></span>
                        <span>Всего <?= Reviews::getMyAllRating($user->id, $uType) ?></span>
                    </div>
                    <div style="top: 10px; position: relative;" class="rating">
                        <div class="stars">
                            <div class="on" style="width: <?= 20 * $sumrating ?>%;"></div>
                            <div class="live">
                                <span data-rate="1"></span>
                                <span data-rate="2"></span>
                                <span data-rate="3"></span>
                                <span data-rate="4"></span>
                                <span data-rate="5"></span>
                            </div>
                        </div>
                    </div>
                </h2>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <img class="info_logo_user" src="<?= Yii::$app->user->identity->type ? $user->comp_logo : $user->logo ?>" alt="logo">
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?php foreach (array_reverse(Reviews::getMyRating($user->id, $uType)) as $k => $r) { ?>
                            <div class="rating_stat">
                                <div class="rating_stat_block">
                                    <div class="rating">
                                        <div class="stars">
                                            <div class="on" style="width: <?= 100 - ($k * 20) ?>%;"></div>
                                            <div class="live">
                                                <span data-rate="1"></span>
                                                <span data-rate="2"></span>
                                                <span data-rate="3"></span>
                                                <span data-rate="4"></span>
                                                <span data-rate="5"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span><?= $r ?></span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 hidden-xs"></div>
        </div>

        <div style="overflow: hidden; padding: 10px 20px 30px; margin-top: 15px" class="row white_bg_block">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>
                    Отзывы
                    <?php if (!Yii::$app->user->isGuest && $user->id != Yii::$app->user->id && !\models\Reviews::findOne(['user_to' => $user->id, 'user_from' => Yii::$app->user->id, 'type' => !Yii::$app->user->identity->type ? 'employer' : 'worker'])) { ?>
                        <a class="answer_link" data-toggle="modal" data-target="#myModalLeaveReview">Оставить отзыв</a>
                    <?php }?>
                </h2>
            </div>
            <?php foreach ($reviews as $k => $rew) {
                $revUser = \models\MUser::findOne($rew->user_from);
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="rev_block">
                        <div class="rev_block_left float_left">
                            <span class="date"><?= date('d.m.Y', $rew->created_at) ?></span>
                            <img src="<?= !Yii::$app->user->identity->type ? $revUser->comp_logo : $revUser->logo ?>" alt="logo">
                            <span style="display: inline-block;">
                                <a style="float: none" href="/profile/info/ID<?= $revUser->id ?>.html">
                                <?= $revUser->firstname . ' ' . $revUser->lastname ?>
                                </a>
                            </span>
                        </div>
                        <div class="rev_block_right float_right">
                            <div class="rating">
                                <div class="stars">
                                    <div class="on" style="width: <?= 20 * $rew->rating ?>%;"></div>
                                    <div class="live">
                                        <span data-rate="1"></span>
                                        <span data-rate="2"></span>
                                        <span data-rate="3"></span>
                                        <span data-rate="4"></span>
                                        <span data-rate="5"></span>
                                    </div>
                                </div>
                            </div>
                            <a href="/reviews/info/ID<?=$rew['id']?>.html">Подробнее</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div style="overflow: hidden; padding: 10px 20px 30px; margin-top: 15px" class="row white_bg_block">
            <span class="sorting_by_price">
            <?= $sort->link('title') . " | " . $sort->link('created'); ?>
            </span>
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    </div>
</div>

<?php if (!Yii::$app->user->isGuest && $user->id != Yii::$app->user->id && !\models\Reviews::findOne(['user_to' => $user->id, 'user_from' => !Yii::$app->user->id, 'type' => Yii::$app->user->identity->type ? 'employer' : 'worker'])) { ?>
    <div class="modal fade" id="myModalLeaveReview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="padding: 5% 0px" role="document">
            <form method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                       value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>
                            Оставить отзыв
                        </h3>
                    </div>
                    <div style="overflow: hidden;" class="modal-body">
                        <div class="rating_block">
                            <?php for ($i = 5; $i != 0; $i--) { ?>
                                <input name="rev[rating]" required value="<?= $i ?>"
                                       id="rating_<?= $i ?>" type="radio"/>
                                <label for="rating_<?= $i ?>" class="label_rating"></label>
                            <?php } ?>
                        </div>
                        <textarea required name="rev[text]" id="" placeholder="Текст сообщения ..."></textarea>
                        <button type="button" class="btn cancel" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="send_answer">Отправить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php }?>
<style>
    .rating_block {
        width: 105px;
        height: 20px;
    }

    .rating_block input[type="radio"],
    .rating_block input[type="radio"] + label:before {
        display: none;
    }

    .label_rating {
        float: right;
        display: block;
        width: 21px;
        height: 20px;
        background: url(/img/stars.png) no-repeat 50% 0;
        cursor: pointer;
    }

    .rating_block .label_rating:hover,
    .rating_block .label_rating:hover ~ .label_rating,
    .rating_block input[type="radio"]:checked ~ .label_rating {
        background-position: 50% -20px;
    }
</style>


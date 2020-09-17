<?php
$this->title = "Рейтинг и отзывы";
$ans = \models\Reviews::findOne(['answer' => $rev->id]);
?>

<div class="container profile_page">
    <div class="profile_info reviews_index reviews_info">
        <div style="overflow: hidden; padding: 10px 20px;" class="row white_bg_block">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Отзыв
                    <a href="/profile/reviews/ID<?=$rev->user_to?>.html">К списку отзывов</a>
                </h2>
                <div class="rev_block_left">
                    <img src="<?= $user->logo ?>" alt="logo">
                    <div>
                        <span>"<?= $user->company ?>"</span>
                        <span style="font-weight: 400; color: #816A7E;">написал отзыв <?= date('d.m.Y, H:i', $rev->created_at) ?></span>
                        <br>
                        <span class="user_info_span">
                            <span class="glyphicon glyphicon-map-marker"></span>
                            <?= $user->address ?>
                        </span>
                    </div>
                </div>
                <div class="review_detail">
                    <div class="rating">
                        <div class="stars">
                            <div class="on" style="width: <?= 20 * $rev->rating ?>%;"></div>
                            <div class="live">
                                <span data-rate="1"></span>
                                <span data-rate="2"></span>
                                <span data-rate="3"></span>
                                <span data-rate="4"></span>
                                <span data-rate="5"></span>
                            </div>
                        </div>
                    </div>
                    <p>
                        <?= $rev->text ?>
                    </p>
                </div>
            </div>
            <?php if ($ans) {
                $ansU = \models\MUser::findOne($ans->user_from);
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="rev_block_left">
                        <img src="<?= $ansU->logo ?>" alt="logo">
                        <div>
                            <span>"<?= $ansU->company ?>"</span>
                            <span style="font-weight: 400; color: #816A7E;">ответил на отзыв <?= date('d.m.Y, H:i', $ans->created_at) ?></span>
                            <br>
                            <span class="user_info_span">
                            <span class="glyphicon glyphicon-map-marker"></span>
                            <?= $ansU->address ?>
                        </span>
                        </div>
                    </div>
                    <div class="review_detail">
                        <p>
                            <?= $ans->text ?>
                        </p>
                    </div>
                </div>
            <?php } ?>

            <?php if (!Yii::$app->user->isGuest){?>
                    <?php if($rev->user_to == Yii::$app->user->id){?>
                        <a class="answer_link" data-toggle="modal" data-target="#myModalAnswer">Ответить</a>
                        <?php if($ans){?>
                            <a class="del_link" href="/reviews/delete/ID<?=$ans->id?>.html">Удалить свой ответ</a>
                        <?php }?>
                    <?php }elseif($rev->user_from == Yii::$app->user->id){?>
                        <a class="edit_link" data-toggle="modal" data-target="#myModalAnswer">Редактировать</a>
                        <a class="del_link" href="/reviews/delete/ID<?=$rev->id?>.html">Удалить свой отзыв</a>
                    <?php }?>
            <?php }?>
        </div>
    </div>
</div>
<?php if($rev->user_from == Yii::$app->user->id){?>
<div class="modal fade" id="myModalAnswer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="padding: 5% 0px" role="document">
        <form method="post" action="/reviews/update.html">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                   value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
            <input type="hidden" name="rev[id]"
                   value="<?=$rev->id?>"/>
            <div class="modal-content">
                <div class="modal-header">
                    <h3>
                        Редактировать
                    </h3>
                </div>
                <div style="overflow: hidden;" class="modal-body">
                    <div class="rating_block">
                        <?php for ($i = 5; $i != 0; $i--) { ?>
                            <input <?= $rev->rating == $i ? 'checked':''?> name="rev[rating]" required value="<?= $i ?>"
                                   id="rating_<?= $i ?>" type="radio"/>
                            <label for="rating_<?= $i ?>" class="label_rating"></label>
                        <?php } ?>
                    </div>
                    <textarea required name="rev[text]" id="" placeholder="Текст сообщения ..."><?= $rev->text?></textarea>
                    <button type="button" class="btn cancel" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="send_answer">Отправить</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php }elseif ($rev->user_to == Yii::$app->user->id) {
    if($ans == null){$ans = new \models\Reviews();};
    ?>
    <div class="modal fade" id="myModalAnswer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="padding: 5% 0px" role="document">
            <form method="post" action="/reviews/update.html">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                       value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                <input type="hidden" name="rev[id]"
                       value="<?= $ans->id?>"/>
                <input type="hidden" name="rev[answer]"
                       value="<?= $rev->id?>"/>
                <input type="hidden" name="rev[user_to]"
                       value="<?= $rev->user_from?>"/>
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>
                            Ответить
                        </h3>
                    </div>
                    <div style="overflow: hidden;" class="modal-body">
                        <textarea required name="rev[text]" id="" placeholder="Текст сообщения ..."><?= $ans->text?></textarea>
                        <button type="button" class="btn cancel" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="send_answer">Отправить</button>
                    </div>
                </div>
            </form>
        </div>
    </div
<?php } ?>
<div class="modal fade" id="myModalAnswerFinish" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="padding: 5% 0px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <h3>
                    Сообщение<br>
                    успешно отправлено!
                </h3>
            </div>
        </div>
    </div>
</div>
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
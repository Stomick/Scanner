<?php
$us = Yii::$app->user->identity;
if(!$us->company && !$us->firstname){
    $uname = $us->email;
}else{
    if(!$us->type) {
        $uname = $us->firstname . ' ' . $us->lastname;
    }
    if($us->type && $us->company){
        $uname = $us->company;
    }
}
if(!$us->type) {
    $logo = $us->logo;
}else{
    $logo = $us->comp_logo;
}
?>
<script>
    var socket = io(':3000?token=<?= Yii::$app->user->identity->getAuthKey() ?>').on('connect', function (msg) {});
    socket.on('newmess', function (tet) {});
</script>
<div class="nav_panel">
    <div class="col-md-3 col-sm-3 col-xs-6 left_side">
        <a href="/" class="logo_title">
            JOBSCANNER
        </a>
        <div class="nav_img"></div>
    </div>
    <div class="col-md-4 col-sm-4 hidden-xs center_side">
        <span class="page_title"><?= $this->title ?></span>
    </div>
    <div class="col-md-5 col-sm-5 col-xs-6 right_side">
        <div class="info_block">
            <a class="bell" href="/profile/system.html">
                <img src="/img/01JS-icon-bell+-01.svg" alt="icon">
            </a>
            <a class="letters" href="/profile/messages.html">
                <img src="/img/01JS-icon-letter+-01.svg" alt="icon">
            </a>
            <div class="logo_user">
                <img src="<?=$logo?>" alt="logo">
            </div>
            <div class="title_user">
                <a href="/profile.html"><?= $uname ?></a>
            </div>
            <div class="wallet">
                <a href="/payment.html">
                    <img src="/img/01JS-icon-wallet+-01.svg" alt="icon">
                    <?= Yii::$app->user->identity->balance ?> <span class="currency">₽</span>
                </a>
            </div>
        </div>
        <span class="open_right_menu"><i class="fas fa-bars"></i></span>
        <span class="btn_close"><i class="fas fa-times"></i></span>
    </div>
</div>

<!--<div id="myOverlay"></div>-->
<div class="right_menu_container">
    <div class="right_menu">
        <div class="menu_user_block">
            <div class="logo_user">
                <img src="<?=$logo?>" alt="logo">
            </div>
            <div class="title_user">
                <a href="/profile.html"><?= $uname ?></a>
            </div>
        </div>

        <form method="post" id="profstatus" action="/profile/status.html">
            <div class="first_section">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                   value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
            <p>
                <input type="radio" <?= !Yii::$app->user->identity->type ? 'checked' : '' ?> id="worker" name="proftype"
                       value="0">
                <label class="worker" for="worker"><img src="/img/01JS-icon-employee.svg" alt="icon">
                    <span>Работник</span></label>
            </p>
            <hr>
            <p>
                <input type="radio" <?= Yii::$app->user->identity->type ? 'checked' : '' ?> id="employer"
                       name="proftype" value="1">
                <label class="employer" for="employer"><img src="/img/01JS-icon-employer.svg" alt="icon">
                    <span>Наниматель</span></label>
            </p>
            </div>
            <p>
                <input class="check" type="checkbox" <?= Yii::$app->user->identity->public ? 'checked' : '' ?>
                       name="profstatus" id="public">
                <label class="public" for="public"><img src="/img/01JS-icon-showpassword.svg" alt="icon">
                    <span>Публичный</span></label>
            </p>
        </form>
        <hr>
        <?php if (Yii::$app->user->identity->type) { ?>
        <p class="vacansies"><a href="/profile/vacancies.html"><img src="/img/01JS-icon-folder.svg" alt="icon">
                <span>Мои вакансии</span></a>
            <span class="round_count"><?= \models\Vacancies::find()->where(['muser_id' => Yii::$app->user->id , 'arhive' => 0,'tmp'=>0])->count()?></span>
        </p>
        <hr class="vacansies">
        <?php }else{?>
            <p class="my_specialties"><a href="/profile/specialties.html"><img src="/img/01JS-icon-profession.svg" alt="icon">
                    <span>Мои специальности</span></a>
                <span class="round_count"><?= \models\Specialties::find()->where(['muser_id' => Yii::$app->user->id , 'arhive' => 0,'tmp'=>0])->count()?></span>
            </p>
            <hr class="my_specialties">
        <?php }?>
        <p class="vacansies"><a href="/profile/arhive.html"><img src="/img/01JS-icon-folder.svg" alt="icon">
                <span>Архив</span></a>
            <span class="round_count"><?= !Yii::$app->user->identity->type ?
                    \models\Specialties::find()->where(['muser_id' => Yii::$app->user->id , 'arhive' => 1,'tmp'=>0])->count():
                    \models\Vacancies::find()->where(['muser_id' => Yii::$app->user->id , 'arhive' => 1,'tmp'=>0])->count()
                ?>
            </span>
        </p>
        <hr class="vacansies">

        <?php if (!Yii::$app->user->identity->type) { ?>
            <p class="sent_received"><a href="/profile/answers.html"><img src="/img/01JS-icon-chat.svg" alt="icon">
                    <span>Отправленные отклики</span></a>
                <span class="round_count"><?= Yii::$app->user->identity->getSendAnswers()->count()?></span>
            </p>
        <?php } else { ?>
            <p class="sent_received"><a href="/profile/answers.html">
                    <img src="/img/01JS-icon-chat.svg" alt="icon">
                    <span>Полученные отклики</span></a>
                <span class="round_count"><?= Yii::$app->user->identity->getTakeAnswers()->count()?></span>
            </p>
        <?php } ?>
        <hr>
        <p><a href="/profile/messages.html"><img src="/img/01JS-icon-letter.svg" alt="icon">
                <span>Сообщения</span></a>
            <span class="round_count"><?=
                Yii::$app->user->identity->type ?
                    Yii::$app->user->identity->getSendAnswers()->andWhere(['chmtr.status'=>0])->count() :
                    Yii::$app->user->identity->getTakeAnswers()->andWhere(['chmtr.status'=>0])->count();
                ?></span>
        </p>
        <hr>
        <p><a href="/profile/system.html"><img src="/img/01JS-icon-bell.svg" alt="icon">
                <span>Системные уведомления</span></a>
            <span class="round_count"><?= \models\ChatUserRoom::find()
                    ->innerJoin('chat_message_to_rooms chm' , 'chm.room_id=chat_user_to_rooms.room_id')
                    ->innerJoin('chat_rooms cr' , 'cr.room_id=chm.room_id AND cr.type="system"')
                    ->where(['chm.status'=>0])->andWhere(  'chat_user_to_rooms.user_id='. Yii::$app->user->id)->count()?></span>
        </p>
        <hr>
        <p><a href="/payment.html"><img src="/img/01JS-icon-wallet.svg" alt="icon">
                <span>Оплата</span></a></p>
        <hr>
        <p><a href="/profile.html"><img src="/img/01JS-icon-profile.svg" alt="icon">
                <span>Настройки профиля</span></a></p>
        <hr>
        <p class="reviews"><a href="/profile/reviews.html"><img src="/img/01JS-icon-medal.svg" alt="icon">
                <span>Рейтинг и отзывы</span></a></p>
        <hr class="reviews">
        <p><a class="exit_link" href="/logout.html"><img src="/img/01JS-icon-goout.svg" alt="icon">
                <span>Выйти</span></a></p>
    </div>
</div>

<?php

use models\Reviews;

$rew = Reviews::find()->select([
    'review_id as id',
    'text', 'type', 'firstname as name', 'reviews.created_at as date',
])->innerJoin('musers', 'musers.id=reviews.muser_id')->where(['reviews.stock_id' => $stock->stock_id,'answer_id' => 0])
    ->orderBy('reviews.created_at')->asArray()->all()
?>
<section class="panel ">
    <?php foreach ($rew as $k => $v){?>
    <div class="comment">
        <div class="comment">
            <p class="author"><strong><?= $v['name']?></strong> - <?= date('d-m-Y H:i' , $v['date'])?></p>
            <span><?= $v['text']?></span>
            <footer>
                <img alt="" src="<?= $comp->url?>" class="circle">
                <?php if (!$ans = Reviews::find()->select([
                    'review_id as id',
                    'text', 'type', 'username as name' , 'reviews.created_at as date',
                ])->innerJoin('user', 'user.id=reviews.muser_id')->where(['reviews.answer_id' => $v['id']])->asArray()->one()) {?>
                <form class="message-input clearfix">
                    <input name="message" type="text" placeholder="Enter your message"/>
                </form>
                <?php }else{?>
                    <p class="author"><strong><?= $ans['name']?></strong> - <?= date('d-m-Y H:i' , $ans['date'])?></p>
                    <span><?= $ans['text']?></span>
                <?php }?>
            </footer>
        </div>
    </div>
    <?php }?>
</section>
<?php
$type = [
    'hour' => 'В час',
    'day' => 'В день',
    'month' => 'В месяц',
    'piecework' => 'Договорная'
];
?>
<div id="main">


    <ol class="breadcrumb">
        <li><a href="#">Главная</a></li>
        <li><a href="/vacancies">Вакансии</a></li>
        <li class="active"><?= $vacans->title ?></li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">

        <div class="row">
            <section class="panel corner-flip">
                <div class="panel-body">
                    <div class="invoice">
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="#"> <img alt="" src="assets/img/logo_invice.png"> </a>
                            </div>
                            <div class="col-sm-6 align-lg-right">
                                <h3>Вакансия № <?=$vacans->id?></h3>
                                <span><?=date('d-m-Y , H:i' , $vacans->created_at)?></span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Наниматель :</h4>
                                <?php $user = \models\MUser::findOne($vacans->muser_id)?>
                                <?=$user->firstname?> <br>
                                <?=$user->lastname?> <br>
                                <?=$user->email?>
                            </div>
                            <div class="col-md-6 align-lg-right">
                                <h4>Оплата :</h4>
                                <strong>Цена :</strong> <?=$vacans->price?><br>
                                <strong>Тип :</strong> <?=$type[$vacans->type]?> <br>
                                <strong>Валюта :</strong> <?=$vacans->currency?>
                            </div>
                        </div>
                        <br>
                        <br>
                        <h3>Отклики</h3>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th width="60%" class="text-left">Работник</th>
                                <th>Диалог</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach (\models\ChatMessages::find()->from('chat_message_to_rooms chm')
                                ->select(['musers.*' , 'cr.room_id'])
                            ->where(['chm.type'=> 'answer'])->innerJoin('chat_rooms cr' , ['cr.type' =>  $tp,  'cr.type_id'=> $vacans->id])
                                               ->andWhere('chm.room_id=cr.room_id')
                                ->innerJoin('musers' , 'musers.id=chm.id')
                                               ->asArray()->all() as $ch => $chat){?>
                            <tr>
                                <td class="text-center">1</td>
                                <td><?= $chat['firstname'] . ' ' . $chat['lastname']?></td>
                                <td class="text-center">
                                    <a href="/chat?id=<?=$chat['room_id']?>" class="btn btn-default btn-sm" title="" data-original-title="Чат"><i class="fa fa-comment"></i></a>
                                </td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="align-lg-left">
                                    Адрес : <?=$vacans->address?><br/>
                                    Телефон : <?=$vacans->phone?> <br/>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <section class="panel-body">
                                <?php if ($photos = \models\Photos::findAll(['type' => 'vacancies' , 'type_id' => $vacans->id])){
                                    ?>
                                    <div class="regular slider cf" id="image-gallery">
                                        <?php foreach ($photos as $k => $photo){?>
                                            <div class="slide_img_block">
                                               <img class="img img-thumbnail" src="<?= $photo->url?>" data-high-res-src="<?= $photo->url?>" alt=""/>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php }?>
                                <script src="/js/slick.js"></script>

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

                            </section>
                        </div>
                    </div>
                    <!-- //invoice -->
                </div>
            </section>
        </div>
        <!-- //content > row-->

    </div>
    <!-- //content-->


</div>


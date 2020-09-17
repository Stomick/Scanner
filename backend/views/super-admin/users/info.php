<?php
?>
<div id="main">

    <div id="overview">
        <div class="row">
            <div class="col-sm-8">
                <section class="profile-cover">
                    <div class="profile-avatar">
                        <div>
                            <img alt="" src="<?= $prof->logo ?>" class="circle">
                            <span><?= $prof->firstname . ' ' . $prof->lastname ?></span>
                        </div>
                    </div>
                    <div class="profile-status">
                        <a class="btn"> <?= $prof->type ? $prof->getTakeAnswers()->count() : $prof->getSendAnswers()->count() ?> <small>Откликов</small></a>
                        <a class="btn"> 254 <small>Выполненых работ</small></a>
                        <a class="btn"> <?= $prof->balance?> <small>Баланс</small></a>
                    </div>
                </section>
            </div>
            <!-- //content > row > col-sm-9 -->

            <div class="col-sm-4">
                <section class="profile-about">
                    <h3>Инфо</h3>
                    <hr>
                    <p>Телефон : <?= $prof->phone ?></p>
                    <hr>
                    <p>Адрес : <?= $prof->address ?></p>
                    <hr>
                </section>
            </div>
            <!-- //content > row > col-lg-3 -->
        </div>
        <!-- //row-->
    </div>

    <div class="tabbable">
        <ul id="profile-tab" class="nav nav-tabs" data-provide="tabdrop">
            <li><a href="#" id="prevtab" data-change="prev"><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="#" id="nexttab" class="change" data-change="next"><i class="fa fa-chevron-right"></i></a></li>
            <li class="active"><a href="#tab1" data-toggle="tab">Отзывы</a></li>
            <li><a href="#tab3" data-toggle="tab" class="portfolio-show">Галерея</a></li>
            <li><a href="#tab4" data-toggle="tab" class="portfolio-show">Описание</a></li>
        </ul>
        <div class="tab-content row">
            <div class="tab-pane fade in active col-lg-8" id="tab1">
                <?php foreach (\models\Reviews::find()->where(['user_to' => $prof->id, 'answer' => 0])->orderBy('created_at desc')->all() as $k => $rew) {
                    $revUser = \models\MUser::findOne([$rew->user_from]);
                    ?>
                    <div class="comment">
                        <img alt="" src="<?= $revUser->logo ?>" class="circle">
                        <div class="comment-content">
                            <p class="author"><strong><?= $revUser->firstname . ' ' . $revUser->lastname ?></strong>
                                - <?= date('d.m.Y H:i', $rew->created_at) ?></p>
                            <span><?= $rew->text ?></span>
                            <footer>
                                <form class="message-input clearfix">
                                    <input disabled name="message" type="text" placeholder="Enter your message"/>
                                </form>
                            </footer>
                        </div>
                    </div>
                    <!--//comment-->
                <?php } ?>
                <br>
                <hr>
                <div class="align-lg-center">
                    <button class="btn btn-theme">Load more</button>
                </div>
                <br>

            </div>
            <!-- /#tab1-->

            <!-- /#tab2-->


            <div class="tab-pane fade col-lg-8" id="tab3">
                <br>
                <!-- box Filter -->
                <div class="box-filter">
                    <a href="#" class="btn btn-inverse active" data-filter="*"><i class="fa fa-th"></i></a>
                    <a href="#" class="btn btn-theme " data-filter=".profile">Портфолио</a>
                    <a href="#" class="btn btn-theme " data-filter=".vacancies">Вакансии</a>
                </div>
                <hr>
                <div class="row">
                    <!-- box Feed -->
                    <div class="box-feed  clearfix">
                        <?php foreach (\models\Photos::findAll(['user_id' => $prof->id]) as $photo) { ?>
                            <div class="col-sm-4 photography <?= $photo->type ?>">
                                <img alt="" src="/<?= $photo->url ?>" class="img-preview">
                            </div>
                        <?php } ?>
                    </div>
                    <!-- /box Feed -->
                </div>
                <!-- /row-->
            </div>
            <div class="tab-pane fade col-lg-8" id="tab4">
                <br>
                <!-- box Filter -->
                <p style="color: black"><?= $prof->description ?></p>
                <!-- /row-->
            </div>
            <!-- /#tab3-->
            <div class="col-lg-4">
                <div class="widget-rating row">
                    <div class="col-xs-12">
                        <div class="well corner-flip flip-gray flip-bg-white bg-palevioletred-darken">
                            <div class="row">
                                <div class="col-xs-12 col-md-6 text-center">
                                    <h1 class="rating-num"><?= round(\models\Reviews::getSumRating($prof->id , $prof->type), 2) ?></h1>
                                    <div class="rating">
                                        <?php for ($i = 1; $i != 6; $i++) { ?>
                                            <span class="glyphicon glyphicon-star<?= $i <= (int)\models\Reviews::getSumRating($prof->id,$prof->type) ? '' : '-empty' ?>"></span>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <span class="glyphicon glyphicon-user"></span><?php $allr = \models\Reviews::find()->where(['user_to' => $prof->id])->count();
                                        echo $allr ?> всего
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="row rating-desc">
                                        <?php foreach (\models\Reviews::getRating($prof->id, $prof->type) as $k => $r) {
                                            $c = \models\Reviews::find()->where(['user_to' => $prof->id, 'rating' => $k + 1, 'answer' => 0])->count(); ?>
                                            <div class="col-xs-3 col-md-3 text-right"><label class="progress-label">
                                                    <span class="glyphicon glyphicon-star"></span><?= $k + 1 ?></label>
                                            </div>
                                            <div class="col-xs-8 col-md-9">
                                                <div class="progress progress-stripes progress-sm progress-dark">
                                                    <div class="progress-bar bg-warning"
                                                         aria-valuetransitiongoal="<?= $allr == 0 ? 0 : 100 / $allr * $c ?>"></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <!-- end 5 -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end xs-12 -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end well-->
                    </div>
                    <!-- end xs-12 -->
                </div>
                <!-- end widget-rating-->
            </div>
            <!-- //content > row > col-lg-4 -->

        </div>
        <!-- //tab-content -->
    </div>

</div>
<script type="text/javascript" src="/js/caplet.custom.js"></script>
<script type="text/javascript">
    $(function () {

        var $container = $('.box-feed');
        var $filter = $('.box-filter');

        $(".portfolio-show").click(function () {
            if (!$container.hasClass("isotope")) {
                setTimeout(function () {
                    $container.isotope({
                        filter: '*',
                        layoutMode: 'fitRows',
                        animationOptions: {duration: 750, easing: 'linear'}
                    });
                }, 400);
            }
        });
        $filter.find('a').click(function () {
            var selector = $(this).attr('data-filter');
            $filter.find('a').removeClass('active');
            $(this).addClass('active');
            $container.isotope({
                filter: selector,
                animationOptions: {animationDuration: 750, easing: 'linear', queue: false}
            });
            return false;
        });
    });

</script>
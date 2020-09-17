<?php
?>
<div id="main">

    <ol class="breadcrumb">
        <li><a href="#">Главная</a></li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">

        <div class="row">
            <div class="col-md-3">
                <div class="well bg-info">
                    <div class="widget-tile">
                        <section>
                            <h5><strong>Мобильные</strong> пользователи</h5>
                            <h2>
                                <?= \models\MobDevice::find()->where('user_id=0')->count()?>
                                /
                                <?= \models\MobDevice::find()->where('user_id!=0')->count()?>
                            </h2>
                        </section>
                        <div class="hold-icon"><i class="fa fa-bar-chart-o"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well bg-inverse">
                    <div class="widget-tile">
                        <section>
                            <h5><strong>FREE</strong><br/>  </h5>
                            <h2>
                                
                            </h2>
                        </section>
                        <div class="hold-icon"><i class="fa fa-shopping-cart"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well bg-theme">
                    <div class="widget-tile">
                        <section>
                            <h5><strong>PRO</strong><br/>  </h5>
                            <h2>
                            </h2>
                        </section>
                        <div class="hold-icon"><i class="fa fa-laptop"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well bg-theme">
                    <div class="widget-tile">
                        <section>
                            <h5><strong>enterprise</strong><br/>  </h5>
                            <h2>
                            </h2>
                        </section>
                        <div class="hold-icon"><i class="fa fa-laptop"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- //content > row-->
    </div>
    <!-- //content-->

    <footer id="site-footer">
        <section>&copy</section>
    </footer>

</div>

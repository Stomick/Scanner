<?php
$comp = \models\Company::findOne(Yii::$app->user->identity->company_id);
?>
<div id="nav">
    <div id="nav-scroll">
        <div class="avatar-slide">
			<span class="easy-chart avatar-chart" data-color="theme-inverse" data-percent="0" data-track-color="rgba(255,255,255,0.1)" data-line-width="5" data-size="118">
			    <img alt="" src="<?= $comp->url ? $comp->url: ''?>" class="circle">
			</span>
            <div class="avatar-detail">
                <p> <?= $comp->name ?></p>
                <p>
                    <a href="#"><?= Yii::$app->user->identity->email ?></a>
                </p>
                <span>Баланс <?= $comp->balance?> р</span>
                <span><a href="#" type="button" class="иет">Пополнить</a></span>
                <br/>
                <br/>
                <a href="/stock/new" type="button" class="btn btn-danger">+ Добавить акцию</a>
            </div>
            <!-- //avatar-detail-->

            <!-- //avatar-link-->

        </div>
        <!-- //avatar-slide-->

        <div class="widget-collapse dark">
            <header>
                <div style="background-color: #f35958; width: 3px;height: 100%"></div>
                <a style="text-align: center;color: white" href="#">Акции</a style="еу">
            </header>
            <!-- //collapse-->
        </div>
        <div class="widget-collapse dark">
            <header>
                <div style="background-color: #f35958; width: 3px;height: 100%"></div>
                <a href="/stock/inprogress">Действующие </a>
            </header>
            <!-- //collapse-->
        </div>
        <div class="widget-collapse dark">
            <header>
                <div style="background-color: #f35958; width: 3px;height: 100%"></div>
                <a href="/stock/ended">Не активные </a>
            </header>
            <!-- //collapse-->
        </div>
        <div class="widget-collapse dark">
            <header>
                <div style="background-color: #f35958; width: 3px;height: 100%"></div>
                <a href="/stock/arhive">Архив </a>
            </header>
            <!-- //collapse-->
        </div>
        <div class="widget-collapse dark">
            <header>
                <div style="background-color: #f35958; width: 3px;height: 100%"></div>
                <a style="text-align: center;color: white" href="#">Компания</a style="еу">
            </header>
            <!-- //collapse-->
        </div>
        <div class="widget-collapse dark">
            <header>
                <div style="background-color: #f35958; width: 3px;height: 100%"></div>
                <a href="/company/address">Настройка компании </a>
            </header>
            <!-- //collapse-->
        </div>

    </div>
    <!-- //nav-scroller-->
</div>

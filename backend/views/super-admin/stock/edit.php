<?php
?>
<div id="main">

    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">
        <div class="row">
    <div class="col-lg-12">
        <h2><strong>Акции</strong></h2>
        <hr>
        <div class="tabbable">
            <ul class="nav nav-tabs" data-provide="tabdrop">
                <li class="active"><a href="#tab1" data-toggle="tab">Информация</a></li>
                <li><a href="#tab2" data-toggle="tab">Отзывы</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1">
                    <?php include '_info.php'?>
                </div>
                <div class="tab-pane fade" id="tab2">
                    <?php include '_reviews.php'?>
                </div>

            </div>
        </div>
    </div>

</div>
</div>
</div>

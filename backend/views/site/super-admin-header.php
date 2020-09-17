<?php
?>
<div id="header">

    <div class="logo-area clearfix">
        <a href="#" class="logo"></a>
    </div>
    <!-- //logo-area-->

    <div class="tools-bar">
        <ul class="nav navbar-nav navbar-right tooltip-area">
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                    <em><?= Yii::$app->user->identity->username?> </em> <i class="dropdown-icon fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu pull-right icon-right arrow">
                    <li><a href="/logout"><i class="fa fa-sign-out"></i> Выход </a></li>
                </ul>
                <!-- //dropdown-menu-->
            </li>
        </ul>
    </div>
    <!-- //tools-bar-->

</div>


<?php
?>
<div id="header">

    <div class="logo-area clearfix">
        <a href="#" class="logo"></a>
    </div>
    <!-- //logo-area-->

    <div class="tools-bar">
        <ul class="nav navbar-nav nav-main-xs">
            <li><a href="#menu" class="icon-toolsbar"><i class="fa fa-bars"></i></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right tooltip-area">
            <li><a href="#menu-right" data-toggle="tooltip" title="Right Menu" data-container="body" data-placement="left"><i class="fa fa-align-right"></i></a></li>
            <li><button class="btn btn-circle btn-header-search" ><i class="fa fa-search"></i></button></li>
            <li><a href="#" class="nav-collapse avatar-header" data-toggle="tooltip" title="Show / hide  menu" data-container="body" data-placement="bottom">
                    <img alt="" src="/img/avatar.png"  class="circle">
                    <span class="badge">3</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                    <em><strong>Hi</strong>, <?= \Yii::$app->user->identity->username ?> </em> <i class="dropdown-icon fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu pull-right icon-right arrow">
                    <li><a href="/users/profile"><i class="fa fa-user"></i> Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="/logout"><i class="fa fa-sign-out"></i> Выход </a></li>
                </ul>
                <!-- //dropdown-menu-->
            </li>
            <li class="visible-lg">
                <a href="#" class="h-seperate fullscreen" data-toggle="tooltip" title="Full Screen" data-container="body"  data-placement="left">
                    <i class="fa fa-expand"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- //tools-bar-->

</div>

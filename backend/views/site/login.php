<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Login */

$this->title = 'Sign In';

?>
<body class="full-lg">

<div id="wrapper">
<div class="container">
    <div class="row">
        <div class="col-lg-12">

            <div class="account-wall">
                <section class="align-lg-center">
                    <h1 class="login-title"><strong> JobScanner</strong>
                    </h1>
                </section>
                <form id="form-signin" method="post" class="form-signin">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                           value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                    <section>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                            <input type="text" class="form-control" name="LoginAdmin[email]" placeholder="Email">
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-key"></i></div>
                            <input type="password" class="form-control" name="LoginAdmin[password]" placeholder="Password">
                        </div>
                        <button class="btn btn-lg btn-theme-inverse btn-block" type="submit" id="sign-in">Войти
                        </button>
                    </section>
                </form>
                <a href="#" class="footer-link">&copy; 2020 StomSOFT</a>
            </div>
            <!-- //account-wall-->

        </div>
        <!-- //col-sm-6 col-md-4 col-md-offset-4-->
    </div>
    <!-- //row-->
</div>
</div>
<!-- //container-->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.ui.min.js"></script>
<script type="text/javascript" src="/plugins/bootstrap/bootstrap.min.js"></script>
<!-- Modernizr Library For HTML5 And CSS3 -->
<script type="text/javascript" src="/js/modernizr/modernizr.js"></script>
<script type="text/javascript" src="/plugins/mmenu/jquery.mmenu.js"></script>
<script type="text/javascript" src="/js/styleswitch.js"></script>
<!-- Library 10+ Form plugins-->
<script type="text/javascript" src="/plugins/form/form.js"></script>
<!-- Datetime plugins -->
<script type="text/javascript" src="/plugins/datetime/datetime.js"></script>
<!-- Library Chart-->
<script type="text/javascript" src="/plugins/chart/chart.js"></script>
<!-- Library  5+ plugins for bootstrap -->
<script type="text/javascript" src="/plugins/pluginsForBS/pluginsForBS.js"></script>
<!-- Library 10+ miscellaneous plugins -->
<script type="text/javascript" src="/plugins/miscellaneous/miscellaneous.js"></script>
<!-- Library Themes Customize-->
<script type="text/javascript" src="/js/caplet.custom.js"></script>
<script type="text/javascript">
    $(function() {
        //Login animation to center
        function toCenter(){
            var mainH=$("#main").outerHeight();
            var accountH=$(".account-wall").outerHeight();
            var marginT=(mainH-accountH)/2;
            if(marginT>30){
                $(".account-wall").css("margin-top",marginT-15);
            }else{
                $(".account-wall").css("margin-top",30);
            }
        }
        toCenter();
        var toResize;
        $(window).resize(function(e) {
            clearTimeout(toResize);
            toResize = setTimeout(toCenter(), 500);
        });

        //Canvas Loading
        var throbber = new Throbber({  size: 32, padding: 17,  strokewidth: 2.8,  lines: 12, rotationspeed: 0, fps: 15 });
        throbber.appendTo(document.getElementById('canvas_loading'));
        throbber.start();

        //Set note alert



    });
</script>
</body>
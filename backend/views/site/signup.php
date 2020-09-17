<?php
?>

<style>
    #validate-wizard {
        width: 330px;
        margin: auto;
    }
</style>

<body class="full-lg">
<div id="wrapper">

    <div id="loading-top">
        <div id="canvas_loading"></div>
        <span>Checking...</span>
    </div>

    <div id="main">
        <div class="real-border">
            <div class="row">
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
                <div class="col-xs-1"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="account-wall">
                        <section class="align-lg-center">
                            <div class="site-logo"></div>
                            <h1 class="login-title"><span>GIT</span>SAIL <small>Регистрация</small></h1>
                            <br>
                        </section>
                        <form id="validate-wizard" method="post" class="wizard-step shadow">
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                   value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                            <ul class="align-lg-center" style="display:none">
                                <li><a href="#step1" data-toggle="tab">1</a></li>
                                <li><a href="#step2" data-toggle="tab">2</a></li>
                                <li><a href="#step3" data-toggle="tab">3</a></li>
                            </ul>
                            <div class="progress progress-stripes progress-sm" style="margin:0">
                                <div class="progress-bar" data-color="theme"></div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="step1" parsley-validate parsley-bind>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="control-label">Имя</label>
                                            <input type="text" class="form-control" name="SignUpForm[username]" id="name"
                                                   parsley-required="true" parsley-error-message="Обязательное поле" parsley-error-message="Обязательное поле" placeholder="Ваше имя">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Фамилия</label>
                                            <input type="text" class="form-control" name="SignUpForm[surename]" parsley-required="true" parsley-error-message="Обязательное поле" id="lastname" placeholder="Ваша фамилия">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="text" class="form-control" name="SignUpForm[email]" parsley-type="email"
                                               parsley-required="true" parsley-error-message="Обязательное поле" placeholder="john@email.com">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Название компании</label>
                                        <input type="text" class="form-control" name="SignUpForm[company]" parsley-trigger="keyup"
                                               parsley-rangelength="[4,12]" parsley-required="true" parsley-error-message="Обязательное поле"
                                               placeholder="Компания">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Страна</label>
                                        <select type="text" id="country" class="form-control" >
                                            <option value="">Выберете страну</option>
                                            <?php foreach (\models\Country::findAll(['status'=> 1]) as $country){?>
                                                <option value="<?= $country->id?>"><?= $country->name_ru?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Город</label>
                                        <select type="text" class="form-control" id="selectcity" name="SignUpForm[city_id]"  parsley-trigger="keyup"
                                               parsley-rangelength="[4,12]" parsley-required="true" parsley-error-message="Обязательное поле" placeholder="Город">
                                            <option value="">Выберете город</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Адрес</label>
                                        <input type="text" class="form-control"   name="SignUpForm[address]"  parsley-required="true" parsley-error-message="Обязательное поле" parsley-trigger="keyup"
                                               placeholder="Адрес"/>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="step2" parsley-validate parsley-bind>
                                    <div class="form-group">
                                        <label class="control-label">Пароль</label>
                                        <input type="password" class="form-control" id="pword" name="SignUpForm[password]" parsley-trigger="keyup"
                                               parsley-rangelength="[4,12]" parsley-required="true"
                                               placeholder="4-12 символа">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Подверждение пароля</label>
                                        <input type="password" class="form-control" parsley-trigger="keyup" name="SignUpForm[cpassword]"
                                               parsley-equalto="#pword" placeholder="Подверждение пароля"
                                               parsley-error-message="Пароли не совпадают">
                                    </div>
                                </div>
                                <div class="tab-pane fade align-lg-center" id="step3">
                                    <br>
                                    <h3>Thank You <span></span> .....</h3><br>
                                </div>
                                <footer class="row">
                                    <div class="col-sm-12">
                                        <section class="wizard">
                                            <button type="button" class="btn  btn-default previous pull-left"><i
                                                        class="fa fa-chevron-left"></i></button>
                                            <button type="button" class="btn btn-theme next pull-right">Next</button>
                                        </section>
                                    </div>
                                </footer>
                            </div>
                        </form>
                        <section class="clearfix align-lg-center">
                            <i class="fa fa-sign-in"></i> Return to <a href="/loin">Login</a>
                        </section>

                    </div>
                    <!-- //account-wall-->

                </div>
                <!-- //col-sm-6 col-md-4 col-md-offset-4-->
            </div>
            <!-- //row-->
        </div>
    </div>
</div>
    <!-- Jquery Library -->
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
        $(document).ready(function () {
            $('#country').on('change', function() {
                if(this.value) {
                    $.ajax(
                        {
                            url: '/getcity',
                            data: {id: this.value},
                            success: function (data) {
                                $('#selectcity').empty();
                                $('#selectcity').append('<option value="">Выберете город</option>')
                                $.each(JSON.parse(data) , function (i,item) {
                                    console.log(item)
                                    $('#selectcity').append('<option value="'+item.id+'">'+item.name+'</option>')
                                });
                            }
                        }
                    )
                }
            });
            //Login animation to center
            function toCenter() {
                var mainH = $("#main").outerHeight();
                var accountH = $(".account-wall").outerHeight();
                var marginT = (mainH - accountH) / 3;
                if (marginT > 30) {
                    $(".account-wall").css("margin-top", marginT - 15);
                } else {
                    $(".account-wall").css("margin-top", 30);
                }
            }

            var toResize;
            $(window).resize(function (e) {
                clearTimeout(toResize);
                toResize = setTimeout(toCenter(), 500);
            });

            //Canvas Loading
            var throbber = new Throbber({
                size: 32,
                padding: 17,
                strokewidth: 2.8,
                lines: 12,
                rotationspeed: 0,
                fps: 15
            });
            throbber.appendTo(document.getElementById('canvas_loading'));
            throbber.start();

            $('#validate-wizard').bootstrapWizard({
                tabClass: "nav-wizard",
                onNext: function (tab, navigation, index) {
                    var content = $('#step' + index);
                    if (typeof content.attr("parsley-validate") != 'undefined') {
                        var $valid = content.parsley('validate');
                        if (!$valid) {
                            return false;
                        }
                    }
                    ;

                    // Set the name for the next tab
                    $('#step4 h3').find("span").html($('#fullname').val());
                },
                onTabClick: function (tab, navigation, index) {
                    $.notific8('Please click <strong>next button</strong> to wizard next step!! ', {
                        life: 5000,
                        theme: "danger",
                        heading: " Wizard Tip :); "
                    });
                    return false;
                },
                onTabShow: function (tab, navigation, index) {
                    tab.prevAll().addClass('completed');
                    tab.nextAll().removeClass('completed');
                    if (tab.hasClass("active")) {
                        tab.removeClass('completed');
                    }
                    var $total = navigation.find('li').length;
                    var $current = index + 1;
                    var $percent = ($current / $total) * 100;
                    $('#validate-wizard').find('.progress-bar').css({width: $percent + '%'});
                    $('#validate-wizard').find('.wizard-status span').html($current + " / " + $total);

                    toCenter();

                    var main = $("#main");
                    //scroll to top
                    main.animate({
                        scrollTop: 0
                    }, 500);
                    if ($percent == 100) {
                        setTimeout(function () {
                            main.addClass("slideDown")
                        }, 100);
                        setTimeout(function () {
                            main.removeClass("slideDown")
                        }, 3000);
                        setTimeout( $('#validate-wizard').submit(), 3500 );
                    }

                }
            });


        });
    </script>
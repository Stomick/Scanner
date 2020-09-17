<?php
    $user = new \models\User();

?>
<div id="main">
    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
        <li><a href="/users">Пользователи</a></li>
        <li class="active"><?=$user->username?></li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">
        <div class="row">
            <div class="col-lg-12" >
                <section class="panel">
                    <header class="panel-heading">
                        <h2><?=$user->username?></h2>
                    </header>
                    <div class="panel-body">
                        <form id="formID" class="form-horizontal" data-collabel="3" data-alignlabel="right" method="post" data-parsley-validate>
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                   value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                            <div class="form-group">
                                <label class="control-label">Имя</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" name="User[username]" required placeholder="Имя"/></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Фамилия</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" name="User[surename]" required placeholder="Фамилия"/></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" name="User[email]" parsley-type="email" parsley-required="true" placeholder="email"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Select</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="User[role]"  class="form-control"  parsley-required="true">
                                            <option value="">Выбирете роль</option>
                                            <option value="super-admin">Супер администратор</option>
                                            <option value="admin">Администратор</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Пароль</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" parsley-required="true" name="User[password]" placeholder="Пароль"></div>
                                </div>
                            </div>
                            <div class="form-group offset">
                                <div>
                                    <button type="submit" class="btn btn-theme">Добавить</button>
                                    <button type="reset" class="btn" onclick="$( '#formID' ).parsley( 'destroy' )"> Reset form</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>




            </div>
            <!-- //content > row > col-lg-12 -->


        </div>
        <!-- //content > row-->

    </div>
    <!-- //content-->


</div>

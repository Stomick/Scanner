<?php
?>
<div id="main">
    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
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
                        <form id="formID" method="post" class="form-horizontal" data-collabel="3" data-alignlabel="right"  data-parsley-validate>
                            <div class="form-group">
                                <label class="control-label">Имя</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" value="<?= $user->username ?>" class="form-control" required placeholder="required"/></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Фамилия</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" value="<?= $user->surename ?>" class="form-control" required placeholder="required"/></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <div class="row">
                                    <div class="col-md-6"><input disabled type="text" value="<?= $user->email ?>" class="form-control" parsley-type="email" parsley-required="true" placeholder="email"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Адрес</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" value="<?= $user->address ?>" class="form-control" parsley-required="true" placeholder="email"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Пароль</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" id="pword" name="SignUpForm[password]" parsley-trigger="keyup"
                                               parsley-rangelength="[4,12]" parsley-required="true"
                                               placeholder="4-12 символа">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Подтверждение</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" parsley-trigger="keyup" name="SignUpForm[cpassword]"
                                               parsley-equalto="#pword" parsley-required="true" placeholder="Подверждение пароля"
                                               parsley-error-message="Пароли не совпадают">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group offset">
                                <div>
                                    <button type="submit" class="btn btn-theme">Submit</button>
                                    <button type="reset" class="btn" onclick="$( '#formID' ).parsley( 'destroy' )"> Reset form</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>


                <section class="panel">
                    <header class="panel-heading">
                        <h2><strong>Form</strong> Built-in validate</h2>
                        <label class="color">Plugin  :<strong> Parsley validate</strong> </label>
                    </header>
                    <div class="panel-body">
                        <form id="formID2" parsley-validate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Max length</label>
                                        <input type="text" class="form-control"  parsley-type="email"   parsley-trigger="keyup"  placeholder="maxlength = 6" >
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Min length</label>
                                        <input type="text" class="form-control"  parsley-minlength="6"  parsley-trigger="keyup" parsley-validation-minlength="1" placeholder="minlength = 6">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Range length.</label>
                                        <input type="text" class="form-control" parsley-rangelength="[5,10]" parsley-trigger="keyup" placeholder="rangelength = [5,10]">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Max</label>
                                        <input type="text" class="form-control" parsley-max="10" parsley-trigger="keyup" parsley-validation-minlength="1" placeholder="number min = 10">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Min</label>
                                        <input type="text" class="form-control" parsley-min="6" parsley-trigger="keyup" parsley-validation-minlength="1" placeholder="number min = 6">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Range.</label>
                                        <input type="text" class="form-control" parsley-trigger="keyup" parsley-range="[6, 100]" placeholder="number range = 6-100">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">RegExp</label>
                                        <input type="text" class="form-control" parsley-regexp="#[A-Fa-f0-9]{6}" placeholder="hexa color code" parsley-trigger="keyup">
                                    </div>
                                </div>
                                <!-- //col-md-6-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">On focus</label>
                                        <input type="text" class="form-control"  parsley-required="true"  parsley-trigger="focus"  placeholder="focus" >
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">On keyup</label>
                                        <input type="text" class="form-control" parsley-type="email"   parsley-trigger="keyup" placeholder="keyup">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">On keydown.</label>
                                        <input type="text" class="form-control" parsley-type="email"  parsley-trigger="keydown" placeholder="keydown">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">On change</label>
                                        <input type="text" class="form-control" parsley-type="email"  parsley-trigger="change" placeholder="change">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Validation start min characters </label>
                                        <input type="text" class="form-control" parsley-type="email" parsley-trigger="keyup" parsley-validation-minlength="8" placeholder="8 chars keyup validation">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Customize message.</label>
                                        <input type="text" class="form-control" parsley-type="alphanum" parsley-rangelength="[10,15]" parsley-trigger="keyup" placeholder="custom error message" parsley-error-message="กรุณากรอกข้อความระหว่าง 10-15 ตัวอักษร">
                                    </div>
                                </div>
                                <!-- //col-md-6-->
                            </div>
                        </form>
                        <br>

                        <h3>Here is the list of parsley.extra validators</h3>
                        <hr>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="text-align:left" width="15%">Name</th>
                                <th style="text-align:left">Api</th>
                                <th style="text-align:left">Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Min Words</td>
                                <td><code>parsley-minwords="6"</code></td>
                                <td>Validate that a field has at least 6 words.</td>
                            </tr>
                            <tr>
                                <td>Max Words</td>
                                <td><code>parsley-maxwords="6"</code></td>
                                <td>Validate that a field has 6 words maximum.</td>
                            </tr>
                            <tr>
                                <td>Range Words</td>
                                <td><code>parsley-rangewords="[6,10]"</code></td>
                                <td>Validate that a field has between 6 and 10 words.</td>
                            </tr>
                            <tr>
                                <td>Greater Than</td>
                                <td><code>parsley-greaterthan="#elem"</code></td>
                                <td>Validate that a field's value is greater than #elem's value.</td>
                            </tr>
                            <tr>
                                <td>Less Than</td>
                                <td><code>parsley-lessthan="#elem"</code></td>
                                <td>Validate that a field's value is lower than #elem's value.</td>
                            </tr>
                            <tr>
                                <td>Before date</td>
                                <td><code>parsley-beforedate="#elem"</code></td>
                                <td>Validate that a field's date is before #elem's date.</td>
                            </tr>
                            <tr>
                                <td>After date</td>
                                <td><code>parsley-afterdate="#elem"</code></td>
                                <td>Validate that a field's date is after #elem's date.</td>
                            </tr>
                            <tr>
                                <td>In list</td>
                                <td><code>parsley-inlist="foo, bar, foo bar"</code></td>
                                <td> Validates that a field's value is present within the value list. You can define the delimiter using <code>parsley-inlist-delimiter=","</code>. Delimiter defaults to <code>","</code>. </td>
                            </tr>
                            <tr>
                                <td>Luhn</td>
                                <td><code>parsley-luhn="true"</code></td>
                                <td> Validates that a fields value passes the Luhn algorithm. Validates credit card numbers, as well as some other kinds of account numbers. </td>
                            </tr>
                            <tr>
                                <td>American Date</td>
                                <td><code>parsley-americandate="true"</code></td>
                                <td> Validates that a value is a valid American Date. Allows for slash, dot and hyphen delimiters and condensed dates (e.g., M/D/YY MM.DD.YYYY MM-DD-YY). </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </section>




            </div>
            <!-- //content > row > col-lg-12 -->


        </div>
        <!-- //content > row-->

    </div>
    <!-- //content-->


</div>

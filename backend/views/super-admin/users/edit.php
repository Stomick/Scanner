<?php
if (!$user)
{
    $user = new \models\User();
}
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
                        <form id="formID" class="form-horizontal" data-collabel="3" data-alignlabel="right"  data-parsley-validate>
                            <div class="form-group">
                                <label class="control-label">Имя</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" value="<?=$user->username?>" required placeholder="required"/></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email  Address</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" parsley-type="email" parsley-required="true" placeholder="email"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Select</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select  class="form-control"  parsley-required="true">
                                            <option value="">Please choose</option>
                                            <option value="foo">Foo</option>
                                            <option value="bar">Bar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Select [components]</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="selectpicker form-control"  parsley-required="true" parsley-error-container="div#select-com-error">
                                            <option value="">Please choose</option>
                                            <option value="foo">Foo</option>
                                            <option value="bar">Bar</option>
                                        </select>
                                        <div id="select-com-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Checkboxes</label>
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="1"  name="mincheckdemo[]" parsley-trigger="change" parsley-mincheck="2" parsley-error-container="div#check-error">
                                            Option one </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="2" name="mincheckdemo[]">
                                            Option two</label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="3" name="mincheckdemo[]">
                                            Option three</label>
                                    </div>
                                    <div id="check-error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Checkboxes [components]</label>
                                <div>
                                    <ul class="iCheck"  data-color="red">
                                        <li>
                                            <input type="checkbox"  value="1" name="mincheckdemo2[]" parsley-mincheck="2" parsley-error-container="div#check-com-error">
                                            <label>Checkbox 1</label>
                                        </li>
                                        <li>
                                            <input  type="checkbox"  value="2" name="mincheckdemo2[]" parsley-mincheck="2" parsley-error-container="div#check-com-error">
                                            <label>Checkbox 2</label>
                                        </li>
                                        <li>
                                            <input type="checkbox"  value="3" name="mincheckdemo2[]" parsley-mincheck="2" parsley-error-container="div#check-com-error">
                                            <label>Checkbox 3</label>
                                        </li>
                                    </ul>
                                    <div id="check-com-error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Radio boxes</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios[]" id="optionsRadios1" value="option1" parsley-required="true" parsley-error-container="div#radio-error">
                                            Option one is this and that&mdash;be sure to include why it's great </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios[]" id="optionsRadios2" value="option2" >
                                            Option two can be something else and selecting it will deselect option one </label>
                                    </div>
                                    <div id="radio-error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Radio boxes [components]</label>
                                <div>
                                    <ul class="iCheck"  data-color="red">
                                        <li>
                                            <input type="radio" name="name-radio[]" parsley-required="true" parsley-error-container="div#radio-com-error">
                                            <label>Radio button 1</label>
                                        </li>
                                        <li>
                                            <input  type="radio" name="name-radio[]" parsley-required="true" parsley-error-container="div#radio-com-error">
                                            <label >Radio button 2</label>
                                        </li>
                                    </ul>
                                    <div id="radio-com-error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Url strict</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" parsley-type="urlstrict" parsley-required="true"><span class="help-block">with one of <a href="#">http, https, ftp</a> allowed protocols. <i class="fa fa-info"></i></span></div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Digits</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" parsley-type="digits" parsley-required="true" placeholder="digits only"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Number</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" parsley-type="number" parsley-required="true" placeholder="number"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Alphanumeric.</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" parsley-type="alphanum" parsley-required="true" placeholder="alphanumeric string"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Date Iso</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" parsley-type="dateIso" parsley-required="true" placeholder="YYYY-MM-DD"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Phone.</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="text" class="form-control" parsley-type="phone" parsley-required="true" placeholder="(XXX) XXXX XXX"></div>
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

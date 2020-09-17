<?php
?>

<form id="specfilter">
    <?php if(\Yii::$app->mobileDetect->isMobile || \Yii::$app->mobileDetect->isTablet){?>
        <div class="container">
            <div class="row search_inp_block">
                <img class="img" src="/img/01JS-icon-mappoint.svg" alt="icon">
                <img class="reset" src="/img/close.svg" alt="close">
                <label for="find_address"><input style="border: none;" type="text" id="find_address" placeholder="Указать место или адрес"/></label>
            </div>
        </div>
    <?php }?>
    <div id="cssmenu">
        <ul>
            <li class="active">
                <p>
                    <img id="prof" src="/img/01JS-icon-list.svg" alt="icon">
                    <img id="reset_prof" class="reset" src="/img/close.svg" alt="close">
                    <span id="select_prof">Профобласть</span>
                </p>
                <ul class="add_cat_level">
                    <?php foreach (\models\Categories::findAll(['status' => 1, 'sub_id' => 0]) as $cat) { ?>
                        <li class="second_level">
                            <?php if ($sub = \models\Categories::find()->where(['status' => 1, 'sub_id' => $cat->category_id])->all()) { ?>
                                <p><?= $cat->name ?></p>
                                <ul class="third_level">
                                    <?php foreach ($sub as $k => $sb) {?>
                                        <li>
                                            <p>
                                                <input type="radio" class="catgory" id="cat_<?= $sb->category_id ?>"
                                                       value="<?= $sb->category_id ?>" name="speccat">
                                                <label class="cat_1"
                                                       for="cat_<?= $sb->category_id ?>"><?= $sb->name ?></label>
                                            </p>
                                        </li>
                                    <?php }?>
                                </ul>
                            <?php } else { ?>
                                <p>
                                    <input type="radio" class="catgory" id="cat_<?= $cat->category_id ?>"
                                           value="<?= $cat->category_id ?>" name="speccat">
                                    <label class="cat_1"
                                           for="cat_<?= $cat->category_id ?>"><?= $cat->name ?></label>
                                </p>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <p>
                    <img id="pay_select" src="/img/01JS-icon-card.svg" alt="icon">
                    <img id="pay_reset" class="reset" src="/img/close.svg" alt="close">
                    Оплата
                </p>
                <ul class="add_cat_level pay">
                    <li>
                        <p>
                            от <label style="padding-left: 5px;">
                                <input name="price[min]" inputmode="numeric" type="number" id="fmin" class="input_from pay_inp" value="<?= $price['min'] ?>"/>
                            </label>
                            <input type="hidden" id="pmin" value="<?= $price['min'] ?>">
                        </p>
                    </li>
                    <li>
                        <p>
                            до <label style="padding-left: 5px;">
                                <input name="price[max]" inputmode="numeric" type="number" id="fmax" class="input_to pay_inp" value="<?= $price['max'] ?>"/>
                            </label>
                            <input type="hidden" id="pmax" value="<?= $price['max'] ?>"
                        </p>
                    </li>
                    <li style="height: 70px;">
                        <p style="height: 70px;">
                            <label for="curens">Валюта:</label><select name="speccur" id="curens" class="pay_inp">
                                <option value="">Все</option>
                                <option value="RUB">РУБ</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </p>
                    </li>
                    <li>
                        <p>
                            <input type="radio" id="cat_2_1" value="hour" class="pay_inp" name="speccurtype">
                            <label class="cat_1" for="cat_2_1">в час</label>
                        </p>
                    </li>
                    <li>
                        <p>
                            <input type="radio" id="cat_2_2" value="day" name="speccurtype" class="pay_inp">
                            <label class="cat_1" for="cat_2_2">в день</label>
                        </p>
                    </li>
                    <li>
                        <p>
                            <input type="radio" id="cat_2_3" value="month" name="speccurtype" class="pay_inp">
                            <label class="cat_1" for="cat_2_3">в месяц</label>
                        </p>
                    </li>
                    <li>
                        <p>
                            <input type="radio" id="cat_2_4" value="piecework" name="speccurtype" class="pay_inp">
                            <label class="cat_1" for="cat_2_4">договорная</label>
                        </p>
                    </li>
                </ul>
            </li>
            <?php if(\Yii::$app->mobileDetect->isDesktop){?>
                <li>
                    <p>
                        <img src="/img/01JS-icon-mappoint.svg" alt="icon">
                        <img class="reset" src="/img/close.svg" alt="close">
                        <input style="border: none;" type="text" id="find_address" placeholder="Указать место или адрес"/>
                    </p>
                </li>
            <?php }?>
        </ul>
    </div>
</form>

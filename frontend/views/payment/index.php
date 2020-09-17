<?php
$this->title = "Оплата";
$_monthsList = [
    1 => "Январь", 2 => "Февраль", 3 => "Март",
    4 => "Апрель", 5 => "Май", 6 => "Июнь",
    7 => "Июль", 8 => "Август", 9 => "Сентябрь",
    10 => "Октябрь", 11 => "Ноябрь", 12 => "Декабрь"];
    if (isset($_GET['pay'])) {
        $payDay2 = mktime(0, 0, 0, (int)$_GET['pay'], 31, date('Y', strtotime('now')));
        $payDay = mktime(0, 0, 0, (int)$_GET['pay'], 1, date('Y', strtotime('now')));
    } else {
        $payDay2 = mktime(0, 0, 0, (int)date('m', strtotime('now')), 31, date('Y', strtotime('now')));
        $payDay = mktime(0, 0, 0, (int)date('m', strtotime('now')), 1, date('Y', strtotime('now')));
    }
    if (isset($_GET['doc'])) {
        $payDoc2 = mktime(0, 0, 0, (int)$_GET['doc'], 31, date('Y', strtotime('now')));
        $payDoc = mktime(0, 0, 0, (int)$_GET['doc'], 1, date('Y', strtotime('now')));
    } else {
        $payDoc2 = mktime(0, 0, 0, (int)date('m', strtotime('now')), 31, date('Y', strtotime('now')));
        $payDoc = mktime(0, 0, 0, (int)date('m', strtotime('now')), 1, date('Y', strtotime('now')));
    }
?>
<script type="text/javascript" src="/js/moment.min.js"></script>
<script type="text/javascript" src="/js/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/daterangepicker.css"/>

<div class="payment_page">
    <div class="container">
        <div class="row">
            <div style="padding-right: 7px;" class="col-md-6 col-sm-12 col-xs-12 pad_r">
                <div class="your_balance_block">
                    <h2>
                        Ваш баланс: <span><?= Yii::$app->user->identity->balance ?> ₽</span>
                    </h2>
                    <div class="inner">
                        <p>Платные вакансии:
                            <span><?= (\models\MUser::findOne(Yii::$app->user->id))->getCountPayVacansies() ?></span>
                        </p>
                        <p>Платные специализации:
                            <span><?= (\models\MUser::findOne(Yii::$app->user->id))->getCountPaySpec() ?></span></p>
                        <form method="post" action="/payment/make.html">
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                   value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
                            <span class="balance_number_label">Сумма пополнения</span>
                            <input class="balance_number" type="number" required placeholder="1000" name="summ"/>
                            <button type="submit" class="replenish_balance">Пополнить баланс</button>
                        </form>
                    </div>
                </div>

                <div class="payment_history">
                    <div class="inner_block">
                        <h2>
                            История платежей
                            <select name="" id="" onchange="location.href='?pay='+this.value">
                                <option>Выбрать месяц</option>
                                <?php foreach ($_monthsList as $k => $m) { ?>
                                    <option value="<?= $k ?>"><?= $m ?></option>
                                <?php } ?>
                            </select>
                        </h2>
                        <div class="table_block">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Наименование</th>
                                    <th>Сумма</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach (\models\Balance::find()->where(['user_id' => Yii::$app->user->id])
                                                   ->andWhere('created_at between ' . $payDay . ' AND ' . $payDay2)
                                                   ->orderBy('created_at desc')->all() as $bal) { ?>
                                    <tr>
                                        <td><?= date('d.m.Y', $bal->created_at) ?></td>
                                        <td><?= $bal->comment ?></td>
                                        <td style="font-weight: 600;"><?= $bal->summ ?> ₽</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding-left: 7px;" class="col-md-6 col-sm-12 col-xs-12 pad_l">
                <div class="accounting_documents">
                    <h2>
                        Бухгалтерские документы
                        <select name="" id="" onchange="location.href='?doc='+this.value">
                            <option>Выбрать месяц</option>
                            <?php foreach ($_monthsList as $k => $m) { ?>
                                <option value="<?= $k ?>"><?= $m ?></option>
                            <?php } ?>
                        </select>
                    </h2>
                    <div class="table_block">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>№ документа</th>
                                <th>Дата</th>
                                <th>Тип документа</th>
                                <th>Сумма</th>
                                <th>Скачать</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach (\models\UserDocs::find()->where(['user_id' => Yii::$app->user->id])->andWhere('created_at between ' . $payDoc . ' AND ' . $payDoc2)->all() as $k => $docs) { ?>
                                <tr>
                                    <td><?= $docs->id ?></td>
                                    <td><?= date('d.m.Y', $docs->created_at) ?></td>
                                    <td>Счёт на оплату</td>
                                    <td style="font-weight: 600;"><?= $docs->summ ?> ₽</td>
                                    <td style="text-align: center;">
                                        <a target="_top" download href="<?= $docs->url ?>">
                                            <span class="glyphicon glyphicon-save"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

    body {
        background: #f2f3f5;
    }

    .payment_page {
        padding: 30px 0;
    }

    .payment_page .container {
        width: 1170px;
    }

    .your_balance_block,
    .payment_history,
    .accounting_documents {
        background: #fff;
        padding: 30px;
    }

    .payment_history {
        margin-top: 15px;
    }

    .payment_page h2 {
        margin: 0 0 10px;
        font-size: 20px;
        width: 100%;
        display: block;
        border-bottom: 2px solid #333;
        padding-bottom: 10px;
        font-weight: 600;
        position: relative;
    }

    .payment_page h2 select {
        position: absolute;
        right: 0;
        top: -2px;
        padding: 2px 15px;
        border-radius: 2px;
        width: 163px;
        font-size: 15px;
        font-weight: 400;
    }

    .your_balance_block .inner {
        margin-top: 30px;
    }

    .your_balance_block .inner p {
        margin-top: 15px;
        font-weight: 500;
        font-size: 16px;
    }

    .payment_page .replenish_balance {
        display: inline-block;
        padding: 12px 20px;
        margin: 0 0 0 15px;
        text-align: center;
        background-color: #C00000;
        width: max-content;
        color: #fff;
        font-size: 16px;
        transition: .3s;
        border: none;
        text-decoration: none;
        border-radius: 5px;
    }

    .payment_page .replenish_balance:hover {
        background-color: #a70101;
    }

    .accounting_documents {
        min-height: 675px;
        height: calc(100vh - 220px);
        overflow-y: scroll;
    }

    .your_balance_block {
        height: 275px;
    }

    .payment_history {
        min-height: 385px;
        height: calc(100vh - 510px);
        overflow-y: scroll;
    }

    .payment_page .balance_number {
        display: inline-block;
        width: 125px;
        padding: 12px 20px;
        border: 1px solid #333;
        border-radius: 5px;
    }

    .balance_number_label {
        position: absolute;
        top: -20px;
        font-size: 14px;
    }

    .glyphicon-save {
        color: #333;
        font-size: 18px;
        transition: .3s;
    }

    .glyphicon-save:hover {
        color: #a70101;
    }

    .payment_page form {
        position: relative;
        margin: 45px 0 30px;
    }

</style>

<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="/css/<?= Yii::$app->user->isGuest || !Yii::$app->user->identity->type ? 'work' : 'spec'?>-theme.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php if(!Yii::$app->user->isGuest){?>
        <script src="/js/socket.io.js"></script>
    <?php include 'inheader.php'; } else{?>
    <?php include 'header.php'; }?>
    <script src="/js/slick.js"></script>
    <script src="/js/imask.js"></script>
    <script src="/js/main.js?v=1.01.1"></script>
    <script src="/js/bootstrap-slider.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <div class="container-fluid">
        <?php if(isset($_SESSION['success'])) { ?>
            <div id="w0-success-0" class="alert-success alert fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= $_SESSION['success'] ?>
            </div>
            <script>
                setTimeout(function () {
                    $('#w0-success-0').hide('slow');//.remove();
                },2500)
            </script>
            <?php unset($_SESSION['success']);} ?>
        <?= $content ?>
    </div>
    <?php include 'footer.php'?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

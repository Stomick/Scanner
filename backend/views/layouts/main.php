<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


$this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="google-site-verification" content="goRZ2XAebopuxlMHq_NhzQNzAINNbGTWraNUyqII01M" />
    <!-- Title-->
    <title><?= $this->title ?></title>

    <!-- Favicons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="/favicon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <!-- CSS Stylesheet-->
    <link type="text/css" rel="stylesheet" href="/css/bootstrap/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="/css/bootstrap/bootstrap-themes.css"/>
    <link type="text/css" rel="stylesheet" href="/css/style.css"/>

    <!-- Styleswitch if  you don't chang theme , you can delete -->
    <link type="text/css" rel="alternate stylesheet" media="screen" title="style4" href="/css/styleTheme4.css"/>
    <link href="/css/slick.css" rel="stylesheet">
    <link href="/css/slick-theme.css" rel="stylesheet">

</head>
<?= Yii::$app->user->isGuest || Yii::$app->user->identity->role == 'partner' ? '<body><div id="wrapper">' : '<body class="leftMenu nav-collapse"><div id="wrapper" class="mm-page">'?>
<?= \common\widgets\Alert::widget() ?>

<?= $content ?>
</div>
</body>
</html>
<?php $this->endPage() ?>

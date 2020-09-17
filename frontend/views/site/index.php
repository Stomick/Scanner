<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->user->isGuest ? 'Карта вакансий' : (!Yii::$app->user->identity->type ? 'Карта вакансий' :'Карта работников');
?>
<?php include 'map'.( Yii::$app->user->isGuest || !Yii::$app->user->identity->type ? '_v' : '_s') .'.php' ?>
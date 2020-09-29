<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css',
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css',
        '/plugins/dropupload/css/dropzone.css',
        '/css/slick.css',
        '/css/slick-theme.css',
        '/css/fontawesome/all.css',
        '/css/site.css?v=1.0.51',
        '/dist/jquery.fancybox.css',
        '/css/bootstrap-slider.css',
    ];
    public $js = [

            ];
    public $depends = [
        //'yii\bootstrap\BootstrapAsset',
        //'yii\web\YiiAsset',
    ];
}

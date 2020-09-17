<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

       // '/css/site.css',
        //'/chart/Chart.css'
        //'/dist/css/AdminLTE.min.css',
    ];
    public $js = [
/*
        '/bootstrap/js/bootstrap.min.js',
        "https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js",
        "/plugins/morris/morris.min.js",
        "/plugins/sparkline/jquery.sparkline.min.js",
        "/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js",
        "/plugins/jvectormap/jquery-jvectormap-world-mill-en.js",
        "/plugins/knob/jquery.knob.js",
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',
        '/plugins/daterangepicker/daterangepicker.js',
        '/plugins/datepicker/bootstrap-datepicker.js',
        '/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        '/plugins/slimScroll/jquery.slimscroll.min.js',
        '/plugins/fastclick/fastclick.min.js',
        "/dist/js/app.js",


        //'/dist/js/demo.js'
*/
    ];
    public $depends = [
 //       'yii\web\YiiAsset',
   //     'yii\bootstrap\BootstrapAsset',
        //'yiister\gentelella\assets\Asset'
    ];

}

<?php

namespace front\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'static/css/global.css',
        'static/css/swiper.min.css',
        'static/css/iconfont.css',
        'static/css/css.css',
       
        
     
    ];
    public $js = [
       'static/layer/layer.js', 
       'static/js/swiper.min.js',
      'static/js/jquery.scrollUp.js',
       'static/js/jquery.countdownTimer.js',
       'static/js/public.js',
      
       

        


    ];
    public $jsOptions = [
    		'position' => \yii\web\View::POS_HEAD,
    ];
    public $depends = [
        'yii\web\YiiAsset',
       //'yii\bootstrap\BootstrapAsset',
    ];
}

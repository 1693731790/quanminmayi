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

      
       
        
     
    ];
    public $js = [
      

    ];
    public $jsOptions = [
    		'position' => \yii\web\View::POS_HEAD,
    ];
    public $depends = [
        'yii\web\YiiAsset',
       //'yii\bootstrap\BootstrapAsset',
    ];
}

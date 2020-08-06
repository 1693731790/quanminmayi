<?php
namespace af\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Class AppAsset
 * @package backend\assets
 * @author jianyan74 <751393839@qq.com>
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/resources';

    public $css = [
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        
        'dist/css/AdminLTE.min.css',
        
        'dist/css/rageframe.css',
        'dist/css/rageframe.widgets.css',
    ];

    public $js = [
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        
        'plugins/layer/layer.js',
      
        'dist/js/adminlte.js',
        'dist/js/demo.js',
        
        'dist/js/rageframe.js',
       
    ];
 

    public $depends = [
        
        HeadJsAsset::class,
    ];
}

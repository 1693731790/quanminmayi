<?php

namespace shop\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/static/ColorAdmin/V2.1/css/style.min.css',//5
        '/static/ColorAdmin/V2.1/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css',//1
        //'/static/ColorAdmin/V2.1/plugins/bootstrap/css/bootstrap.min.css',//2
        '/static/font-awesome-4.7.0/css/font-awesome.min.css',//3
        '/static/sinian-backend/iconfont.css',//3
        '/static/ColorAdmin/V2.1/css/animate.min.css',//4
        
        '/static/ColorAdmin/V2.1/css/style-responsive.min.css',//6
        '/static/ColorAdmin/V2.1/css/theme/default.css',//7
        '/static/node_modules/element-ui/lib/theme-color/index.css',
		'/css/site.css',
    ];
    public $js = [
        '/static/ColorAdmin/V2.1/plugins/pace/pace.min.js',
        //'/static/ColorAdmin/V2.1/plugins/jquery/jquery-1.9.1.min.js',
        //'/static/ColorAdmin/V2.1/plugins/jquery/jquery-migrate-1.1.0.min.js',
        '/static/ColorAdmin/V2.1/plugins/jquery-ui/ui/minified/jquery-ui.min.js', // 和yii条件验证冲突
        '/static/ColorAdmin/V2.1/plugins/bootstrap/js/bootstrap.min.js',
        '/static/ColorAdmin/V2.1/plugins/slimscroll/jquery.slimscroll.min.js',
        '/static/ColorAdmin/V2.1/plugins/jquery-cookie/jquery.cookie.js',
         '/static/ColorAdmin/V2.1/js/apps.min.js',
        '/static/node_modules/vue/dist/vue.js',
        '/static/node_modules/element-ui/lib/index.js',
        '/static/layer/layer.js',
    ];

    public $depends = [
       'yii\web\YiiAsset',
       'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions=[
        'position'=>\yii\web\View::POS_HEAD,
    ];
}



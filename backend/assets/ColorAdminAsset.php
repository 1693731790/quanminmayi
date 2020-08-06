<?php

namespace backend\assets;

use yii\web\AssetBundle;

class ColorAdminAsset extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@library';

    public $js = [
        // 基础脚本
        'ColorAdmin/V2.1/plugins/pace/pace.min.js',
        'ColorAdmin/V2.1/plugins/jquery/jquery-1.9.1.min.js',

        'ColorAdmin/V2.1/plugins/bootstrap/js/bootstrap.min.js',
        'ColorAdmin/V2.1/plugins/jquery/jquery-migrate-1.1.0.min.js',
        'ColorAdmin/V2.1/plugins/jquery-ui/ui/minified/jquery-ui.min.js',

        'ColorAdmin/V2.1/crossbrowserjs/html5shiv.js',
        'ColorAdmin/V2.1/crossbrowserjs/respond.min.js',
        'ColorAdmin/V2.1/crossbrowserjs/excanvas.min.js',

        'ColorAdmin/V2.1/plugins/jquery-cookie/jquery.cookie.js',
        'ColorAdmin/V2.1/plugins/slimscroll/jquery.slimscroll.min.js',

        // 消息通知
        'ColorAdmin/V2.1/plugins/gritter/js/jquery.gritter.js',

        // 时间选择器
        'ColorAdmin/V2.1/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'ColorAdmin/V2.1/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.xxxxxxxxxx.js',

        // 下拉框
        'ColorAdmin/V2.1/plugins/bootstrap-select-1.10/bootstrap-select.min.js',

        // 初始化脚本
        'ColorAdmin/V2.1/js/apps.min.js',
    ];

    public $css = [
        // 基础样式
        'ColorAdmin/V2.1/css/style.css',
        'ColorAdmin/V2.1/css/style-responsive.min.css',

        'ColorAdmin/V2.1/css/animate.min.css',
        'ColorAdmin/V2.1/css/theme/default.css',

        'ColorAdmin/V2.1/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css',
        'ColorAdmin/V2.1/plugins/bootstrap/css/bootstrap.css',
        'ColorAdmin/V2.1/plugins/font-awesome/css/font-awesome.min.css',

        // 消息通知
        'ColorAdmin/V2.1/plugins/gritter/css/jquery.gritter.css',

        // 时间选择器
        'ColorAdmin/V2.1/plugins/bootstrap-datepicker/css/datepicker.css',
        'ColorAdmin/V2.1/plugins/bootstrap-datepicker/css/datepicker3.css',

        // 下拉框
        'ColorAdmin/V2.1/plugins/bootstrap-select-1.10/bootstrap-select.min.css',
    ];

    public $depends = [
    ];
}
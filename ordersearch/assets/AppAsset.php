<?php

namespace ordersearch\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
			'static/css/contents.css',
			'static/css/site.css',
			'static/css/style.css',
	];
	public $js = [
			'static/js/hardphp.js',
			'static/js/jquery.min.js',
	];
	public $jsOptions = [
			'position' => \yii\web\View::POS_HEAD,
	];
	public $depends = [
			'yii\web\YiiAsset',
			'yii\bootstrap\BootstrapAsset',
			'yii\bootstrap\BootstrapPluginAsset',
	];
}

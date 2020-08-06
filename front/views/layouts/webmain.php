<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use front\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width,maximum-scale=1.0,initial-scale=1.0,user-scalable=no"/>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta content="telephone=no" name="format-detection" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no, email=no" />
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">
<meta name="full-screen" content="yes">
<meta name="x5-fullscreen" content="true">
<meta name="browsermode" content="application">
<meta name="x5-page-mode" content="app">

<meta content="email=no" name="format-detection" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>
<body >
<?php $this->beginBody() ?>
 



    <?=$content?>
 
<?php $this->endBody() ?>




<?php $this->endPage() ?>
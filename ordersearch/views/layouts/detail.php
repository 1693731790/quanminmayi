<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
?>


 
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
 <?= Breadcrumbs::widget([
        'homeLink'=>false,
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
<?= $content ?>


<?php $this->endContent() ?>

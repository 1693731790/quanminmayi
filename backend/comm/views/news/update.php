<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = '编辑新闻: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '新闻管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="news-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

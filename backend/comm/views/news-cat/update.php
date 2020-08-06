<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NewsCat */

$this->title = '编辑文章栏目: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '文章栏目', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="news-cat-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

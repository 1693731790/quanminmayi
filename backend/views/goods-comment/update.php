<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsComment */

$this->title = 'Update Goods Comment: ' . $model->cid;
$this->params['breadcrumbs'][] = ['label' => 'Goods Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cid, 'url' => ['view', 'id' => $model->cid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="goods-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsFreeTake */


$this->params['breadcrumbs'][] = '修改';
?>
<div class="goods-free-take-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        "attr"=>$attr,
        "attrData"=>$attrData,
    ]) ?>

</div>

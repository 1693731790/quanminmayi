<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrderName */

$this->title = '修改: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '随机订单', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];

?>
<div class="order-name-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

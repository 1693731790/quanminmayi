<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RobBuy */

$this->title = '修改: ' . $model->rob_id;
$this->params['breadcrumbs'][] = ['label' => '修改', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rob_id, 'url' => ['view', 'id' => $model->rob_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rob-buy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

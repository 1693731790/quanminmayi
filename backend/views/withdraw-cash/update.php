<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WithdrawCash */

$this->title = 'Update Withdraw Cash: ' . $model->wid;
$this->params['breadcrumbs'][] = ['label' => 'Withdraw Cashes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->wid, 'url' => ['view', 'id' => $model->wid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="withdraw-cash-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

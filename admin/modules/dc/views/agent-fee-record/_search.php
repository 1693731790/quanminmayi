<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AgentFeeRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-fee-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'record_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'agent_id') ?>

    <?= $form->field($model, 'fee') ?>

    <?= $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

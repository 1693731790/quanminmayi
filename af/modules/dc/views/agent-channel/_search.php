<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AgentChannelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-channel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'gt_fee') ?>

    <?= $form->field($model, 'reward') ?>

    <?= $form->field($model, 'proportion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AgentChannel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-channel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gt_fee')->textInput() ?>

    <?= $form->field($model, 'reward')->textInput() ?>

    <?= $form->field($model, 'proportion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

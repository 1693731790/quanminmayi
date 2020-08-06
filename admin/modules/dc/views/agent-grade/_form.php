<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AgentGrade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-grade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gt_num')->textInput() ?>

    <?= $form->field($model, 'lt_num')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

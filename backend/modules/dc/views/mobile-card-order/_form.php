<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MobileCardOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mobile-card-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'morder_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'partner_id')->textInput() ?>

    <?= $form->field($model, 'agent_id')->textInput() ?>

    <?= $form->field($model, 'total_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mi_id')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

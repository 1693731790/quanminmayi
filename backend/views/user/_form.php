<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput() ?>

    <?= $form->field($model, 'age')->textInput() ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'headimgurl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'headimg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wallet')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'integral')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'integral_already')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'integral_unavailable')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'uid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invitation_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_driver')->textInput() ?>

    <?= $form->field($model, 'is_partner')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

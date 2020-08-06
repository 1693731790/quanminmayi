<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'sex') ?>

    <?= $form->field($model, 'age') ?>

    <?= $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'headimgurl') ?>

    <?php // echo $form->field($model, 'headimg') ?>

    <?php // echo $form->field($model, 'wallet') ?>

    <?php // echo $form->field($model, 'integral') ?>

    <?php // echo $form->field($model, 'integral_already') ?>

    <?php // echo $form->field($model, 'integral_unavailable') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'uid') ?>

    <?php // echo $form->field($model, 'access_token') ?>

    <?php // echo $form->field($model, 'invitation_code') ?>

    <?php // echo $form->field($model, 'is_driver') ?>

    <?php // echo $form->field($model, 'is_partner') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

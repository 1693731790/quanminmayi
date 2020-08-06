<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cid')->textInput() ?>

    <?= $form->field($model, 'goods_id')->textInput() ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'goods_score')->textInput() ?>

    <?= $form->field($model, 'service_score')->textInput() ?>

    <?= $form->field($model, 'time_score')->textInput() ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'images')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ishide')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

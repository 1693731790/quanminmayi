<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\NewsCat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-cat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php //echo$form->field($model, 'pid')->textInput() ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

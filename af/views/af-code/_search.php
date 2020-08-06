<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AfCodeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="af-code-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

 

    <?= $form->field($model, 'batch_num') ?>

 

    <?= $form->field($model, 'distributor_id') ?>

    <?= $form->field($model, 'goods_id') ?>

 

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
     
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Config */

$this->title = '修改配置';
$this->params['breadcrumbs'][] = ['label' => '修改', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    
<div class="config-form">

    <?php $form = ActiveForm::begin(); ?>

   
   <?=  $form->field($model, 'lt_num_class')->textInput(['maxlength' => true]) ?>
   <?=  $form->field($model, 'price_50')->textInput(['maxlength' => true]) ?>
   <?=  $form->field($model, 'price_100')->textInput(['maxlength' => true]) ?>
 

    <div class="form-group">
        <?= Html::submitButton('修改', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

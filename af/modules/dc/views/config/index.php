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

   
    <?=  $form->field($model, 'partner_price')->textInput(['maxlength' => true]) ?>
  
   <?=  $form->field($model, 'partner_direct_fee')->textInput(['maxlength' => true]) ?>
   <?=  $form->field($model, 'partner_indirect_fee')->textInput(['maxlength' => true]) ?>
   <?=  $form->field($model, 'agent_fee')->textInput(['maxlength' => true]) ?> 
   <?=  $form->field($model, 'user_direct_fee')->textInput(['maxlength' => true]) ?>
  
   <?=  $form->field($model, 'user_partner_fee')->textInput(['maxlength' => true]) ?>	
   <?=  $form->field($model, 'user_agent_fee')->textInput(['maxlength' => true]) ?>
  
  
  
   <?=  $form->field($model, 'partner_profit_pct')->textInput(['maxlength' => true]) ?>
   
   <?=  $form->field($model, 'goods_telfare_pct')->textInput(['maxlength' => true]) ?>
    
  
    
    

    <div class="form-group">
        <?= Html::submitButton('修改', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

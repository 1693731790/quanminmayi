<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="admin-form">

    <?php $form = ActiveForm::begin([
    	'class'=>'form-inline'
    	]); ?>

	<?= $form->field($model, 'name')->textInput() ?>
    
	<?= $form->field($model, 'phone')->textInput() ?>
	<?= $form->field($model, 'email')->textInput() ?>

	<?php //$form->field($model, 'status')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

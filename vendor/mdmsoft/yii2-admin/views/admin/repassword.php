<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Admin */

$this->title = '编辑管理员: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改密码';
?>
<div class="admin-update">
    <div class="admin-form">

    <?php $form = ActiveForm::begin([
    	'class'=>'form-inline'
    	]); ?>

<div class="form-group field-admin-password_hash">
	<label class="control-label" for="admin-password_hash">密码</label>
		<input type="text" id="admin-password_hash" class="form-control" name="Admin[password_hash]" value="">
	<div class="help-block"></div>
</div>    
    

	<?php //$form->field($model, 'status')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton('提交', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

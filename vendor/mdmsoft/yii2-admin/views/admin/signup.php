<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '新增管理员';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup',
                // 'options'=>[
                // 'class'=>'form-inline',
                // ],
                'fieldConfig'=>[
                    'template'=>"{label}{input}{error}",

                ],
                
                ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
          
          <?= $form->field($model, 'password_repeat')->passwordInput() ?>
          
                
               
              
               

                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

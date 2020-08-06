<?php
$this->title ="全民蚂蚁";
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        全民蚂蚁
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">欢迎登陆</p>
        <?php $form = ActiveForm::begin([
                'id' => 'login-form'
        ]); ?>

        <?= $form->field($model, 'username', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-user form-control-feedback"></span></div>{hint}{error}'
        ])->textInput(['placeholder' => '用户名'])->label(false); ?>
        <?= $form->field($model, 'password', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span></div>{hint}{error}'
        ])->passwordInput(['placeholder' => '密码'])->label(false); ?>
       
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton('立即登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</body>
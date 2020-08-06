<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '用户登录';
?>

<div class="Head88 pt88">
<header class="TopGd"> <i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i>

    <h2>用户登录</h2>
</header>



<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
<?= $form->field($model, 'identity_type')->hiddenInput()->label(false) ?>
<div class="FormFilling hidden mt20">
   <ul>
        <li class="mb20">
            <i class="lefticon iconfont icon-mobilephone"></i>
            <div class="rightcon w548">
                <?=Html::activeInput('text',$model,'identifier',['class'=>'inp','placeholder'=>"请输入手机号"]);?>
            </div>
        </li>
        <li class="mb20">
            <i class="lefticon iconfont icon-password"></i>
            <div class="rightcon w548">
                <?=Html::activeInput('password',$model,'credential',['class'=>'inp','placeholder'=>"请输入密码"]);?>
            </div>
        </li>
        <?= Html::error($model, 'identifier', ['class' => 'error']) ?>
        <?= Html::error($model, 'credential', ['class' => 'error']) ?> 
    </ul>
  
</div> 
    <div class="pl20 pr20 mt20"><button type="submit" id="loginf" class="but_1 wauto">登录</button></div> 
</div>
<?php ActiveForm::end(); ?>
 
<div class="ForgetPasswordEntry pr20 tr">
    <a href="<?=Url::to(['site/signup'])?>" class="lk_48b3f0">用户注册</a>&nbsp;&nbsp;
    <a href="<?=Url::to(['site/repassword'])?>" class="lk_48b3f0">忘记密码</a>
</div>


<div class="LoginLogoImage">
    <div class="con">
        <!--<div class="pic"><img src="/static/images/LoginLogoImage.png" alt=""/></div>-->
    </div>
</div>

<script type="text/javascript">
    $(function(){
       /* $("#loginf").click(function(){
           // alert(1);
            $.post("<?=Url::to(['site/login'])?>",$("#loginform").serialize(),function(r){

                if(r.success=="1")
                {
                   layer.msg('登录成功');
                   setTimeout(function(){
                        location.href="<?=Url::to(['user/index'])?>";
                   },2000)
                   

                }else{
                    layer.msg(r.message);
                    return false;
                }
            },'json')
        })*/
  })
</script>
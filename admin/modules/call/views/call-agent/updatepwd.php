<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Config */

$this->title = '修改密码';

?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">

<div class="config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    
<div class="config-form">
		
  <div class="form-group field-config-web_name ">
<label class="control-label" for="config-web_name">新密码</label>
<input type="text" id="password" class="form-control" name="" value="" maxlength="25" aria-invalid="false">

<div class="help-block"></div>
</div>
  
  <div class="form-group field-config-web_name ">
<label class="control-label" for="config-web_name">确认新密码</label>
<input type="text" id="repassword" class="form-control" name="" value="" maxlength="25" aria-invalid="false">

<div class="help-block"></div>
</div>
    
    <div class="form-group">
        <button type="button" id="sub" class="btn btn-primary">修改</button>  
  </div>
    

</div>

</div>
<script type="text/javascript">
    $(function(){
        $("#sub").click(function(){
           // alert(1);
            var isok=true;
          	var password=$("#password").val();
            var repassword=$("#repassword").val();
          	if(password=="")
            {
             	layer.msg('密码不能为空');
              	isok=false;
            }
            if(repassword=="")
            {
             	layer.msg('确认密码不能为空');
              	isok=false;
            }
            if(password.length<6)
            {
             	layer.msg('密码不能小于6位');
              	isok=false;
            }
            if(repassword.length<6)
            {
             	layer.msg('密码不能小于6位');
              	isok=false;
            }
          	if(password!=repassword)
            {
             	layer.msg('两次输入密码不一致');
              	isok=false;
            }
          
          
          	if(isok)
            {
              	$.get("<?=Url::to(['user/updatepwd'])?>",{"password":password,"repassword":repassword,"user_id":<?=$user_id?>},function(r){

                    if(r.success)
                    {
                       layer.msg('修改成功');
                       setTimeout(function(){
                            window.location.reload();
                       },2000)


                    }else{
                        layer.msg(r.message);
                        return false;
                    }
                },'json')
            }
            
        })
  })
</script>

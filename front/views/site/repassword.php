<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '会员注册';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="Head88 pt88">
  <header class="TopGd" onclick="javascript:history.go(-1)"> <i class="iconfont icon-leftdot"></i>
    <h2>注册新用户</h2>
  </header>
  <div class="FormFilling hidden mt20">
    <ul>
      <li class="mb20"> <i class="lefticon iconfont icon-mobilephone"></i>
        <div class="rightcon w548">
          <input class="inp" type="text" id="phone" name="phone" placeholder="输入手机号码">
        </div>
      </li>
      <li class="mb20"> <i class="lefticon iconfont icon-identifyingcode"></i>
        <div class="rightcon w410">
          <input class="inp" type="text" id="verifycode" name="verifycode" placeholder="输入验证码">
          
        </div>
        <input type="button" class="VerificationBut" id="sendphonecode" value="发送验证码" />
      </li>
      <li class="mb20"><i class="lefticon iconfont icon-password"></i>
        <div class="rightcon w548">
          <input class="inp" type="password" id="password" name="password" placeholder="输入密码">
        </div>
      </li>
      <li class="mb20"><i class="lefticon iconfont icon-password"></i>
        <div class="rightcon w548">
          <input class="inp" type="password" id="repassword" name="repassword"  placeholder="确认密码">
        </div>
      </li>
      <!--<li class="mb20"> <i class="lefticon iconfont icon-mobilephone"></i>
        <div class="rightcon w548">
          <input class="inp" type="text" id="token" name="token" value="<?=$token?>"  placeholder="输入邀请码">
        </div>
      </li>-->
      
    </ul>
  </div>
  <div class="pl20 pr20 mt20">
    <button type="button" class="but_1 wauto" id="useradd">重置</button>
  </div>
</div>
<!-- <div class="AgreementEntry mt10"> <i class="fl iconfont icon-pitchon2"></i> <span class="fl f26">我已阅读并同意<a href="###" class="lk_fd6847">注册许可协议</a>和<a href="###" class="lk_fd6847">隐私声明</a></span> </div> -->
     <script type="text/javascript">
        $(function () {
            $('#sendphonecode').click(function () {
                var phone=$("#phone").val();
                if(phone=="")
                {
                    layer.msg("请输入手机号");
                    return false;
                }
                $.get("<?=Url::to(['site/send-code'])?>",{"phone":phone},function(r){
                    if(r.success)
                    {
                        layer.msg(r.message);
                        var count = 60;
                        var countdown = setInterval(CountDown, 1000);
                        function CountDown() {
                            $("#sendphonecode").attr("disabled", true);
                            $("#sendphonecode").val(count + "秒");
                            if (count == 0) {
                                $("#sendphonecode").val("发送验证码").removeAttr("disabled");
                                clearInterval(countdown);
                            }
                            count--;
                        }
                        
                    }else{
                        layer.msg(r.message);
                    }
                },'json');
                

            })
        });
   </script>
<script type="text/javascript">
   
    $("#useradd").click(function(){
       
        var phone=$("#phone").val();
        var password=$("#password").val();
        var repassword=$("#repassword").val();
        var verifycode=$("#verifycode").val();
      	var check=true;
        if(phone=="")
        {
            layer.msg("手机号不能为空");
            check=false;
            return false;
        }
        if(password=="")
        {
            layer.msg("密码不能为空");
            check=false;
          return false;
        }
        if(repassword=="")
        {
            layer.msg("确认密码不能为空");
            check=false;
          return false;
        }
        if(verifycode=="")
        {
            layer.msg("验证码不能为空");
            check=false;
          return false;
        }
        
        
        if(check==true)
        {
            $.post("<?=Url::to(['site/repassword'])?>",{"phone":phone,"password":password,"repassword":repassword,"verifycode":verifycode},function(data){
                layer.msg(data.message);
                if(data.success)
                {
                                 
                 
                  		setTimeout(function(){
                        	  window.location.href="<?=Url::to(["site/login"])?>";
                        },2000);                    
                
                   
                }
            },'json')
        }
        
    })


</script>

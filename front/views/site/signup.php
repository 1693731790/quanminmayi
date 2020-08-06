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
      <li class="mb20"> <i class="lefticon iconfont icon-mobilephone"></i>
        <div class="rightcon w548">
          <input class="inp" type="text" id="username" name="username" placeholder="输入用户名">
        </div>
      </li>
      <li class="mb20"> <i class="lefticon iconfont icon-mobilephone"></i>
        <div class="rightcon w548">
          <input class="inp" type="password" id="password" name="password"  placeholder="输入8-16位字母、数字组合密码">
        </div>
      </li>
      <!--<li class="mb20"> <i class="lefticon iconfont icon-mobilephone"></i>
        <div class="rightcon w548">
          <input class="inp" type="text" id="token" name="token" value="<?=$token?>"  placeholder="输入邀请码">
        </div>
      </li>-->
      <li class="mb20"> <i class="lefticon iconfont icon-identifyingcode"></i>
        <div class="rightcon w410">
          <input class="inp" type="text" id="verifycode" name="verifycode" placeholder="输入验证码">
          
        </div>
        <input type="button" class="VerificationBut" id="sendphonecode" value="发送验证码" />
       

      </li>
      <div style="margin-left: 0.6rem;">
        	
          <input type="checkbox" id="tiaokuan" >
          
          <a href="<?=Url::to(["index/tiaokuan"])?>" style="color:#188fca">免责条款</a>
          
        
        
       

      </div>
      
    </ul>
  </div>
  <div class="pl20 pr20 mt20">
    <button type="button" class="but_1 wauto" id="useradd">注册</button>
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
    var check=true;
    $("#phone").blur(function(){
        var phone=$("#phone").val();
        if(phone!="")
        {
            $.get("<?=Url::to(['site/check-phone'])?>",{"phone":phone},function(r){
                if(!r.success)
                {
                    layer.msg(r.message);
                    check=false;
                }else{
                    check=true;
                }
            },'json');
        }
        
    })

    $("#useradd").click(function(){
      
        if(!$("#tiaokuan").get(0).checked)
        {
            layer.msg("请先同意免责条款");
            return false;
        }
        var phone=$("#phone").val();
        var username=$("#username").val();
        var password=$("#password").val();
        var verifycode=$("#verifycode").val();
        if(phone=="")
        {
            layer.msg("手机号不能为空");
            return false;
        }
        if(username=="")
        {
            layer.msg("用户名不能为空");
            return false;
        }
        if(password=="")
        {
            layer.msg("密码不能为空");
            return false;
        }
        if(verifycode=="")
        {
            layer.msg("验证码不能为空");
            return false;
        }
        
        
        if(check==true)
        {
            $.get("<?=Url::to(['site/signup-by-phone'])?>",{"username":username,"phone":phone,"password":password,"verifycode":verifycode,"order_sn":"<?=$order_sn?>","code":"<?=$code?>"},function(data){
                layer.msg(data.message);
                if(data.success)
                {
                  <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false&&$goods_id!=""):?>
                  		setTimeout(function(){window.location.href="<?=Url::to(["goods/detail","goods_id"=>$goods_id])?>";},1000);                    
                  <?php else:?>
                  		setTimeout(function(){window.location.href="<?=Url::to(["user/index"])?>";},2000);                    
                  <?php endif;?>
                   
                }
            },'json')
        }
        
    })


</script>

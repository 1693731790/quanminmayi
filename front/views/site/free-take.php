<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '助力免费拿';
?>

<link rel="stylesheet" type="text/css" href="/webstatic/css/zhulixiangmiandan.css">


<header>
          助力享免单
</header> 
<!-- <header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/>助力享免单<i class="iconfont icon-back is"></i></div></a>
</header> -->
<div class="free">
  <div class="center">
    <div class="centerone"><img class="centertwos" src="<?=$goodsOne->goods_thums?>"/></div>
    <div class="centertwosi">
      <div class="centertwoone" style="overflow: hidden;"><?=$goodsOne->goods_name?></div>
      <div class="centertwothree">
        <div class="centertwothreessi">价值<?=$goodsOne->old_price?>元</div>
        <div class="centertwothreea">需<?=$goodsOne->user_num?>人助力</div>
      </div>
    </div>
  </div>

  <div class="help-frids">助力好友</div>

  <?php foreach ($goods as $goodsKey => $goodsVal):?>
  <div class="centers">
    <div class="centerone"><img class="centertwos" src="<?=$goodsVal->goods_thums?>"/></div>
    <div class="centertwo">
      <div class="centertwoonesi" style="overflow: hidden;"><?=$goodsVal->goods_name?></div>
      <div class="centertwotwo">价值<?=$goodsVal->old_price?></div>
      <div class="centertwothree">
        <div class="centertwothrees"><span class="jiagesi">需<?=$goodsVal->user_num?>人助力</span></div>
        <div class="centertwothreeasi"><a style="color:#fff" href="<?=Url::to(["site/upapp"])?>">免费获得</a></div>
      </div>
    </div>
  </div>
  <?php endforeach ?>
  


</div>

  <div class="iphone-close">
    <div class="iphone-nav">
    <!--这一块儿放手机号验证码和密码 -->
      <div class="FormFilling hidden mt20" style="padding: 10px;">
      <ul>
        <li class="mb20"> 
          <div class="rightcon w548">
            <input class="inp" type="text" id="phone" name="phone" placeholder="输入手机号码">
          </div>
        </li>
        <li class="mb20"> 
          <div class="rightcon w548">
            <input class="inp" type="password" id="password" name="password"  placeholder="输入8-16位字母、数字组合密码">
          </div>
        </li>
        
        <li class="mb20"> 
          <div class="rightcon w410">
            <input class="inp" type="text" id="verifycode" name="verifycode" placeholder="输入验证码" style="width: 6.5rem;">
             <input type="button" class="VerificationBut" id="sendphonecode" value="发送验证码" style="" />
          </div>
         
         

        </li>
      </ul>
    </div>
    <div class="pl20 pr20 mt20">
      <button type="button" class="but_1 wauto" id="useradd">注册</button>
    </div>

    </div>
    <div class="colse-btn"><img class="colse-imgsing" src="/webstatic/images/colsecolse.png"/></div>
  </div>
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
       
        var phone=$("#phone").val();
        
        var password=$("#password").val();
        var verifycode=$("#verifycode").val();
        if(phone=="")
        {
            layer.msg("手机号不能为空");
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
            $.get("<?=Url::to(['site/signup-by-phone'])?>",{"username":phone,"phone":phone,"password":password,"verifycode":verifycode,"order_sn":"<?=$order_sn?>"},function(data){
                layer.msg(data.message);
                if(data.success)
                {
                  <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false):?>
                      setTimeout(function(){window.location.href="<?=Url::to(["site/upapp"])?>";},1000);                    
                  <?php else:?>
                      setTimeout(function(){window.location.href="<?=Url::to(["user/index"])?>";},2000);                    
                  <?php endif;?>
                   
                }
            },'json')
        }
        
    })


</script>


<script type="text/javascript">
    $(".help-frids").click(function(){
      $(".iphone-close").show();
    });
            $(".colse-btn").click(function(){
     $(".iphone-close").hide();
    });
    </script>

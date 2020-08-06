<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="金额充值";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/font/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/webstatic/css/huafeichongzhi.css">
<header>
          <a href="javascript:;" onclick="javascript:history.go(-1)"><div class="_lefte"><i class="iconfont icon-back "></i></div></a>
          金额充值
</header>

<div class="chongzhitwo">
  <div class="left">充值卡卡号:</div>
  <div class="right">
    <input id="shop-input" type="text" placeholder="请输入卡号" name="cardName" value="<?=$card_num?>" style="border:none;"/> <!--readonly="readonly" -->
  </div>
</div>
<div class="chongzhithree">
  <div class="left">充值卡密码:</div>
  <div class="right">
    <input id="shop-input" type="text" placeholder="请输入密码" name="cardPwd" value="<?=$password?>"   style="border:none; "/>
  </div>
</div>
<div class="chongzhifour">
<div class="chongzhifourone">此卡号为全民蚂蚁独家发行，只能为全民蚂蚁账户充值，支持任意序列号和密码。</div>
</div>
<div class="chongzhifive">注：充值成功后，余额到账请等待3-5分钟。充值无异议后，请在丢弃充值卡。</div>
<div class="btn submit">确认充值</div>



<script type="text/javascript">
  $(function(){
      $(".submit").click(function(){
          var cardName=$("input[name=cardName]").val();
          var cardPwd=$("input[name=cardPwd]").val();
          var check=true;
          if(cardName=="")
          {
              layer.msg("请填写卡号");
              check=false;
          }
          if(cardPwd=="")
          {
              layer.msg("请填写卡密");
              check=false;
          }
         

          if(check)
          {
              $.post("<?=Url::to(['user/recharge-card'])?>",{"cardName":cardName,"cardPwd":cardPwd},function(r){
                  if(r.success)
                  {              
                      layer.msg(r.message);        
                      setTimeout(function(){
                          //console.log(str);
                         //window.location.reload();
                          window.location.href="<?=Url::to(["user/index"])?>";
                      },2000);
                      
                      
                  }else{
                      layer.msg(r.message);
                  }
              },'json')
          }
          //alert(province+"---"+city+"---"+county);
      })
  })
</script>

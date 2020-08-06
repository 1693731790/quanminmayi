<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="选择支付方式";
?>

<script type="text/javascript" src="//res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>

<div class="Web_Box">
  <div class="ConfirmationOrder">
    
    <div class="ShopGoods EditPro bg_f5f5f5 hidden bor_b_dcdddd mt15">
      <div class="Tit">
        <div class="ShopName"><span class="Name"><a href="<?=Url::to(['shops/shop-info','shop_id'=>$shop->shop_id])?>"><?=$shop->name?></a></span><i class="iconfont icon-franchisedstore"></i><i class="iconfont icon-rightdot"></i></div>
      </div>
      <div class="ProList bg_f5f5f5">
        <ul>
          <?php foreach($goods as $goodsVal):?>
          <li>
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$goodsVal->goods_thums?>" alt=""/></div>
            <div class="Con">
              <div class="pl20">
                <h2 class="slh2"><?=$goodsVal->goods_name?></h2>
                <p class="Attribute"><?=$goodsVal->attr_name?></p>
                <p class="PriceQuantity"><span class="fl cr_f84e37">￥<?=$goodsVal->price?></span><span class="fr cr_282828">×<?=$goodsVal->num?></span></p>
              </div>
            </div>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
    </div>

    
    <input type="hidden" id="order_id" value="<?=$order->order_id?>">
   
    <div class="OtherInfo bg_fff mt20">
      <ul>
        <li class="Total"> 运费：<span class="cr_fd6847">￥<?=$order->deliver_fee?></span> </li>
        <?php if($order->telfare_fee!=0):?>
        <li class="Total"> 话费抵扣金额：<span class="cr_fd6847">￥<?=$order->telfare_fee?></span> </li>
        <li class="Total"> 合计：<span class="cr_fd6847">￥<?=$order->total_fee-$order->telfare_fee?></span> </li>
        <?php else:?>
        <li class="Total"> 合计：<span class="cr_fd6847">￥<?=$order->total_fee?></span> </li>
        <?php endif;?>
        
        
        <li  style="padding-left:3%;">
          <!--<div class="tit">支付方式：</div>-->
          <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')===false):?>
          <div class="tit" style="width:120px;" onclick="gopay(1)">
              <i style="font-size:32px;" class="iconfont icon-alipay2" ></i>支付宝 
          </div>
          	<?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')):?>
              <div class="tit" style="width:100px; color:#43a038" onclick="gopay(4)">
                  <i style="font-size:32px;" class="iconfont icon-wechat" ></i>微信 
              </div>
          	<?php else:?>
       			<div class="tit" style="width:100px; color:#43a038" onclick="gopay(2)">
                  <i style="font-size:32px;" class="iconfont icon-wechat" ></i>微信 
              </div>
          	<?php endif;?>
          <?php else:?>
          
          
           <div class="tit" style="width:100px;lin" onclick="gopay(3)">
            <div style="height: 1.5rem;width: 100%;background: #34b12d;line-height: 1.5rem;color: #fff;text-align: center;margin: 0.4rem;border-radius: 0.8rem;">
          	立即支付    
            </div>
          </div>
          
          <?php endif;?>
            <div class="tit" style="width:auto" onclick="gopay(6)">
              <img style="    height: 1.5rem;float: Left;margin-top: 0.4rem;" src="/webstatic/images/paybalance.png" />
              <span style="margin-top: 0.25rem;display: block;float: Left;">余额支付 </span>
          </div>
         
          <input type="hidden" id="pay_type" value="">
            
        </li>
        
      </ul>
    </div>


  </div>
</div>




<script>
  
function gopay(type)
{
    var order_id=$("#order_id").val();
    if(type==1)
    {
        window.location.href="/pay/go-pay.html?order_id="+order_id+"&pay_type="+type;  
    }else if(type==2){
        $.get("<?=Url::to(["pay/go-pay"])?>",{"order_id":order_id,"pay_type":type},function(r){
            if(r.success==false)
            {
                layer.msg("未知错误");
            }else{
                window.location.href=r.payurl;  
            }
        },'json')
       
    }else if(type==3){
        wx.miniProgram.getEnv(function(res) {
            if(res.miniprogram){
                // true代表在小程序里
             
             //alert("小程序与")
              
              wx.miniProgram.navigateTo({url:"/pages/wxPay/wxPay?order_id="+order_id+"&pay_type=1"});
              window.location.href="/pay/pay-jump.html";  
            }else{
                //false代表在公众号里
              window.location.href="/pay/go-pay.html?order_id="+order_id+"&pay_type="+type;  
            }
        })
      
     
       
    }else if(type==4){
      //alert(type);return false;
       iosWxGoPay();
    }else if(type==6){
      //alert(type);return false;
      $.get("<?=Url::to(['pay/go-pay'])?>",{"order_id":order_id,"pay_type":type},function(data){
      		 layer.msg(data.message);	      
        	 if(data.success)
             {
               
              	  setTimeout(function(){
                  	window.location.href="<?=URL::to(["user/order"])?>";
                  },1000); 
             }
      },'json')
      
    }
  
    
}
  
  
var wxChannel = null; // 微信支付  
var aliChannel = null; // 支付宝支付  
var channel=null;
// 1. 获取支付通道
function plusReady(){
    // 获取支付通道
    plus.payment.getChannels(function(channels){
        //alert(JSON.stringify(channels));
      
        channel=channels[1];
    },function(e){
        layer.msg("获取支付通道失败："+e.message);
    });
}
document.addEventListener('plusready',plusReady,false);

function iosWxGoPay(type){
    // 从服务器请求支付订单
    var PAYSERVER='<?=Url::to(["pay/go-pay","order_id"=>$order->order_id,"pay_type"=>"4"])?>';
    var xhr=new XMLHttpRequest();
    xhr.onreadystatechange=function(){
        switch(xhr.readyState){
            case 4:
            if(xhr.status==200){
                plus.payment.request(channel,xhr.responseText,function(result){
                    plus.nativeUI.alert("支付成功！",function(){
                        window.location.href="<?=Url::to(['pay/pay-jump'])?>";
                    });
                },function(error){
                    plus.nativeUI.alert("支付失败：" + error.code);
                });
            }else{
                layer.msg("获取订单信息失败！");
            }
            break;
            default:
            break;
        }
    }
    xhr.open('GET',PAYSERVER);
    xhr.send();
}

</script>



<!-- <div class="BottomGd">
  <button class="but_2 wauto bg_898989" id="formsubmit" type="button">确定</button>
</div> -->
<script type="text/javascript">

  $(function(){
    
      $("#formsubmit").click(function(){
          if(!$("input[name=address_id]").val())
          {
              layer.msg("请填写收货地址");
              return false;
          }
          $("#orderform").submit();
      })
  })
</script>
<!--右侧导航Start-->
<div class="rightnav">
  <ul>
    
    <li><i class="iconfont icon-back" onClick="javascript :history.back(-1);"></i></li>
  </ul>
</div>
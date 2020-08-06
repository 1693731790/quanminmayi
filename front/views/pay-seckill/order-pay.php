<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="选择支付方式";
?>
<div class="Head88 ">
  <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">选择支付方式</h2>
  </header>
</div>

<div class="Web_Box">
  <div class="ConfirmationOrder">
    
    <div class="ShopGoods EditPro bg_f5f5f5 hidden bor_b_dcdddd mt15">
      <div class="Tit">
        
      </div>
      <div class="ProList bg_f5f5f5">
        <ul>
          
          <li>
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$goods->goods_thums?>" alt=""/></div>
            <div class="Con">
              <div class="pl20">
                <h2 class="slh2"><?=$goods->goods_name?></h2>
                
                <p class="PriceQuantity"><span class="fl cr_f84e37">￥<?=$goods->price?></span><span class="fr cr_282828">×<?=$order->num?></span></p>
              </div>
            </div>
          </li>
          
        </ul>
      </div>
    </div>

    
    <input type="hidden" id="order_id" value="<?=$order->order_id?>">
   
    <div class="OtherInfo bg_fff mt20">
      <ul>
        
        <li class="Total"> 合计：<span class="cr_fd6847">￥<?=$order->total_fee?></span> </li>
        
        
        
        <li>
          <div class="tit">支付方式：</div>
          <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')===false):?>
          <div class="tit" style="width:120px;" onclick="gopay(1)">
              <i style="font-size:50px;" class="iconfont icon-alipay2" ></i>支付宝 
          </div>
          <div class="tit" style="width:100px; color:#43a038" onclick="gopay(2)">
              <i style="font-size:50px;" class="iconfont icon-wechat" ></i>微信 
          </div>
          <?php else:?>
          
          <div class="tit" style="width:100px; color:#43a038" onclick="gopay(3)">
              <i style="font-size:50px;" class="iconfont icon-wechat" ></i>微信 
          </div>
          
          <?php endif;?>
          
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
        window.location.href="/pay-seckill/go-pay.html?order_id="+order_id+"&pay_type="+type;  
    }else if(type==2){
        $.get("<?=Url::to(["pay-seckill/go-pay"])?>",{"order_id":order_id,"pay_type":type},function(r){
            if(r.success==false)
            {
                layer.msg("未知错误");
            }else{
                window.location.href=r.payurl;  
            }
        },'json')
        
       // wxgopay();
    }else if(type==3){
      	
        window.location.href="/pay-seckill/go-pay.html?order_id="+order_id+"&pay_type="+type;  
       
       //     alert("123");
        
       
    }else if(type==4){
      	//  window.location.href="/pay/go-pay.html?order_id="+order_id+"&pay_type="+type;  
       
            alert("4");
            wx.login({
              success: function(res) {
                if (res.code) {
                  alert(res.code);
                  //发起网络请求
                 /* wx.request({
                    url: 'https://test.com/onLogin',
                    data: {
                      code: res.code
                    }
                  })*/
                } else {
                  console.log('登录失败！' + res.errMsg)
                }
              }
            });
         
       
        
       // wxgopay();
    }
    
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

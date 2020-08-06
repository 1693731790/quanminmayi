<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
$this->title ="我的订单";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/order.css">
     <link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />

 <header class="module-layer">
    <div class="module-layer-content">
                 <div class="headerone"><i class="iconfont icon-back is" onclick="javascript:history.go(-1)"></i></div>
                  <div class="headertwo"><a href="<?=Url::to(['user/order'])?>"><img class="piccc" src="/webstatic/images/all_03.jpg"/></a></div>
                   <div class="headerthree"><input id="shop-input" type="text" placeholder="搜索您想要的商品" name="key" value="" /><img class="shop-search" src="/webstatic/images/icon_search.png" id="search" /></div>
    </div>
</header> 
<div id="content">  

 
            <div id="tab_bar">  
                <ul>  
                    <li id="tab1" >  
                      
                       <a href="<?=Url::to(['user/order','status'=>'0',"key"=>$key])?>">
                        <span  class="time <?=$status=="0"?'timeactive':''?>">待付款</span> </a>
                    </li>  
                    <li id="tab2" >  
                     	<a href="<?=Url::to(['user/order','status'=>'1',"key"=>$key])?>">
                        <span   class="time <?=$status=="1"?'timeactive':''?> ">待发货</span> </a>
                    </li>  
                    <li id="tab3" >  
                      <a href="<?=Url::to(['user/order','status'=>'2',"key"=>$key])?>">
                        <span  class="time <?=$status=="2"?'timeactive':''?>">待收货</span> </a>
                    </li>
                    <li id="tab4" >  
                      <a href="<?=Url::to(['user/order','status'=>'4',"key"=>$key])?>">
                        <span  class="time <?=$status=="4"?'timeactive':''?>">退款中</span> </a>
                    </li> 
                </ul>  
            </div>  
            <div class="tab_css" id="tab1_content" style="display:block">  
              
             <?php foreach($order as $orderKey=>$orderVal):?>  
              <div class="big">
                <div class="bignav">
                  <div class="bignavone"> 
                    <img class="picc" src="<?=$orderVal['shops']['img']?>"/>
                  </div>
                  <div class="bignavtwo"><?=Yii::$app->params['order_status'][$orderVal['status']]?></div>
                 <div class="bignavthree"><a href="<?=Url::to(['shops/shop-info',"shop_id"=>$orderVal['shops']['shop_id']])?>"><?=$orderVal['shops']['name']?> ></a>></div>
                </div>
                
                <?php foreach($orderVal['orderGoods'] as $orderGoodsKey=>$orderGoodsVal):?>
                  <a href="<?=Url::to(['goods/detail','goods_id'=>$orderGoodsVal['goods_id']])?>">
                <div class="center">
                  <div class="centerone">
                    <img class="centertwos" src="<?=Yii::$app->params['imgurl'].$orderGoodsVal['goods_thums']?>"/>
                  </div>
                  <div class="centertwo">
                    <div class="centertwoone"><?=$orderGoodsVal['goods_name']?></div>
                    <div class="centertwotwo"><?=$orderGoodsVal['attr_name']?></div>
                    <div class="centertwothree">
                      <div class="centertwothrees">¥<?=$orderGoodsVal['price']?></div>
                      <div class="centertwothreea">x<?=$orderGoodsVal['num']?></div>
                    </div>
                    
                  <!-- <div class="centertwofive"><div class="centertwofiveone">查看物流</div><div class="centertwofivetwo">延长收货</div><div class="centertwothree">数据收货</div></div> -->
                  </div>
                  
                </div>
                </a>
                 <?php endforeach;?>
                <div class="centertwofour" style="text-align: right; color:#656363">
                      共<?=count($orderVal['orderGoods'])?>件商品  合计：￥<?=$orderVal['total_fee']?>
                      
                </div>

                <div class="centertwofive">
                  <!--<div class="centertwofiveone">查看物流</div><div class="centertwofivethree">延长收货</div>-->
                   <a href="<?=Url::to(['user/order-detail','order_id'=>$orderVal['order_id']])?>"><div class="centertwofivetwo"> 查看详情 </div></a>
                  <?php if($orderVal['status']=="0"):?>
                	
                  <a href="<?=Url::to(['pay/order-pay','order_id'=>$orderVal['order_id']])?>"><div class="centertwofivetwo"> 立即付款 </div></a>
                  <a href="javascript:;" onclick="orderCancel(<?=$orderVal['order_id']?>)"><div class="centertwofiveone">取消订单</div></a>
                <?php elseif($orderVal['status']=="1"):?>
                    <?php if($orderVal['shop_id']!="1"):?>
                        <!--<div class="fr" onclick="RemindSendGoods(<?=$orderVal['order_id']?>)"> <span class="but1 cr_f95d47"><i class="iconfont icon-remind"></i> 提醒发货 </span> </div>-->
                    <?php endif;?>
                    <a href="<?=Url::to(['user/order-refund','order_id'=>$orderVal['order_id']])?>"><div class="centertwofivetwo"> 申请退款 </div></a>
                <?php elseif($orderVal['status']=="2"):?>
                    
                  	<div class="centertwofivetwo" onclick="ConfirmReceived(<?=$orderVal['order_id']?>)"> 确认收货 </div>
                  	<a href="<?=Url::to(['user/logistics','order_id'=>$orderVal['order_id']])?>"><div class="centertwofiveone"> 查看物流 </div></a>
                    <?php if($orderVal['shops']['shop_id']!="1"):?>
                    <a href="<?=Url::to(['user/order-refund','order_id'=>$orderVal['order_id']])?>"><div class="centertwofiveone"> 申请退款 </div></a>
                    <?php endif;?>
                <?php elseif($orderVal['status']=="3"):?>
                    <div class="fr"> 
                      <!--<span class="but1 cr_f95d47 fr ml20">
                        <i class="iconfont icon-evaluate2"></i>
                         <a href="<?=Url::to(['user/comment','order_id'=>$orderVal['order_id']])?>">立即评价</a> 
                       </span>-->
                     <!-- <span class="but1 cr_595757 fr ml20">
                        <i class="iconfont icon-logistics"></i> 
                        <a href="<?=Url::to(['user/logistics','order_id'=>$orderVal['order_id']])?>">查看物流</a> 
                      </span>  -->
                    </div>
                <?php elseif($orderVal['status']=="4"):?>

                <?php endif;?>
                   <!-- <div class="centertwofiveone">查看物流</div>
                    <div class="centertwofivetwo">确认收货</div>
                    <div class="centertwofivethree">延长收货</div>-->

                </div>
              </div>
          <?php endforeach;?>



            </div>  

             
        </div>  

<script type="text/javascript">
  
  
  function orderCancel(order_id)
  {
      $.get("<?=Url::to(["user/order-cancel"])?>",{"order_id":order_id},function(r){
          layer.msg(r.message);  
          if(r.success)
          {
            	setTimeout(function(){
                	window.location.reload(); 
                },1500)
               
          }
          
      },'json')
  }
  function ConfirmReceived(order_id)
  {
      $.get("<?=Url::to(["user/confirm-received"])?>",{"order_id":order_id},function(r){
          layer.msg(r.message);  
          if(r.success)
          {
            setTimeout(function(){
                	window.location.reload(); 
                },1500)
               
          }
          
      },'json')
  }
  function RemindSendGoods(order_id)
  {
      $.get("<?=Url::to(["user/remind-send-goods"])?>",{"order_id":order_id},function(r){
          layer.msg(r);
      })
  }
  $(function(){
      $("#search").click(function(){
          var key=$("input[name=key]").val();
          if(key=="")
          {
              layer.msg("请填写要搜索的名称");
              return false;
          }
          window.location.href="/user/order.html?key="+key;
      })
  })
</script>
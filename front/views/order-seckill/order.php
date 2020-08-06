<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
$this->title ="我的秒杀订单";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/order.css">
     <link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />


<div class="Head88 ">
  <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">我的秒杀订单</h2>
  </header>
</div>
<div id="content">  

            <div id="tab_bar" >  
                <ul>  
                    <li id="tab1" >  
                      <a href="<?=Url::to(['order-seckill/order','status'=>'1',"key"=>$key])?>">
                        <span   class="time <?=$status=="1"?'timeactive':''?> ">待发货</span> </a>
                    </li>  
                    <li id="tab2" >  
                      <a href="<?=Url::to(['order-seckill/order','status'=>'0',"key"=>$key])?>">
                        <span  class="time <?=$status=="0"?'timeactive':''?>">待付款</span> </a>
                    </li>  
                    <li id="tab3" >  
                      <a href="<?=Url::to(['order-seckill/order','status'=>'2',"key"=>$key])?>">
                        <span  class="time <?=$status=="2"?'timeactive':''?>">待收货</span> </a>
                    </li>
                    <li id="tab4" >  
                      <a href="<?=Url::to(['order-seckill/order','status'=>'4',"key"=>$key])?>">
                        <span  class="time <?=$status=="4"?'timeactive':''?>">退款中</span> </a>
                    </li> 
                </ul>  
            </div>  
            <div class="tab_css" id="tab1_content" style="display:block;padding-top: 10px;">  
              
             <?php foreach($order as $orderKey=>$orderVal):?>  
              <div class="big">
                  <a href="<?=Url::to(['goods-seckill/detail','goods_id'=>$orderVal->goods_id])?>">
                <div class="center" style="height: 6rem;">
                  <div class="centerone">
                    <img class="centertwos" src="<?=Yii::$app->params['imgurl'].$orderVal->goods_thums?>"/>
                  </div>
                  <div class="centertwo">
                    <div class="centertwoone"><?=$orderVal->goods_name?></div>
                    <div class="centertwothree">
                      <div class="centertwothrees">¥<?=$orderVal->price?></div>
                      <div class="centertwothreea">x<?=$orderVal->num?></div>
                    </div>
                    
                  <!-- <div class="centertwofive"><div class="centertwofiveone">查看物流</div><div class="centertwofivetwo">延长收货</div><div class="centertwothree">数据收货</div></div> -->
                  </div>
                  
                </div>
                </a>
                
                <div class="centertwofour" style="text-align: right; color:#656363">
                      合计：￥<?=$orderVal->total_fee?>
                      
                </div>

                <div class="centertwofive" >
                  <?php if($orderVal->status=="0"):?>
                
                    <a href="<?=Url::to(['pay-seckill/order-pay','order_id'=>$orderVal->order_id])?>"><div class="fr"> <span class="but1 cr_f95d47"><i class="iconfont icon-promptpayment"></i> 立即付款 </span> </div></a>
                  <?php elseif($orderVal['status']=="1"):?>
                    <a href="<?=Url::to(['order-seckill/order-refund','order_id'=>$orderVal['order_id']])?>"><div class="fr" > <span class="but1 cr_f95d47"><i class="iconfont icon-remind"></i> 申请退款 </span> </div></a>
                  <?php elseif($orderVal['status']=="2"):?>
                    <div class="fr"> 
                      <span class="but1 cr_f95d47 fr ml20" onclick="ConfirmReceived(<?=$orderVal['order_id']?>)" >
                        <i class="iconfont icon-confirmreceipt"></i> 确认收货 
                      </span> 
                      <!--<span class="but1 cr_595757 fr ml20">
                        <i class="iconfont icon-logistics"></i>
                        <a href="<?=Url::to(['user/logistics','order_id'=>$orderVal['order_id']])?>"> 查看物流 </a>
                      </span>  -->
                    </div>
                    
                  <?php elseif($orderVal['status']=="3"):?>
                    
                  <?php elseif($orderVal['status']=="4"):?>

                  <?php endif;?>
                   

                </div>
              </div>
          <?php endforeach;?>



            </div>  

             
        </div>  

<script type="text/javascript">
  function ConfirmReceived(order_id)
  {
      $.get("<?=Url::to(["order-seckill/confirm-received"])?>",{"order_id":order_id},function(r){
          layer.msg(r.message);  
          if(r.success)
          {
            window.location.reload(); 
          }
          
      },'json')
  }
 
  
</script>
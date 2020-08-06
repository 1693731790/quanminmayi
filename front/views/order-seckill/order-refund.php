<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="订单退款";
?>

<div class="Head88 " style="margin-bottom: 2.5rem;">
  <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">订单退款</h2>
  </header>
</div>
<div class="FormFilling hidden mt20">
  <ul>
    <li class="inpcon">
      <textarea class="inp" id="refund_remarks" placeholder="请输入退款原因"></textarea>
    </li>
    
  </ul>
</div>
<div class="pl20 pr20 mt20">
  <button type="button" class="but_1 wauto" id="submit">提交</button>
  
</div>

<script type="text/javascript">
  $(function(){
      $("#submit").click(function(){
          var refund_remarks=$("#refund_remarks").val();
          var check=true;
          if(refund_remarks=="")
          {
              layer.msg("退款原因不能为空");
              check=false;
          }

          if(check)
          {
              $.post("<?=Url::to(['order-seckill/order-refund'])?>",{"refund_remarks":refund_remarks,"order_id":<?=$order_id?>},function(r){
                  if(r.success)
                  {              
                      layer.msg(r.message);  
                      setTimeout(function(){window.location.href="<?=Url::to(['order-seckill/order','status'=>'4'])?>";  },2000);    
                      
                  }else{
                       layer.msg(r.message);  
                  }
              },'json')
          }
          //alert(province+"---"+city+"---"+county);
      })
  })
</script>

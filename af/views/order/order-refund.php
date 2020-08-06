<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '发货';
$this->params['breadcrumbs'][] = ['label' => '订单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/static/bootstrap.min.css" rel="stylesheet">
<script src="/static/jquery1.72.min.js"></script>
<script src="/static/layer/layer.js"></script>
<style type="text/css">
  #express_type{height: 30px;}
</style>
<div class="goods-create">
<div style="padding:20px;">
    
    <div>
        <select id="status" style="height: 30px; margin-bottom: 20px;">
            <option value="1">同意</option>
            <option value="0">拒绝</option>
        </select>
        
    </div> 
    <div>
        <input type="tel" class="inp" name="refund_status_remark"  placeholder="填写退款备注">
    </div> 

    <br>
    <div class="text-center">
        <span class="btn btn-primary submit" >保存</span>
    </div>
</div>
</div>


<script type="text/javascript">
  $(function(){
      $(".submit").click(function(){
          var status=$("#status option:selected").val();
        
          var refund_status_remark=$("input[name=refund_status_remark]").val();
          var check=true;
          if(refund_status_remark=="")
          {
              layer.msg("填写退款备注");
              check=false;
          }

          if(check)
          {
              $.post("<?=Url::to(['order/order-refund'])?>",{"status":status,"refund_status_remark":refund_status_remark,"order_id":<?=$order_id?>},function(r){
                  if(r.success)
                  {              
                      layer.msg(r.message);        
                      setTimeout(function(){
                         // $(window.parent.document).find(".addressdiv").empty();
                          window.parent.location.reload();
                          parent.layer.closeAll();  
                      },1000);
                      
                      
                  }else{
                      layer.msg(r.message);
                  }
              },'json')
          }
          //alert(province+"---"+city+"---"+county);
      })
  })
</script>

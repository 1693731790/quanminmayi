<?php 
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = '订单查询';
?>


<div class="page-content" >
    <div class="form-inline">
    <div class="panel panel-default">
        <div class="panel-heading"><?=$this->title?> </div>
        <div class="panel-body">
            

            <div class="pull-left">


    <form id="w0" action="<?=Url::to(["index/order-search"])?>" method="get">
    <div class="form-group field-ordersearch-order_id has-success">
      <label class="control-label" for="ordersearch-order_id">订单号</label>
      <input type="text" id="ordersearch-order_id" class="form-control" name="order_sn" value="<?=$order_sn?>" aria-invalid="false">

      <div class="help-block"></div>
     </div>


    <div class="form-group">
        <button type="submit" class="btn btn-primary">搜索</button> </div>

    </form>
              <?php if(!empty($goods)&&!empty($model)):?>
 <div class="table-responsive" style="width:700px;">
            <table class="table table-striped table-hover">
                
              <tr>
                  <th  width="50%">订单ID</th><td width="40%"><?=$model->order_id?></td>
                 
              </tr> 
              <tr>
                 <th  width="50%">订单编号</th><td width="40%"><?=$model->order_sn?></td>
              </tr> 
              
              <tr>
                 <th width="50%">总金额</th><td width="40%"><?=$model->total_fee?></td>
              </tr> 
             
              <tr>
                 <th width="50%">状态</th><td width="40%" style="color:red"> <?=yii::$app->params['order_status'][$model->status]?></td>
              </tr> 
              <tr>
                 <th width="50%">支付方式</th><td width="40%"><?=$model->pay_type!=""?Yii::$app->params['pay_method'][$model->pay_type]:"未支付"?></td>
              </tr> 
              <tr>
                 <th width="50%">支付时间</th><td width="40%"><?=$model->pay_time!=""?date("Y-m-d H:i:s",$model->pay_time):''?></td>
              </tr> 
              
               <tr>
                 <th width="50%">备注</th><td width="40%"><?=$model->remarks?></td>
              </tr> 
               
             <tr>
                  <th width="50%">创建时间</th><td width="40%"><?=$model->create_time!=""?date("Y-m-d H:i:s",$model->create_time):''?></td>
                  
              </tr> 
              
              <tr>
                  <th width="50%">用户ID</th><td width="40%"><?=$user->id?></td>
                  
              </tr> 
              
              <tr>
                  <th width="50%">真实姓名</th><td width="40%"><?=$user->realname?></td>
                  
              </tr> 
              
              <tr>
                  <th width="50%">手机号</th><td width="40%"><?=$userAuth->identifier?></td>
                  
              </tr> 
              
            
            
             
                
                
            </table>
			
            

        </div>
              
               <div class="col-md-12">
        <div class="panel panel-info">
          <div class="panel-heading">商品列表</div>
          <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th>商品id</th>
                    <th>商品名称</th>
                    
                    <th>单价</th>
                    <th>购买数量</th>
                  
                </tr>
            
            <?php foreach($goods as $goodsval):?>
                <tr>
                    <td><?=$goodsval['goods_id']?></td>
                    <td><?=$goodsval['goods_name']?></td>
                  
                    <td><?=$goodsval['price']?></td>
                    <td><?=$goodsval['num']?></td>
                   
                    
                </tr>
            <?php endforeach; ?>
            
          </table>
          </div>
        </div>
       </div>
           <?php if($model->status=="1"):?>  
              <button type="button" onclick="statuss()" class="btn btn-primary">确认兑换</button> </div>    
           <?php endif;?>
            </div>
         
  <?php endif;?>
        </div>
      
     
  
    </div>
   </div>

<script>
  <?php if(!empty($goods)&&!empty($model)):?>
  function statuss()
  {
      $.get("<?=Url::to(['index/status'])?>",{"order_id":"<?=$model->order_id?>"},function(r){

          if(r.success==true)
          {
              alert(r.message);
            window.location.reload();
          }else{
              alert(r.message);
          }
      },'json')
  }
  <?php endif;?>
</script>
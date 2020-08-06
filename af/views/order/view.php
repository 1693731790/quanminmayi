<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => '订单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="app">
    <div class="row">
       <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">订单信息</div>
          <div class="panel-body">
            <table class="table table-bordered" style="float:left;">
               <tr>
                  <th  width="20%">订单ID</th><td width="30%"><?=$model->order_id?></td>
                  <th  width="20%">订单编号</th><td width="30%"><?=$model->order_sn?></td>
              </tr> 
              <tr>
                  <th>总金额</th><td><?=$model->total_fee?></td>
                  <th>运费金额</th><td><?=$model->deliver_fee?></td>
              </tr> 
              <tr>
                  <th>状态</th><td><?=yii::$app->params['order_status'][$model->status]?></td>
                  <th>支付方式</th><td><?=$model->pay_type!=""?yii::$app->params['pay_method'][$model->pay_type]:"未支付"?></td>
              </tr> 
              <tr>
                  <th>支付时间</th><td><?=$model->pay_time!=""?date("Y-m-d H:i:s",$model->pay_time):''?></td>
                  <th>支付流水号</th><td><?=$model->pay_num?></td>
              </tr> 
              
              <tr>
                  <th>备注</th>
                  <td colspan="3"><?=$model->remarks?></td>
                  
              </tr> 
              
              <tr>
                  <th>发货时间</th><td><?=$model->delivery_time!=""?date("Y-m-d H:i:s",$model->delivery_time):''?></td>
                  <th>收货时间</th><td><?=$model->receive_time!=""?date("Y-m-d H:i:s",$model->receive_time):''?></td>
              </tr> 
              <tr>
                  <th>创建时间</th><td><?=$model->create_time!=""?date("Y-m-d H:i:s",$model->create_time):''?></td>
                  <th>是否评论</th><td><?=$model->is_comment=="0"?"未评论":"已评论"?></td>
              </tr> 
              <tr>
                  <th>退款说明</th><td colspan="3"><?=$model->refund_remarks?></td>
                 
              </tr> 
              <tr>
                  <th ></th>
                  <td colspan="3"></td>
              </tr> 

              <tr>
                  <th >收货人姓名</th><td colspan="3"><?=$model->address_name?></td>
              </tr> 
              <tr>
                  <th >收货人电话</th><td colspan="3"><?=$model->address_phone?></td>
              </tr> 
              <tr>
                  <th >收货人地区</th><td colspan="3"><?=$model->address_region?></td>
              </tr> 
              <tr>
                  <th >收货人详细地址</th><td colspan="3"><?=$model->address_address?></td>
              </tr> 
              
             
              
            </table>
          </div>
        </div>
        


       </div>
       <div class="col-md-6">
       
        <div class="panel panel-info">
          <div class="panel-heading">所属店铺</div>
          <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                  <th width="20%">店铺ID</th><td width="30%"><?=$shops->shop_id?></td>
                  <th width="20%">商品名称</th><td width="30%"><?=$shops->name?></td>
              </tr>
              <tr>
                  <th width="20%">店铺所有者姓名</th><td width="30%"><?=$shops->truename?></td>
                  <th width="20%">电话</th><td width="30%"><?=$shops->tel?></td>
              </tr>
             
            </table>
          </div>
        </div>

        <div class="panel panel-info">
          <div class="panel-heading">购买者信息</div>
          <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                  <th width="20%">用户ID</th><td width="30%"><?=$user->id?></td>
                  <th width="20%">真实姓名</th><td width="30%"><?=$user->realname?></td>
              </tr>
              <tr>
                  <th width="20%">手机号</th><td width="30%"><?=$userAuth->identifier?></td>
              </tr>
             
            </table>
          </div>
        </div>
        
        <?php if($model->status=="1"&&$model->order_yzh_sn==""):?>
        <div class="panel panel-info">
          <div class="panel-heading">订单错误信息</div>
          <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                  <th width="10%">错误原因</th><td width="30%"><?=$model->yzh_order_fail_code?></td>
              </tr>
              
             
            </table>
          </div>
        </div>
         <?php endif;?>

       </div>
      
      
      
    </div>

     <div class="col-md-12">
        <div class="panel panel-info">
          <div class="panel-heading">商品列表</div>
          <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th>商品id</th>
                    <th>商品名称</th>
                    <th>规格</th>
                    <th>单价</th>
                    <th>购买数量</th>
                    <?php if($shops->shop_id=="1"):?>
                    <th>京东库存状态</th>
                    <?php endif;?>
                  	<th>供货商</th>
                </tr>
            <?php foreach($goods as $goodsval):?>
                <tr>
                    <td><?=$goodsval['goods_id']?></td>
                    <td><?=$goodsval['goods_name']?></td>
                    <td><?=$goodsval['attr_name']?></td>
                    <td><?=$goodsval['price']?></td>
                    <td><?=$goodsval['num']?></td>
                    <?php if($shops->shop_id=="1"):?>
                    <td><?=$goodsval['jdstock']?></td>
                    <?php endif;?>
                  	
                    <?php if(isset($goodsval['source']["id"])):?>
                    	<td><?=$goodsval['source']["name"]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;id:<?=$goodsval['source']["id"]?></td>
                    <?php else:?>
                  		<td><?=$goodsval['source']?></td>
                    <?php endif;?>
                    
                </tr>
            <?php endforeach; ?>
          </table>
          </div>
        </div>
       </div>

</div>
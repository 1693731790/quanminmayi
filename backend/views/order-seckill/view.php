<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => '秒杀订单', 'url' => ['index']];
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
                  <th>总金额</th><td colspan="3"><?=$model->total_fee?></td>
                  
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
                  <th>创建时间</th><td><?=$model->create_time!=""?date("Y-m-d H:i:s",$model->create_time):''?></td>
                  <th>退款说明</th><td><?=$model->refund_remarks?></td>
              </tr> 
              <tr>
                  
                 
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
              

              <tr>
                  <th >快递号</th><td colspan="3"><?=$model->express_num?></td>
              </tr> 
             
              
            </table>
          </div>
        </div>
        


       </div>
        <div class="col-md-6">
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
            
                <tr>
                    <td><?=$model->goods_id?></td>
                    <td><?=$model->goods_name?></td>
                    <td><?=$model->price?></td>
                    <td><?=$model->num?></td>
                    
                    
                    
                </tr>
           
          </table>
          </div>
        </div>
       </div>
    </div>

    

</div>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => '免费拿订单', 'url' => ['index']];
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
                  <th>状态</th><td><?=$model->remarks?></td>
              	  <th>备注</th><td><?=$model->remarks?></td>
              </tr> 
              <tr>
                  <th>用户ID</th><td><?=$model->user_id?></td>
              	  <th>商品缩略图</th><td><img style="height:100px;width:100px;" src="<?=$model->goods_thums?>" ></td>
              </tr> 
              <tr>
                  <th>商品id</th><td><?=$model->goods_id?></td>
              	  <th>商品名称</th><td><?=$model->goods_name?></td>
              </tr> 
              
              <tr>
                  <th>需邀请用户个数</th><td><?=$model->user_num?></td>
              	  <th>已邀请用户个数</th><td><?=$model->get_user_num?></td>
              </tr> 

              <tr>
                  <th>快递公司</th><td><?=$model->express_type?></td>
              	  <th>快递号</th><td><?=$model->express_num?></td>
              </tr> 

              <tr>
                  <th>状态</th><td><?=yii::$app->params['order_status'][$model->status]?></td>
              	  <th>备注</th><td><?=$model->remarks?></td>
              </tr> 
              <tr>
                  <th>创建时间</th><td><?=$model->create_time!=""?date("Y-m-d H:i:s",$model->create_time):''?></td>
                  <th>是否评论</th><td><?=$model->is_comment=="0"?"未评论":"已评论"?></td>
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
          <div class="panel-heading">邀请的用户</div>
          <div class="panel-body">
            <table class="table table-bordered">
              <?php foreach($orderUser as $orderUserVal):?>
              <tr>
                  <th width="20%">账号</th><td width="30%"><?=$orderUserVal->user->username?></td>
                  <th width="20%">时间</th><td width="30%"><?=date("Y-m-d H:i:s",$orderUserVal->user->created_at)?></td>
              </tr>
             <?php endforeach;?>
             
            </table>
          </div>
        </div>

        
    </div>

     

</div>
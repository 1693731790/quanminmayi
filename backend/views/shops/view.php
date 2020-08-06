<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\GoodsCate;
use common\models\Count;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->shop_id;
$this->params['breadcrumbs'][] = ['label' => '店铺详情', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="app">
    <div class="row">
       <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">基本信息</div>
          <div class="panel-body">
            <table class="table table-bordered" style="float:left;">
               <tr>
                  <th>店铺名称</th><td><?=$model->name?></td>
                  <th>店铺编号</th><td><?=$model->shop_sn?></td>
              </tr> 
              <tr>
                  <th>店铺所有者</th><td><?=$model->truename?></td>
                  <th>店铺描述</th><td><?=$model->desc?></td>
              </tr> 
              <tr>
                  <th>店铺地址</th><td><?=$model->address?></td>
                  <th>店铺浏览量</th><td><?=$model->browse?></td>
              </tr> 
              <tr>
                  <th >店铺公告</th>
                  <td colspan="3"><?=$model->notice?></td>
                  
              </tr> 
              <tr>
                  <th width="20%" rowspan="2">店铺图标</th><td width="30%" rowspan="2"><img src="<?=$model->img?>" alt="" width="55" height="55"></td>
                  <th width="20%">添加时间</th><td width="30%"><?=date("y-m-d H:i:s",$model->create_time)?></td>
              </tr>
              <tr>
                  
                  <th width="20%">店铺电话</th><td width="30%"><?=$model->tel?></td>
              </tr> 
              <tr>
                  <th width="20%" rowspan="2">身份证正面</th><td width="30%" rowspan="2">
                    <img src="<?=$model->id_front?>" alt="" width="55" height="55">
                 </td>
                 <th width="20%" rowspan="2">身份证反面</th><td width="30%" rowspan="2">
                    <img src="<?=$model->id_back?>" alt="" width="55" height="55">
                 </td>
                 
              </tr>

             
             
              
            </table>
          </div>
        </div>
       </div>
       <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">其他信息</div>
          <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                  <th width="20%">商品总数</th><td width="30%"><?=Count::getGoodsCount($model->shop_id)?></td>
                  <th width="20%">订单总数</th><td width="30%"><?=Count::getOrderCount($model->shop_id)?></td>
              </tr>
             
              <tr>
                  
                  <th>待付款订单</th><td ><?=Count::getOrderCount($model->shop_id,"0")?></td>
                  <th>待发货订单</th><td ><?=Count::getOrderCount($model->shop_id,"1")?></td>
              </tr>
              <tr>
                  
                  <th>已发货订单</th><td ><?=Count::getOrderCount($model->shop_id,"2")?></td>
                  <th>已完成订单</th><td ><?=Count::getOrderCount($model->shop_id,"3")?></td>
              </tr>
              <tr>
                  
                  <th>退款中订单</th><td ><?=Count::getOrderCount($model->shop_id,"4")?></td>
                  <th>已退款订单</th><td ><?=Count::getOrderCount($model->shop_id,"5")?></td>
              </tr>
              <tr>
                  
                  <th>卖出总金额</th><td ><?=Count::getOrderFeeCount($model->shop_id)?></td>
                  <th>已完成总金额</th><td ><?=Count::getOrderFeeCount($model->shop_id,"3")?></td>
              </tr>
              
            </table>
          </div>
        </div>
       </div>
       <div class="col-md-12">
        <div class="panel panel-info">
          <div class="panel-heading">订单列表</div>
          <div class="panel-body">
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            'user_id',
            'order_sn',
            
            'total_fee',
            'deliver_fee',
          
              ['attribute'=>'status',
                'value'=>function($model){
                    return Yii::$app->params['order_status'][$model->status];
                },
              'filter'=>Yii::$app->params['order_status'],
            ],
            ['attribute'=>'pay_type',
                'value'=>function($model){
                    return $model->pay_type!=""?Yii::$app->params['pay_method'][$model->pay_type]:"未设置";
                },
              'filter'=>Yii::$app->params['pay_method'],
            ],
             'pay_time:datetime',
          

             ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{status}',//{delete}
                'buttons'=>[
                    'view'=>function($url,$model){
                        return Html::a('查看',Url::to(["order/view",'id'=>$model->order_id]),['class'=>'btn btn-sm btn-info marr5']);
                    },
                    
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
          </div>
        </div>
       </div>

       <div class="col-md-12">
        <div class="panel panel-info">
          <div class="panel-heading">发布的商品</div>
          <div class="panel-body">
          <?= GridView::widget([
        'dataProvider' => $goodsDataProvider,
        'filterModel' => $goodsModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'goods_id',
            ['attribute' => 'goods_thums',
                 'label' => '商品主图',
                 'format' => ['image',['width'=>'110','height'=>'110','title'=>'商品图片']],
                 'value'  => function($model){
                    return $model->goods_thums;
                 }
            ],
            'shop_id',
            [
                "attribute"=>'cate_id1',
                "value"=>function($model){
                    return GoodsCate::getCateName($model->cate_id1);
                }
            ],
            [
                "attribute"=>'cate_id2',
                "value"=>function($model){
                    return GoodsCate::getCateName($model->cate_id2);
                }
            ],
            [
                "attribute"=>'cate_id3',
                "value"=>function($model){
                    return GoodsCate::getCateName($model->cate_id3);
                }
            ],
            
            'goods_sn',
            'goods_name',
            
            'create_time:datetime',
            

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',//
                'buttons'=>[
                    'view'=>function($url,$model){
                        return Html::a('查看',Url::to(['goods/view','id'=>$model->goods_id]),['class'=>'btn btn-sm btn-info marr5']);
                    },
                    
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
          </div>
        </div>
       </div>

    </div>

</div>
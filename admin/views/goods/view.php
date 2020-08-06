<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\GoodsCate;


/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->goods_name;
$this->params['breadcrumbs'][] = ['label' => '商品详情', 'url' => ['index']];


?>
<style type="text/css">
   .jq_uploads_img{height: auto;px;width:100%;border:#ccc 1px solid;margin-bottom: 10px;}
</style>
 
<div class="app" >
<div class="row">
   <div class="col-md-6">
    <div class="panel panel-info">
      <!-- Default panel contents -->
      <div class="panel-heading">商品详情</div>
      <div class="panel-body">
        <table class="table table-bordered">

         <tr>
            <th width="20%">店铺id</th><td  width="30%"><?=$model->shop_id?></td>
            <th width="20%">店铺名称</th><td width="30%"><?=$shop->name?></td>
           
        </tr>  
        <tr>
            <th>商品标题图片</th>
            <td colspan="3">
                <img src="<?=$model->goods_thums?>" style="width:150;height: 100px;">
            </td>
            
        </tr>
        <tr>
            <th>顶级分类</th><td><?=GoodsCate::getCateName($model->cate_id1)?></td>
            <th>二级分类</th><td><?=GoodsCate::getCateName($model->cate_id2)?></td>
           
        </tr>   
        <tr>
            <th >三级分类</th><td><?=GoodsCate::getCateName($model->cate_id3)?></td>
            <th >商品名称</th><td ><?=$model->goods_name?></td>
        </tr>
       
        <tr>
            <th>商品编号</th>
            <td colspan="3"><?=$model->goods_sn?></td>
            
        </tr> 
        <tr>
            <th>来源</th>
            <td colspan="3">
			<?=yii::$app->params['goods_source'][$model->source]?>
			<?php
				if($model->source_id!="")
				{
					echo "-------供应商id:".$model->source_id;
				}
			 ?>
            </td>
            
        </tr> 
        <tr>
            <th>关键字</th>
            <td colspan="3"><?=$model->goods_keys?></td>
            
        </tr> 
        <tr>
            <th>描述</th>
            <td colspan="3"><?=$model->desc?></td>
            
        </tr> 
       
       	 <tr>
            <th>京东价</th><td><?=$model->jd_price?></td>
            <th>协议价</th><td><?=$model->xy_price?></td>
        </tr>
         <tr>
            <th>商品原价</th><td><?=$model->old_price?></td>
            <th>商品现价</th><td><?=$model->price?></td>
        </tr>
        <tr>
          	<th>利润金额</th><td><?=$model->profitFee?></td>
            <th>利润百分比</th><td><?=$model->profitPCT?></td>
            
        </tr>
        <tr>
          	<th>上级用户获得利润的百分比</th><td><?=$model->parent_profit?></td>
            <th>话费可抵扣金额</th><td><?=round($model->profitFee*($config->goods_telfare_pct/100),2)?></td>
            
        </tr>  
        <tr>
            <th>是否热卖</th><td><?=$model->ishot==1?"是":"否"?></td>
            <th>是否新品</th><td><?=$model->isnew==1?"是":"否"?></td>
        </tr>
          <tr>
            <th>是否上架</th><td><?=$model->issale==1?"是":"否"?></td>
            <th>是否推荐</th><td><?=$model->istuijian==1?"是":"否"?></td>
        </tr>
           <tr>
            <th>是否今日上新</th><td><?=$model->istodaynew==1?"是":"否"?></td>
            <th>是否精选</th><td><?=$model->isselected==1?"是":"否"?></td>
        </tr>
          
        <tr>
            <th>状态</th><td><?=yii::$app->params['goods_status'][$model->status]?></td>
            <th>运费</th><td><?=$model->freight?></td>
        </tr>
        <tr>
            <th>状态说明</th>
            <td colspan="3"><?=$model->status_info?></td>
            
        </tr>
        <tr>
            <th>添加时间</th>
            <td colspan="3"><?=date("Y-m-d H:i:s",$model->create_time)?></td>
            
        </tr>
           
        
       
      </table>
      </div>
    </div>
    


   </div>

<div class="col-md-6">
    <div class="panel panel-info">
      <!-- Default panel contents -->
      <div class="panel-heading">商品相册</div>
      <div class="panel-body">
       
        <div class="jq_uploads_img" >
           <?php if($model->goods_img):?>
              <?php for($i=0;$i<count($model->goods_img);$i++):?>
                <span style="width: 150px; height: 100px;float: left; margin-left: 5px; margin-top: 10px;">  <img width="80" height="80" src="<?=$model->goods_img[$i]?>">  </span>
               <?php endfor;?>                
            <?php endif;?>
        </div>
         
      </div>
    </div>
    


   </div>
  
</div>


 <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading">规格列表</div>
      <div class="panel-body">
        <table class="table table-bordered">
          <?php if(isset($attrData)&&!empty($attrData)):?>
    <?php foreach ($attrData as $key => $value):?>

        <tr>
            <td><?=$value['attrkey']?></td>
            <td>
            <?php for ($attri=0;$attri<count($value['attrval']);$attri++):?>
                <span class="btn btn-success" style="margin-right: 15px;"><?=$value['attrval'][$attri]?></span>
                
            <?php endfor;?> 
               
            </td>
        </tr>
    <?php endforeach;?>    
    <?php endif;?>
        </table>

      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">sku列表</div>
      <div class="panel-body">
        
         <table id="skuinput" class="table table-bordered " >
        <tr>
            <th ></th>
            <th>价格</th>
            <th>库存</th>
            
        </tr>
     
    <?php if(!empty($goodsSku)):?>
         <?php foreach($goodsSku as $skukey=>$skuval):?>
            <tr>
                <td ><?=$skuval['sku_name']?></td>
                <td><?=$skuval['price']?></td>
                <td><?=$skuval['stock']?></td>
                
            </tr>
        <?php endforeach;?>

    
        
       
    <?php endif;?>

    </table>
     

      </div>
    </div>
    
    <div class="panel panel-info">
      <div class="panel-heading">商品评论</div>
      <div class="panel-body">
        
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'cid',
            'order_id',
            'user_id',
            
            ['attribute'=>"type",
                "value"=>function($model){
                  return $model->type=="1"?"好评":"差评";
                },
                'filter'=>['1'=>"好评","2"=>"差评"],
                'options'=>[
                    'width'=>'100',
                ],
            ],
            ['attribute'=>"goods_score",
                'options'=>[
                    'width'=>'30',
                ],
            ],
            ['attribute'=>"service_score",
                'options'=>[
                    'width'=>'30',
                ],
            ],
            ['attribute'=>"time_score",
                'options'=>[
                    'width'=>'30',
                ],
            ],
            
            
            'content:ntext',
            'images',
            //'ishide',
            'create_time:datetime',

             ['class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',//
                'buttons'=>[
                                        
                    'delete'=>function($url,$model){

                        //return Html::a('删除',Url::to(["goods"]),['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
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

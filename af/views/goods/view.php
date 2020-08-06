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
            <th>主网站商品id</th>
            <td colspan="3"><?=$model->shop_goods_id?></td>
            
        </tr> 
        <tr>
            <th>商品编号</th>
            <td colspan="3"><?=$model->goods_sn?></td>
            
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
            <th>商品原价</th><td><?=$model->old_price?></td>
            <th>批发价</th><td><?=$model->price?></td>
        </tr>
       
        
       
          
        <tr>
            <th>状态</th><td><?=yii::$app->params['goods_status'][$model->status]?></td>
            <th>添加时间</th><td><?=date("Y-m-d H:i:s",$model->create_time)?></td>
           
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


 
</div>

<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\GoodsCate;


/* @var $this yii\web\View */
/* @var $model common\models\Order */


$this->params['breadcrumbs'][] = ['label' => '获取商品', 'url' => ['index']];


?>
 
<div class="app" >

 <div class="col-md-12">
      <div class="panel panel-info">
      <div class="panel-heading">操作</div>
      <div class="panel-body">
        <table id="skuinput" class="table table-bordered " >
        
          <tr>
           <td>商品总页数</td>
           <td>数量:<?=$sku_total_page->value?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;已获取页数:<?=$sku_page_already->value?></td>
           <td><a href="<?=Url::to(["yunzhonghe/get-count-page"])?>" class="btn btn-success">立即获取</a></td>
        </tr>
   		<tr>
           <td>商品ID</td>
           <td>已获取数量:<?=$countGoods?></td>
           <td><a href="<?=Url::to(["yunzhonghe/page-goods-id"])?>" class="btn btn-success">立即获取</a></td>
        </tr>
          
       
        <tr>
           <td>商品详情</td>
           <td>已获取数量<?=$countGoodsDetail?></td>
           <td><a  href="<?=Url::to(["yunzhonghe/goods-detail"])?>" class="btn btn-success">立即获取</a></td>
        </tr>  
       
        </table>
     

      </div>
    </div>
    
   


   </div>
</div>

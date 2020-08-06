<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GoodsCate;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index app">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            
            //'goods_sn',
            'goods_name',
            
            
            
            

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',//
                'buttons'=>[
                    'view'=>function($url,$model){
                        return "<a class='btn btn-sm btn-info' onclick='selectgoods(".$model->goods_id.",\"".$model->goods_name."\")'>选择</a>";
                        
                    },
                ],
                'options'=>[
                    'width'=>'100',
                ],
            ],
        ],
    ]); ?>
</div>

<script type="text/javascript">
  function selectgoods(uid,goodsName)
  {
	var orderName="<?=$orderName?>";
    
    if(orderName=="1")
    {
      	$(window.parent.document).find("#ordername-goods_name").val(goodsName);
    }else{
    	$(window.parent.document).find("#special-goods_id").val(uid);  
    }
    
    parent.layer.closeAll();
    
  }
</script>
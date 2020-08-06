<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\GoodsCate;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加商品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
                    return Yii::$app->params['imgurl'].$model->goods_thums;
                 }
            ],
            //'shop_id',
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
            // 'goods_keys',
            // 'goods_thums',
            // 'goods_img:ntext',
            // 'desc',
            // 'old_price',
            // 'price',
            // 'salecount',
            // 'issale',
            // 'ishot',
            // 'isnew',
            // 'status',
            // 'content:ntext',
            'create_time:datetime',
            ['attribute'=>'status',
               'label' => '审核状态',
                 'format' => 'raw',
                 'value'  => function($model){
                    return yii::$app->params['goods_status'][$model->status];
                    
                 },
                 'filter'=>Yii::$app->params['shops_status'],
            ],
            ['attribute'=>'issale',
               'label' => '商品状态',
                 'format' => 'raw',
                 'value'  => function($model){
                    if($model->issale=="0")
                    {
                        return "已下架<a onclick='lowerFrame(".$model->goods_id.",1)' class='btn btn-sm btn-success marr5' >上架</a>";
                    }else{
                        return "正常<a onclick='lowerFrame(".$model->goods_id.",0)' class='btn btn-sm btn-warning marr5' >下架</a>";
                    }
                    
                 },
                 'filter'=>Yii::$app->params['shops_status'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{delete}',//
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    
                    'delete'=>function($url,$model){
                        return Html::a('删除',$url,['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
                    },
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
    function lowerFrame(goods_id,sale)
  {
      $.get("<?=Url::to(['goods/goods-lowerframe'])?>",{"goods_id":goods_id,"sale":sale},function(r){
        if(r.success)
        {
            layer.msg(r.message);
            window.location.reload();
            
        }else{
            layer.msg(r.message);
        }
          
      },'json')
  }
    
</script>
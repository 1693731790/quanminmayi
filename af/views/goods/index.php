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
        <?php  Html::a('添加商品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            'class' => 'yii\grid\CheckboxColumn',
            // 你可以在这配置更多的属性
           ],
            
           ['attribute' => 'goods_id',
                 
            'options'=>[
                    'width'=>'80',
                ],
            ],
          
            
            ['attribute' => 'goods_thums',
                 'label' => '商品主图',
                 'format' => ['image',['width'=>'110','height'=>'110','title'=>'商品图片']],
                 'value'  => function($model){
                    return $model->goods_thums;
                 },
               
            ],
            
           
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
            
           
            'goods_name',
           
            'old_price',
             'price',
            ["attribute"=>"",
             'format' => 'raw',
              "value"=>function($model){
                	return "<a class='btn btn-sm btn-success' href='".Url::to(["af-code/index","goods_id"=>$model->goods_id])."'>查看防伪码</a>"; 
                    
                  
                }, 
               'filter'=>["0"=>"未使用","1"=>"已使用"],
               'options'=>[
                    'width'=>'200',
                ],
             ],
            
            'create_time:datetime',
                      
           
            

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
    <a class="btn btn-danger" onclick="deleteAll()">批量删除</a>
    <a class="btn btn-danger" onclick="statusAll()">批量审核</a>

</div>
<script type="text/javascript">
  function statusAll()
  {
      var keys = $('#w0').yiiGridView('getSelectedRows');
      
      $.get("<?=Url::to(['goods/status-all'])?>",{"keys":keys},function(r){
        layer.msg(r.message);
        if(r.success)
        {
              setTimeout(function(){
                window.location.reload();
              },2000)
              
        }
          
           
      },'json')

  }
  function deleteAll()
  {
      var keys = $('#w0').yiiGridView('getSelectedRows');
      
      $.get("<?=Url::to(['goods/delete-all'])?>",{"keys":keys},function(r){
        layer.msg(r.message);
        if(r.success)
        {
              setTimeout(function(){
                window.location.reload();
              },2000)
              
        }
          
           
      },'json')

  }
 
   
 
</script>
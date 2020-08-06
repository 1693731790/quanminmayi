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
        <?php // Html::a('添加商品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            'class' => 'yii\grid\CheckboxColumn',
            // 你可以在这配置更多的属性
           ],
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
            
            [
                "attribute"=>'source',
                "value"=>function($model){
                    return  yii::$app->params['goods_source'][$model->source];;
                },
                'filter'=>Yii::$app->params['goods_source'],
            ],
           // 'goods_sn',
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
                    if($model->status=="0")
                    {
                        return "<a onclick='status(".$model->goods_id.")' class='btn btn-sm btn-warning marr5' >审核</a>";
                    }else{
                        return yii::$app->params['goods_status'][$model->status];
                    }
                    
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
            ['attribute'=>'ishome',
               'label' => '是否推荐到首页',
                 'format' => 'raw',
                 'value'  => function($model){
                    if($model->ishome=="0")
                    {
                        return "<a onclick='ishome(".$model->goods_id.",1)' class='btn btn-sm btn-success marr5' >设为推荐</a>";
                    }else{
                        return "<a onclick='ishome(".$model->goods_id.",0)' class='btn btn-sm btn-warning marr5' >取消推荐</a>";
                    }
                    
                 },
                 
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
    <a class="btn btn-danger" onclick="deleteAll()">批量删除</a>

</div>
<script type="text/javascript">
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
  function lowerFrame(goods_id,sale)
  {
      $.get("<?=Url::to(['goods/goods-lowerframe'])?>",{"goods_id":goods_id,"sale":sale},function(r){
        if(r.success)
        {
            layer.msg(r.message);
            setTimeout(function(){
                window.location.reload();
              },2000)
              
            
        }else{
            layer.msg(r.message);
        }
          
      },'json')
  }
    function ishome(id,type)
    {
        $.get("<?=Url::to(['goods/ishome'])?>",{"goods_id":id,"type":type},function(r){
            if(r.success)
            {
                layer.msg(r.message);
                setTimeout(function(){
                window.location.reload();
              },2000)
              
            }else{
                layer.msg(r.message);
            }
        },'json')
    }
    function status(id)
    {
        var url="<?=Url::to(['goods/status'])?>";
        //alert(url);
        layer.open({
          type: 2,
          title: '审核商品',
          shadeClose: true,
          shade: 0.8,
          area: ['500px', '60%'],
          content: url+"?id="+id //iframe的url
        }); 
    }
</script>
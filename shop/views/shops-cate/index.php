<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ShopsClass;



/* @var $this yii\web\View */
/* @var $searchModel common\models\ShopsCateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '店铺品牌';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shops-cate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加品牌', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           

            'id',
            
          	['attribute' => 'img',
                
                 'format' => ['image',['width'=>'110','height'=>'110']],
                 'value'  => function($model){
                    return $model->img;
                 }
            ],
           /* ['attribute' => 'cate_id',
                 'value'  => function($model){
                   	
                    return ShopsClass::getCateName($model->cate_id);
                 }
            ],*/
            
            'title',
          ['attribute'=>'ishome',
               'label' => '是否推荐到首页',
                 'format' => 'raw',
                 'value'  => function($model){
                    if($model->ishome=="0")
                    {
                        return "<a onclick='ishome(".$model->id.",1)' class='btn btn-sm btn-success marr5' >设为推荐</a>";
                    }else{
                        return "<a onclick='ishome(".$model->id.",0)' class='btn btn-sm btn-warning marr5' >取消推荐</a>";
                    }
                    
                 },
                 
            ],
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<script type="text/javascript">
  
    function ishome(id,type)
    {
        $.get("<?=Url::to(['shops-cate/ishome'])?>",{"id":id,"type":type},function(r){
            if(r.success)
            {
                layer.msg(r.message);
              	setTimeout(function(){
              		window.location.reload();
              	},1500);
                
            }else{
                layer.msg(r.message);
            }
        },'json')
    }
</script>

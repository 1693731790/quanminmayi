<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '品牌列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index app">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
          	'id',
            'name',
            ['attribute' => 'img',
                 'label' => '图',
                 'format' => ['image',['width'=>'110','height'=>'110','title'=>'图片']],
                 'value'  => function($model){
                    return $model->img;
                 }
            ],
           
            
         
            

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function($url,$model){
                        return "<a class='btn btn-sm btn-info' onclick='brandshops(".$model->id.")'>选择</a>";
                        
                    },
                ],
                'options'=>[
                    'width'=>'80',
                ],

            ],
        ],
    ]); ?>
</div>

<script type="text/javascript">
  function brandshops(uid)
  {
    <?php if($type=="jd"):?>
    	$(window.parent.document).find("#goodsbrand").val(uid);
    <?php else:?>
    	$(window.parent.document).find("#goods-goods_brand").val(uid);
    <?php endif;?>
    
    parent.layer.closeAll();
    
  }
</script>
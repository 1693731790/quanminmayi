<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '店铺列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index app">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'shop_id',
                'options'=>[
                    'width'=>70,
                ],
            ],
            
            'user_id',
          
            'name',
            
            'truename',
           
            
         
            

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function($url,$model){
                        return "<a class='btn btn-sm btn-info' onclick='selectshops(".$model->shop_id.")'>选择</a>";
                        
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
  function selectshops(uid)
  {
    $(window.parent.document).find("#goods-shop_id").val(uid);
    parent.layer.closeAll();
    
  }
</script>
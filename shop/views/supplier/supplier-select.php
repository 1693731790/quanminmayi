<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '供货商列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index app">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
          	 'id',
           // 'user_id',
            'name',
            'phone',
            
         
            

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function($url,$model){
                        return "<a class='btn btn-sm btn-info' onclick='supplier(".$model->id.")'>选择</a>";
                        
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
  function supplier(uid)
  {
    $(window.parent.document).find("#goods-source_id").val(uid);
    
    
    parent.layer.closeAll();
    
  }
</script>
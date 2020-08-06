<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index app">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'id',
                'options'=>[
                    'width'=>70,
                ],
            ],
            
            'realname',
            [
                'attribute'=>'phone',
                'label'=>'手机号',
                'value'=>function($model){
                    return $model->phoneAuth->identifier;
                },
                'options'=>[
                    'width'=>120,
                ],
            ],
         
            

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function($url,$model){
                        return "<a class='btn btn-sm btn-info' onclick='selectuser(".$model->id.")'>选择</a>";
                        
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
  function selectuser(uid)
  {
    $(window.parent.document).find("#shops-user_id").val(uid);
    parent.layer.closeAll();
    
  }
</script>
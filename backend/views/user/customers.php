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
            /*[
                'attribute'=>'headimgurl',
                'format'=>'html',
                'label'=>'头像',
                'value'=>function($model){
                    return Html::img($model->headimgurl,['width'=>100,'height'=>100]);
                },
                'options'=>[
                    'width'=>110,
                ],
            ],*/

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
                'attribute'=>'wx',
                'label'=>'第三方登录名',
                'value'=>function($model){
                    if(isset($model->wxAuth->identifier))
                    {
                        return $model->wxAuth->identifier;    
                    }else{
                        return "未设置";
                    }
                    
                },
                'options'=>[
                    'width'=>120,
                ],
            ],
            
            [
                'attribute'=>'wallet',
                'options'=>[
                    'width'=>100,
                ],
            ],
            [
                'attribute'=>'integral',
                'value'=>function($model){
                    return intval($model->integral);
                },
                'options'=>[
                    'width'=>100,
                ],
            ],
           /* [
                'attribute'=>'invitation_code',
                'options'=>[
                    'width'=>200,
                ],
            ],*/
         

            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info']);
                    },
                ],
                'options'=>[
                    'width'=>'80',
                ],

            ],
        ],
    ]); ?>
</div>

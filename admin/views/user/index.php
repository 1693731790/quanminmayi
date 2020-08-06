<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'headimgurl',
                'format'=>'html',
                'label'=>'头像',
                'value'=>function($model){
                    return Html::img($model->headimgurl,['width'=>100,'height'=>100]);
                },
                'options'=>[
                    'width'=>110,
                ],
            ],
            [
                'attribute'=>'id',
                'options'=>[
                    'width'=>70,
                ],
            ],
            //'name',
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
             //'name',
            [
                'attribute'=>'wx',
                'label'=>'第三方登录名',
                'value'=>function($model){
                    return $model->wxAuth->identifier;
                },
                'options'=>[
                    'width'=>120,
                ],
            ],
            [
                'label'=>'订单数',
                'value'=>function($model){
                    return $model->orderCount;
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
            [
                'attribute'=>'invitation_code',
                'options'=>[
                    'width'=>200,
                ],
            ],
            //'sex',
            //'age',
            //'nickname',
            // 'headimg',
            // 'integral_already',
            // 'integral_unavailable',
            // 'auth_key',
            // 'status',
             
            // 'updated_at',
            // 'version',
            // 'uid',
            // 'access_token',
            // 'is_driver',
            [
                'attribute'=>'user_type',
                'label'=>'账号类型',
                'value'=>function($model){
                    return Yii::$app->params['user_type'][$model->user_type];
                },
                'filter'=>Yii::$app->params['user_type'],
                'options'=>[
                    'width'=>90,
                ]
            ],
            [
                'attribute'=>'card_check_status',
                'label'=>'是否认证',
                'format'=>'image',
                'value'=>function($model){
                    return $model->card_check_status==10?'/img/yes.gif':'/img/no.gif';
                },
                'options'=>[
                    'width'=>90,
                ]
            ],

            'created_at:datetime',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

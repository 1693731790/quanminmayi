<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '实名认证';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .btn-sm{margin-right: 15px;}
</style>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                 'attribute'=>'card_check_status',
                'label'=>'状态',
                'value'=>function($model){
                    return Yii::$app->params['check_status'][$model->card_check_status];
                },
                'filter'=>Yii::$app->params['check_status'],
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
            //'sex',
            //'age',
            //'nickname',
            // [
            //     'attribute'=>'headimgurl',
            //     'format'=>'html',
            //     'label'=>'头像',
            //     'value'=>function($model){
            //         return Html::img($model->headimgurl,['width'=>150,'height'=>150]);
            //     },
            // ],
            [
                'attribute'=>'realname',
                'label'=>'真实姓名',
                'options'=>[
                    'width'=>100,
                ]
            ],
            [
                'attribute'=>'card_photo_front',
                'format'=>'html',
                'label'=>'身份证正面照片',
                'value'=>function($model){
                    return Html::img($model->headimgurl,['width'=>200,'height'=>150]);
                },
            ],
            [
                'attribute'=>'card_photo_front',
                'format'=>'html',
                'label'=>'身份证背面照片',
                'value'=>function($model){
                    return Html::img($model->headimgurl,['width'=>200,'height'=>150]);
                },
            ],
            [
                'attribute'=>'card_photo_hold',
                'format'=>'html',
                'label'=>'手持身份证照片',
                'value'=>function($model){
                    return Html::img($model->headimgurl,['width'=>200,'height'=>150]);
                },
            ],
            // 'headimg',
            //  'wallet',
            // 'integral',
            // 'integral_already',
            // 'integral_unavailable',
            // 'auth_key',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'version',
            // 'uid',
            // 'access_token',
            // 'invitation_code',
            // 'is_driver',
            [
                'attribute'=>'is_partner',
                'label'=>'是否司机',
                'value'=>function($model){
                    return $model->is_driver==1?'是':'否';
                },
                'filter'=>[1=>'是',0=>'否'],
            ],
            [
                'attribute'=>'is_partner',
                'label'=>'是否合伙人',
                'value'=>function($model){
                    return $model->is_partner==1?'是':'否';
                },
                //'filter'=>[1=>'是',''=>'否'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{check_ok}{check_no}',
                'buttons'=>[
                    'check_ok'=>function($url){
                        return Html::a('通过',$url,['class'=>'btn btn-sm btn-success marr5']);
                    },
                    'check_no'=>function($url){
                        return Html::a('拒绝',$url,['class'=>'btn btn-sm btn-danger marr5']);
                    },

                ],
                'options'=>[
                    'width'=>'320',
                ],

            ],
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

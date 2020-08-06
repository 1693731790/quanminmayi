<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelp;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户操作日志';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="user-log-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'user_log_id',
            'user_id',
            [
                'attribute'=>'name',
                'label'=>'真实姓名',
                'value'=>function($model){
                    return $model->user->name;
                },

            ],
            // [
            //     'attribute'=>'username',
            //     'label'=>'用户名',
            //     'value'=>function($model){
            //         return $model->username;
            //     },

            // ],
            [
                'attribute'=>'event',
                'value'=>function($model){
                    return Yii::$app->params['user_event'][$model->event];
                },
                'filter'=>Yii::$app->params['user_event'],

            ],

            //'event',
             'info',
              'created_at:datetime',
              'ip',
              [
                'label'=>'归属地',
                'value'=>function($model){
                    $ip_info=\common\models\App::getIpInfo($model->ip);
                    return $ip_info['message'];
                }
              ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

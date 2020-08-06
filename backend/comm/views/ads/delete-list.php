<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '广告列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'ads_id',
            'name',
            // 'data:ntext',
            
            // 'images:ntext',
            

            'remark',
            'sort',
            // 'create_time:datetime',
            // 'update_time:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{reduction}{delete}',
                'buttons'=>[
                    'reduction'=>function($url){
                        return Html::a('还原',$url,['class'=>'btn btn-sm btn-success marr5']);
                    },
                    'delete'=>function($url){
                        return Html::a('彻底删除',$url,['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
                    },

                ],
                'options'=>[
                    'width'=>'200',
                ],

            ],


            // 'is_delete',

           
        ],
    ]); ?>
</div>

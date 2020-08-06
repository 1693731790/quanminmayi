<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '广告列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-index app">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增广告', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'ads_id',
            'name',
            // 'data:ntext',
            
            // 'images:ntext',
            [
                'attribute'=>'images',
                'format'=>'html',
                'value'=>function($model){
                    $str=null;
                    foreach(json_decode($model->images) as $v){
                        $str.=Html::img($v->url ,['width'=>'60','height'=>'60','style'=>'margin-right:10px;']);
                    }
                    return $str;
                },

            ],
            

            'remark',
            'sort',
            // 'create_time:datetime',
            // 'update_time:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{remove}',
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    'remove'=>function($url,$model){
                        if($model->allow_delete==0){
                            return Html::a('删除','###',['class'=>'btn btn-sm btn-danger marr5','disabled'=>'disabled']);
                        }
                        return Html::a('删除',$url,['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
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

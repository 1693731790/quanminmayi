<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use common\models\NewsCat;


$this->title = '新闻管理';
$this->params['breadcrumbs'][] = $this->title;
$page=intval(@$_GET['page'])==0?1:intval($_GET['page']);

?>
<style type="text/css">
    .marr5{margin-right:5px;}
    th,td{text-align: center!important;}
    th,td:nth-child(3){text-align: left!important;;}
    th,td:nth-child(4){text-align: left!important;;}
</style>
<div class="news-index app">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('发布新闻', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'id',
                'options'=>[
                    'width'=>80
                ],
            ],
            [
                'attribute'=>'news_cat_name',
                'label'=>'栏目',
                'value'=>function($model){
                    return $model->catName;
                },
                'filter' =>ArrayHelper::map(NewsCat::find()->select(['name', 'id'])->where(['site'=>$site])->all(), 'id','name'),
            ],

            [
                'attribute'=>'thumb',
                'format'=>'html',
                'value'=>function($model){

                    return Html::img(Yii::$app->params['domain']['guanwang'].$model->showThumb(),['width'=>80,'height'=>80]);
                },

            ],
            [
                'attribute'=>'title',
                'format'=>'html',
                'value'=>function($model){
                    $title=$model->title;
                    if($model->is_hot){
                        $title.='<span class="text-danger">[推荐]</span>&nbsp;&nbsp;';
                    }
                    if($model->is_index){
                        $title.='<span class="text-danger">[首页]</span>';
                    }
                    return $title;
                },
                'options'=>[
                    'width'=>400
                ],
            ],

            //'content:html',
            // [
            //     'attribute'=>'click',
            //     'options'=>[
            //         'width'=>100
            //     ],
            // ],
            // 'description',
            [
                'attribute'=>'created_at',
                'format'=>'datetime',
                'options'=>[
                    'width'=>160
                ],
            ],
            // 'updated_at',
            // 'news_cat_id',
            // 'status',
            // 'sort',
             [
                'attribute'=>'is_hot',
                'format'=>'html',
                'value'=>function($model)use($page){
                    return $model->is_hot==0?Html::a('<img src="/img/no.gif" alt="">',['set-hot','id'=>$model->id,'val'=>1,'page'=>$page]):Html::a('<img src="/img/yes.gif" alt="">',['set-hot','id'=>$model->id,'val'=>0,'page'=>$page]);
                },
                'filter'=>[1=>'已推荐',0=>'未推荐'],
             ],
             [
                'attribute'=>'is_index',
                'format'=>'html',
                'value'=>function($model)use($page){
                    return $model->is_index==0?Html::a('<img src="/img/no.gif" alt="">',['set-index','id'=>$model->id,'page'=>$page,'val'=>1]):Html::a('<img src="/img/yes.gif" alt="">',['set-index','id'=>$model->id,'page'=>$page,'val'=>0]);
                },
                'filter'=>[1=>'已推荐',0=>'未推荐'],

             ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{delete}',
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    'delete'=>function($url){
                        return Html::a('删除',$url,['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
                    },

                ],
                'options'=>[
                    'width'=>'200',
                ],

            ],
        ],
    ]); ?>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsCatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章栏目';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-cat-index">
    <p>
        <?= Html::a('新建栏目', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
           // 'pid',
            'sort',

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
                    'width'=>'320',
                ],

            ],
        ],
    ]); ?>
</div>

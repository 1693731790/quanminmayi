<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SysarticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统文章';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sysarticle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'article_id',
            'title',
            //'title_img',
            //'key',
            //'desc',
            // 'content:ntext',
            // 'create_time:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}',//
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    
                    
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
</div>

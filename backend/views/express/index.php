<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ExpressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '快递列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="express-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <a href="/express/ExpressCode.xls" class="btn btn-primary btn-sm">查看快递公司编码</a>

    <p style="margin-top: 5px;">
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'express_id',
            'name',
            'code',

           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',//
                'buttons'=>[
                                        
                    'delete'=>function($url,$model){
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

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的银行卡';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-bank-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            
            'name',
            'bank_name',
            'account',
            'phone',

           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}',//{delete}
                'buttons'=>[
                    'update'=>function($url){
                        return Html::a('修改',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
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

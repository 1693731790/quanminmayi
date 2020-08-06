<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JdGoods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '京东商品', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jd-goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'jdgoods_id',
            'name',
            'brand',
            'type',
            'thumbnailImage',
            'productCate',
            'productCode',
            'status',
            'marketPrice',
            'retailPrice',
            'productPlace',
            'features',
            'tax',
            'imageUrl:ntext',
            'orderSort',
            'content:ntext',
            'mobile_content:ntext',
            'create_time:datetime',
        ],
    ]) ?>

</div>

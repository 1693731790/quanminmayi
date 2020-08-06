<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsSeckill */

$this->title = '修改: ' . $model->goods_id;
$this->params['breadcrumbs'][] = ['label' => '秒杀商品', 'url' => ['index']];

?>
<div class="goods-seckill-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

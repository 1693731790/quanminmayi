<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GoodsSeckill */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '秒杀商品', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-seckill-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

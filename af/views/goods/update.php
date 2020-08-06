<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '修改商品: ' . $model->goods_name;
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goods_id, 'url' => ['view', 'id' => $model->goods_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="goods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'attr' => $attr,
        'cateone' => $cateone,
        'catetwo' => $catetwo,
        'catethree' => $catethree,
      

    ]) ?>

</div>

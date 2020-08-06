<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '添加商品';
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'attr' => $attr,
        'cateone' => $cateone,
        'catetwo' => $catetwo,
        'catethree' => $catethree,
      
  
    ]) ?>

</div>

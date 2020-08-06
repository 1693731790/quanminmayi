<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Supplier */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '供货商', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
  		'shop_id' => $shop_id,
    ]) ?>

</div>

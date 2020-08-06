<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Shops */

$this->title = '修改店铺: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '店铺列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->shop_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="shops-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

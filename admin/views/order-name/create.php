<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OrderName */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '随机订单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-name-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

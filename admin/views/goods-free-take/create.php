<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GoodsFreeTake */

$this->title = '添加';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-free-take-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

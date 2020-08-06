<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SpikeTime */

$this->params['breadcrumbs'][] = '修改';
?>
<div class="spike-time-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

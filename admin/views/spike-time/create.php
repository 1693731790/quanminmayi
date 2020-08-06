<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SpikeTime */

$this->title = '添加';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spike-time-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

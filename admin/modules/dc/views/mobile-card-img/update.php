<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MobileCardImg */

$this->title = '修改: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '电话卡封面', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->mi_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="mobile-card-img-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

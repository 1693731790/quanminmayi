<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ads */

$this->title = '编辑广告: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '广告列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->ads_id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="ads-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

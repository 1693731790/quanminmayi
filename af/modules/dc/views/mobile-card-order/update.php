<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MobileCardOrder */

$this->title = 'Update Mobile Card Order: ' . $model->mo_id;
$this->params['breadcrumbs'][] = ['label' => 'Mobile Card Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mo_id, 'url' => ['view', 'id' => $model->mo_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mobile-card-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

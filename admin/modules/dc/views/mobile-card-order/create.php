<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MobileCardOrder */

$this->title = 'Create Mobile Card Order';
$this->params['breadcrumbs'][] = ['label' => 'Mobile Card Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mobile-card-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

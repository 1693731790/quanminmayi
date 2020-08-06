<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Wallet */

$this->title = 'Update Wallet: ' . $model->wid;
$this->params['breadcrumbs'][] = ['label' => 'Wallets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->wid, 'url' => ['view', 'id' => $model->wid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wallet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

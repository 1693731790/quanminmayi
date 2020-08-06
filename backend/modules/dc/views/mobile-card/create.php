<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MobileCard */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '电话卡', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mobile-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

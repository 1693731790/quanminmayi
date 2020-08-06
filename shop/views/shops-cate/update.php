<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopsCate */

$this->title = '修改 ' . $model->title;

?>
<div class="shops-cate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

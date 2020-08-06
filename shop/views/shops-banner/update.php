<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopsBanner */

$this->title = '修改';

?>
<div class="shops-banner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

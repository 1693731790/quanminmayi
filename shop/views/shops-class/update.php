<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopsClass */

$this->title = '修改';

?>
<div class="shops-class-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
  'shop_id' => $shop_id,
    ]) ?>

</div>

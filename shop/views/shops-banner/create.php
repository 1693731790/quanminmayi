<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ShopsBanner */

$this->title = '添加';

?>
<div class="shops-banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
  		'shop_id' => $shop_id,
    ]) ?>

</div>

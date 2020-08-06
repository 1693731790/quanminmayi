<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AfCode */

$this->title = $model->id;

?>
<div class="af-code-view">

    <h1><?= Html::encode($this->title) ?></h1>

  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'batch_num',
            'number',
            'distributor_id',
            'goods_id',
            'status',
            'create_time:datetime',
        ],
    ]) ?>

</div>

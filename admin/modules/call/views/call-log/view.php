<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CallLog */

$this->title = $model->id;

?>
<div class="call-log-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'start_time:datetime',
            'end_time:datetime',
            'call_time',
            'guishudi',
            'mobile_ip',
            'openid',
            'lon',
            'lat',
            'fee',
            'balance',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Distributor */

$this->title = $model->name;

?>
<div class="distributor-view">

    <h1><?= Html::encode($this->title) ?></h1>

  

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'd_id',
           // 'balance',
            'user_id',
            'name',
            'id_num',
            'phone',
            'company_name',
            'address',
            'status',
            'create_time:datetime',
        ],
    ]) ?>

</div>

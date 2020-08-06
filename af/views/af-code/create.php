<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AfCode */

$this->title = '添加';

?>
<div class="af-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

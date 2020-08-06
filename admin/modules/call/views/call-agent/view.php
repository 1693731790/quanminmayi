<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;

$this->params['breadcrumbs'][] = $this->title;
?>
<style>
  th{width:200px;}
</style>
<div class="user-view">

    <h1>用户信息</h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
           // 'parent_id',
            
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            "money",
            "type",
            ['attribute'=>'id_front',
                 'format' => 'raw',
                 'value'  => function($model){
                   if($model->id_front!="")
                        return "<a href='".$model->id_front."' class='btn btn-sm btn-success marr5' target='_blank' >查看</a>";
                 },
            ],
            
            ['attribute'=>'id_back',
                 'format' => 'raw',
                 'value'  => function($model){
                   if($model->id_back!="")
                        return "<a href='".$model->id_back."' class='btn btn-sm btn-success marr5' target='_blank' >查看</a>";
                 },
            ],
            "id_num",
            
            ['attribute'=>'corp_code',
                 'format' => 'raw',
                 'value'  => function($model){
                   if($model->corp_code!="")
                        return "<a href='".$model->corp_code."' class='btn btn-sm btn-success marr5' target='_blank' >查看</a>";
                 },
            ],
            "phone",
            "address",
            "realname",
            "corp_name",
            ['attribute'=>'contract',
                 'format' => 'raw',
                 'value'  => function($model){
                   if($model->contract!="")
                        return "<a href='".$model->contract."' class='btn btn-sm btn-success marr5' target='_blank' >查看</a>";
                 },
            ],
          
            'status',
            'created_at:datetime',
            
        ],
    ]) ?>

</div>

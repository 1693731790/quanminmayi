<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">
    <p>
        <?= Html::a('添加管理员', ['signup'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'name',
            //'phone',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
             // 'email:email',
             [
                'attribute'=>'status',
                'format'=>'html',
                'value'=>function($mdoel){
                    return $mdoel->status==10?'<span class="text-success">正常</span>':'<span class="text-danger">已禁用</span>';
                },
                'filter'=>[0=>'已禁用','正常']
             ],
             'created_at:datetime',
            // 'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{disabled}{active}{assignment/view}{update}{repassword}',
                'buttons'=>[
                    'disabled'=>function($url,$model){
                        if($model->status==0){
                            return false;
                        }
                        return Html::a('禁用',$url,['class'=>'btn btn-sm btn-danger marr5','data-confirm'=>'确定要禁用此账号?']);
                    },
                    'active'=>function($url,$model){
                        if($model->status==10){
                            return false;
                        }
                        return Html::a('启用',$url,['class'=>'btn btn-sm btn-success marr5','data-confirm'=>'确定要启用此账号?']);
                    },                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'assignment/view'=>function($url){
                        return Html::a('分配权限',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    'repassword'=>function($url){
                        return Html::a('修改密码',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    'delete'=>function($url){
                        return Html::a('删除',$url,['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
                    },

                ],
                'options'=>[
                    'width'=>'320',
                ],
            ],
        ],
    ]); ?>
</div>

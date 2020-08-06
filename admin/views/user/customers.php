<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index app">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'id',
                'options'=>[
                    'width'=>70,
                ],
            ],
            [
                'attribute'=>'headimgurl',
                'format'=>'html',
                'label'=>'头像',
                'value'=>function($model){
                    return Html::img($model->headimgurl,['width'=>100,'height'=>100]);
                },
                'options'=>[
                    'width'=>110,
                ],
            ],

            [
                'attribute'=>'realname',
                
               
                'options'=>[
                    'width'=>120,
                ],
            ],
            [
                'attribute'=>'phone',
                'label'=>'手机号',
                'value'=>function($model){
                    return $model->phoneAuth->identifier;
                },
                'options'=>[
                    'width'=>150,
                ],
            ],
          [
                'attribute'=>'wx',
                'label'=>'第三方登录名',
                'value'=>function($model){
                    if(isset($model->wxAuth->identifier))
                    {
                        return $model->wxAuth->identifier;    
                    }else{
                        return "未设置";
                    }
                    
                },
                'options'=>[
                    'width'=>200,
                ],
            ],
            
            [
                'attribute'=>'wallet',
                'options'=>[
                    'width'=>100,
                ],
            ],
          /*  [
                'attribute'=>'integral',
                'value'=>function($model){
                    return intval($model->integral);
                },
                'options'=>[
                    'width'=>100,
                ],
            ],*/
           /* [
                'attribute'=>'invitation_code',
                'options'=>[
                    'width'=>200,
                ],
            ],*/
         [
                'attribute'=>'',
                'label'=>'通话记录',
              'format' => 'raw',
              	'value'  => function($model){
                    return "<a href='".Url::to(["/call/call-log/index","user_id"=>$model->id])."' class='btn btn-sm btn-warning marr5' >通话记录</a>";
                    
                 },
                'options'=>[
                    'width'=>150,
                ],
            ],
			[
                'attribute'=>'',
                'label'=>'话费余额记录',
              'format' => 'raw',
              	'value'  => function($model){
                    return "<a href='".Url::to(["/call/user-callfee-log/index","user_id"=>$model->id])."' class='btn btn-sm btn-warning marr5' >话费余额记录</a>";
                    
                 },
                'options'=>[
                    'width'=>150,
                ],
            ],
          [
                'attribute'=>'created_at',
                
              	'value'  => function($model){
                    return date("Y-m-d H:i:s",$model->created_at);
                    
                 },
                'options'=>[
                    'width'=>150,
                ],
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{updatepwd}',
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info']);
                    },
                     'updatepwd'=>function($url){
                        return Html::a('修改密码',$url,['class'=>'btn btn-sm btn-success']);
                    },
                ],
                'options'=>[
                    'width'=>'260',
                ],

            ],
        ],
    ]); ?>
</div>

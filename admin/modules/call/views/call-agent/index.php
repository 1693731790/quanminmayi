<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use common\models\Upconf;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '电话卡代理商列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                "attribute"=>'id',
                'options'=>[
                    'width'=>'70',
                ],
            ],
          //  'parent_id',
            
         
           ["attribute"=>"username",
             	
               'options'=>[
                    'width'=>'150',
                ],
             ],
            
            //'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            

       
             
           [
              "attribute"=>'status',
              'format' => 'raw',
             	'value'  => function($model){
                    if($model->status=="200")
                    {
                        return "正常";
                    }else{
                        return "<a onclick='isstatus(".$model->id.")' class='btn btn-sm btn-warning marr5' >设为正常</a>";
                    }
                    
                 },
                'options'=>[
                    'width'=>'60',
                ],
            ],
          ["attribute"=>'created_at',
             	'value'  => function($model){
                  	return date("Y-m-d H:i:s",$model->created_at);
                },
               'options'=>[
                    'width'=>'130',
                ],
             ],
             
            // 'updated_at',

           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{updatepwd}',//
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    
                    'updatepwd'=>function($url,$model){
                        return Html::a('修改密码',$url,['class'=>'btn btn-sm btn-danger marr5']);
                    },
                 
                ],
                'options'=>[
                    'width'=>'300',
                ],
            ],
        ],
    ]); ?>
</div>

<script>
    function isstatus(id)
    {
        $.get("<?=Url::to(['user/status'])?>",{"user_id":id},function(r){
            if(r.success)
            {
                layer.msg(r.message);
              	setTimeout(function(){
                	window.location.reload();
                },1500);
                
            }else{
                layer.msg(r.message);
            }
        },'json')
    }
</script>

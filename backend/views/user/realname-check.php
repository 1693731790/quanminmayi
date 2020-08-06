<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '实名认证';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .btn-sm{margin-right: 15px;}
    .user-index img{width:50px;height:50px;}
</style>
<div class="user-index app" id="app">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                 'attribute'=>'id',
                'options'=>[
                    'width'=>'100',
                ],
            ],
            [
                 'attribute'=>'card_check_status',
                'label'=>'状态',
                'value'=>function($model){
                    return Yii::$app->params['check_status'][$model->card_check_status];
                },
                'filter'=>Yii::$app->params['check_status'],
                'options'=>[
                    'width'=>'100',
                ],
            ],
            //'name',
            [
                'attribute'=>'phone',
                'label'=>'手机号',
                'value'=>function($model){
                    return $model->phoneAuth->identifier;
                },
                'options'=>[
                    'width'=>120,
                ],
            ],
       
            //'sex',
            //'age',
            //'nickname',
            // [
            //     'attribute'=>'headimgurl',
            //     'format'=>'html',
            //     'label'=>'头像',
            //     'value'=>function($model){
            //         return Html::img($model->headimgurl,['width'=>150,'height'=>150]);
            //     },
            // ],
            [
                'attribute'=>'realname',
                'label'=>'真实姓名',
                'options'=>[
                    'width'=>100,
                ]
            ],
            [
                'attribute'=>'card_id',
                'label'=>'证件号码',
                'options'=>[
                    'width'=>100,
                ]
            ],
            [
                'attribute'=>'card_photo_front',
                'format'=>'image',
                'label'=>'身份证正面照片',
                'options'=>[
                    'width'=>40,
                ]
            ],
            [
                'attribute'=>'card_photo_back',
                'format'=>'image',
                'label'=>'身份证背面照片',
                'options'=>[
                    'width'=>40,
                ]
            ],
            [
                'attribute'=>'card_photo_hold',
                'format'=>'image',
                'label'=>'手持身份证照片',
                'options'=>[
                    'width'=>40,
                ]
            ],
            [
                'attribute'=>'driver_license_photo',
                'format'=>'image',
                'label'=>'驾驶证照片（司机）',
                'options'=>[
                    'width'=>40,
                ]
            ],
            [
                'attribute'=>'vehicle_license_photo',
                'format'=>'image',
                'label'=>'行驶证照片（司机）',
                'options'=>[
                    'width'=>40,
                ]
            ],
            // 'headimg',
            //  'wallet',
            // 'integral',
            // 'integral_already',
            // 'integral_unavailable',
            // 'auth_key',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'version',
            // 'uid',
            // 'access_token',
            // 'invitation_code',
            // 'is_driver',
            [
                'attribute'=>'user_type',
                'label'=>'账号类型',
                'value'=>function($model){
                    return Yii::$app->params['user_type'][$model->user_type];
                },
                'filter'=>Yii::$app->params['user_type'],
                'options'=>[
                    'width'=>130,
                ]
            ],

            [
                'attribute'=>'realname_sub_time',
                'format'=>'datetime',
                'label'=>'申请时间',
                'options'=>[
                    'width'=>100,
                ]
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{realname-ok}{realname-no}',
                'buttons'=>[
                    'realname-ok'=>function($url,$model){
                        if($model->card_check_status==1){
                            return Html::a('通过',$url,['class'=>'btn btn-sm btn-success']);
                        }else{
                            return '<button class="btn btn-sm btn-success" disabled="disabled">通过</button>';
                        }
                    },
                    'realname-no'=>function($url,$model){
                        if($model->card_check_status==1){
                            return '<button class="btn btn-sm btn-danger btn-refuse" data-id="'.$model->id.'" >拒绝</button>';
                        }else{
                            return '<button class="btn btn-sm btn-danger btn-refuse" disabled="disabled" data-id="'.$model->id.'" >拒绝</button>';
                        }
                    },

                ],
                'options'=>[
                    'width'=>'180',
                ],

            ],
        ],
    ]); ?>

<el-dialog title="审核拒绝"  width="30%" :visible.sync="dialog">
<textarea name="" id="" cols="30" rows="10" class="form-control" placeholder="请填写认证失败原因" v-model="check_msg"></textarea>
<br>
<p class="text-center"><span class="btn btn-sm btn-default" @click="dialog=false">取消</span><span class="btn btn-sm btn-danger" @click="save">提交</span></p>
</el-dialog>

</div>

<script>
    $(function(){
        var vm=new Vue({
            el:'#app',
            data:{
                dialog:false,
                id:null,
                check_msg:null,
            },
            methods:{
                save:function(){
                    $.get("<?=Url::to(['realname-no'])?>",{id:vm.id,msg:vm.check_msg},function(res){
                        if(res.success){
                            layer.msg('操作成功');
                            vm.dialog=false;
                        }else{
                            layer.msg('操作失败');
                        }
                    },'json');
                },
            },
        });

        $('.btn-refuse').on('click',function(){
            var id=$(this).attr('data-id');
            if(id!=vm.id){
                vm.check_msg=null;
                vm.id=id;
            }
            vm.dialog=true;

        });
    });
</script>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="app">
    <div class="row">
       <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">基本信息</div>
          <div class="panel-body">
            <table class="table table-bordered" style="float:left;">
              <tr>
                  <th width="20%" >会员头像</th><td width="30%" ><img src="<?=$model->headimgurl?>" alt="" width="55" height="55"></td>
                  <th width="20%">注册时间</th><td width="30%"><?=Yii::$app->formatter->asDatetime($model->created_at)?></td>
                 
              </tr>
             
              <tr>
                  <th>注册手机号</th><td><?=$model->phone?></td>
                  <th>用户名</th><td><?=$model->username?></td>
              </tr>
              <tr>
                  <th>真实姓名</th><td><?=$model->realname?></td>
                  <th>推广码</th><td><?=$model->invitation_code?></td>
                  
                 
              </tr>
              
            </table>
          </div>
        </div>
       </div>
       <div class="col-md-6">
        <div class="panel panel-info">
          <div class="panel-heading">财务信息</div>
          <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                  <th width="20%">钱包余额</th><td width="30%"><?=$model->wallet?>&nbsp;&nbsp;</td>
                  <th width="20%">待收入金额</th><td width="30%"><?=$model->wait_wallet?></td>
              </tr>
              <tr>
                  <th width="20%">充值卡金额</th><td width="30%"><?=$model->recharge_fee?>&nbsp;&nbsp;</td>
                  
              </tr>
             
              
            </table>
          </div>
        </div>
       </div>
       <div class="col-md-12">
        <a class="btn btn-success" href="<?=Url::to(["order/index","user_id"=>$model->id])?>">查看该用户订单列表</a>
       </div>
    </div>

</div>
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\WithdrawCash */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => '提现', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">提现信息</div>
          <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th width="20%">申请时间</th><td width="30%"><?=date("Y-m-d H:i:s",$model->create_time)?></td>
                    <th width="20%">状态</th><td width="30%"><?=Yii::$app->params['withdraw_cash_status'][$model->status]?></td>
                </tr>
                <tr>
                    <th width="20%">提现金额</th><td width="30%"><?=$model->fee?></td>
                    <th width="20%">联系电话</th><td width="30%"><?=$model->phone?></td>
                </tr>
                <tr>
                    <th width="20%">处理时间</th><td width="30%"><?=$model->handle_time!=""?date("Y-m-d H:i:s",$model->handle_time):''?></td>
                    <th width="20%">备注</th><td width="30%"><?=$model->remark?></td>
                    
                    
                </tr>
                
          </table>
            <table class="table table-bordered">
                <tr>
                    <th width="20%">持卡人</th><td width="30%"><?=$bank->name?></td>
                    <th width="20%">手机号</th><td width="30%"><?=$bank->phone?></td>
                </tr>
                <tr>
                    <th width="20%">银行</th><td width="30%"><?=$bank->bank_name?></td>
                    <th width="20%">卡号</th><td width="30%"><?=$bank->account?></td>
                    
                </tr>
          </table>
          </div>
        </div>
    </div>
   
</div>
    